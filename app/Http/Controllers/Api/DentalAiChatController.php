<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DentalAiChatController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:12',
            'history.*.role' => 'nullable|string|in:user,assistant',
            'history.*.text' => 'nullable|string|max:1500',
        ]);

        $userMessage = trim($validated['message']);
        $history = $validated['history'] ?? [];

        $services = Service::where('is_active', true)->orderBy('price')->get();
        $doctors = Doctor::with('user')->whereHas('user')->orderBy('id')->get();
        $clinicSettings = array_merge([
            'clinic_name' => 'Nha Khoa Smile',
            'clinic_address' => '204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội',
            'clinic_hotline' => '0775 761 388',
        ], SystemSetting::pluck('setting_value', 'setting_key')->toArray());
        foreach (['clinic_name' => 'Nha Khoa Smile', 'clinic_address' => '204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội', 'clinic_hotline' => '0775 761 388'] as $key => $default) {
            if (!isset($clinicSettings[$key]) || trim((string) $clinicSettings[$key]) === '') {
                $clinicSettings[$key] = $default;
            }
        }

        // Phân tích ngữ cảnh đa lượt + dữ liệu thật từ DB
        $matched = $this->applyClinicSettings($this->analyzeIntent($userMessage, $history, $services, $doctors), $clinicSettings);

        // Ưu tiên Gemini AI nếu đã cấu hình GEMINI_API_KEY
        $geminiReply = $this->tryGeminiReply($userMessage, $history, $services, $doctors, $clinicSettings);

        if ($geminiReply !== null) {
            $geminiReply = $this->replaceClinicText($geminiReply, $clinicSettings);
            return response()->json([
                'success' => true,
                'engine' => 'gemini',
                'reply' => $geminiReply,
                'actions' => $matched['actions'],
            ]);
        }

        return response()->json([
            'success' => true,
            'engine' => 'clinic-ai',
            'reply' => $matched['reply'],
            'actions' => $matched['actions'],
        ]);
    }

    private function applyClinicSettings(array $response, array $settings): array
    {
        $response['reply'] = $this->replaceClinicText((string) ($response['reply'] ?? ''), $settings);
        $phoneDigits = preg_replace('/\D+/', '', (string) ($settings['clinic_hotline'] ?? ''));

        foreach ($response['actions'] ?? [] as &$action) {
            if (!empty($action['label'])) {
                $action['label'] = str_replace('0775 761 388', $settings['clinic_hotline'], $action['label']);
            }
            if (!empty($action['url'])) {
                $action['url'] = str_replace('tel:0775761388', 'tel:' . $phoneDigits, $action['url']);
                if (str_contains($action['url'], 'google.com/maps')) {
                    $action['url'] = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($settings['clinic_address']);
                }
            }
        }
        unset($action);

        return $response;
    }

    private function replaceClinicText(string $text, array $settings): string
    {
        return str_replace(
            ['Nha Khoa Smile', '204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội', '204 Trần Duy Hưng', '0775 761 388'],
            [$settings['clinic_name'], $settings['clinic_address'], $settings['clinic_address'], $settings['clinic_hotline']],
            $text
        );
    }

    protected function tryGeminiReply(string $userMessage, array $history, $services, $doctors, array $clinicSettings): ?string
    {
        $apiKey = config('services.gemini.api_key') ?? env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return null;
        }

        $serviceLines = $services->map(function ($s) {
            $price = number_format((float) $s->price, 0, ',', '.') . ' VNĐ';
            $dur = max(15, (int) ($s->duration_minutes ?? 30));
            return "- {$s->name}: {$price} (~{$dur} phút)";
        })->implode("\n");

        $doctorLines = $doctors->map(function ($d) {
            $name = $d->user->name ?? ('Bác sĩ #' . $d->id);
            $spec = $d->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
            return "- {$name} ({$spec})";
        })->implode("\n");

        $systemPrompt = <<<PROMPT
Bạn là Chuyên viên Tư vấn Nha khoa AI cao cấp của phòng khám {$clinicSettings['clinic_name']} (Hệ thống DCMS).
Thông tin phòng khám:
- Địa chỉ: {$clinicSettings['clinic_address']}.
- Hotline đặt hẹn & cấp cứu: {$clinicSettings['clinic_hotline']}.
- Giờ làm việc: 08:00 – 20:00 tất cả các ngày (Thứ 2 – Chủ Nhật).
- Đặt lịch online: Từ ngày mai trở đi (08:00–20:00). Cần khám ngay trong ngày: mời đến trực tiếp phòng khám hoặc gọi Hotline {$clinicSettings['clinic_hotline']}.
- Thanh toán: Tiền mặt, thẻ POS, chuyển khoản VietQR MBBank tự động xác nhận qua SePay và xuất hóa đơn điện tử VAT.

Bảng giá dịch vụ niêm yết hiện tại:
{$serviceLines}

Đội ngũ Bác sĩ Chuyên khoa:
{$doctorLines}

Phong cách trả lời:
1. Xưng hô lịch sự, chuyên nghiệp chuẩn y khoa ("{$clinicSettings['clinic_name']}" / "Anh/Chị" hoặc "Quý khách").
2. Ngắn gọn, súc tích, chia ý rõ ràng bằng gạch đầu dòng, in đậm (**...**) các thông tin quan trọng.
3. Chỉ dùng đúng giá và tên bác sĩ trong danh sách trên. Không tự kê đơn kháng sinh; luôn nhắc thăm khám trực tiếp & chụp phim khi có triệu chứng bệnh lý.
PROMPT;

        $contents = [];
        foreach (array_slice($history, -8) as $turn) {
            $text = trim((string) ($turn['text'] ?? ''));
            if ($text === '') {
                continue;
            }
            $contents[] = [
                'role' => ($turn['role'] ?? 'user') === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $text]],
            ];
        }
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        try {
            $primaryModel = config('services.gemini.model') ?: 'gemini-3.1-flash-lite';
            $candidateModels = array_values(array_unique([$primaryModel, 'gemini-3.1-flash-lite', 'gemini-flash-latest']));

            foreach ($candidateModels as $model) {
                $response = Http::timeout(12)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                        'systemInstruction' => ['parts' => [['text' => $systemPrompt]]],
                        'contents' => $contents,
                        'generationConfig' => [
                            'temperature' => 0.35,
                            'maxOutputTokens' => 500,
                        ],
                    ]);

                if ($response->successful()) {
                    $text = data_get($response->json(), 'candidates.0.content.parts.0.text');
                    if (is_string($text) && trim($text) !== '') {
                        return trim($text);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Dental AI Gemini fallback: ' . $e->getMessage());
        }

        return null;
    }

    protected function analyzeIntent(string $message, array $history, $services, $doctors): array
    {
        $normalized = Str::lower(Str::ascii($message));

        // Đọc ngữ cảnh từ 3 tin nhắn gần nhất để hiểu câu hỏi nối tiếp ("giá bao nhiêu?", "có đau không?", "mất bao lâu?"...)
        $recentContext = Str::lower(Str::ascii(
            collect(array_slice($history, -4))->pluck('text')->implode(' ')
        ));

        $findService = function (array $keywords) use ($services) {
            foreach ($services as $srv) {
                $name = Str::lower(Str::ascii($srv->name));
                foreach ($keywords as $kw) {
                    if (str_contains($name, $kw)) {
                        return $srv;
                    }
                }
            }
            return null;
        };

        $findDoctor = function (array $keywords) use ($doctors) {
            foreach ($doctors as $doc) {
                $haystack = Str::lower(Str::ascii(($doc->user->name ?? '') . ' ' . ($doc->specialty ?? '')));
                foreach ($keywords as $kw) {
                    if (str_contains($haystack, $kw)) {
                        return $doc;
                    }
                }
            }
            return $doctors->first();
        };

        $bookingUrl = function ($service = null, $doctor = null): string {
            $params = [];
            if ($service) {
                $params['service_id'] = $service->id;
            }
            if ($doctor) {
                $params['doctor_id'] = $doctor->id;
            }
            return route('public.booking', $params);
        };

        $detectTopic = function (string $text): ?string {
            if (Str::contains($text, ['rang khon', 'moc lech', 'loi trum', 'nho rang', 'piezotome'])) return 'wisdom';
            if (Str::contains($text, ['implant', 'mat rang', 'trong rang', 'straumann', 'tieu xuong'])) return 'implant';
            if (Str::contains($text, ['nieng rang', 'chinh nha', 'invisalign', 'mac cai', 'khap khenh', 'rang ho', 'rang mom'])) return 'ortho';
            if (Str::contains($text, ['rang su', 'veneer', 'boc su', 'cercon', 'me rang'])) return 'veneer';
            if (Str::contains($text, ['tay trang', 'o vang', 'xin mau', 'laser'])) return 'whitening';
            if (Str::contains($text, ['viem tuy', 'dieu tri tuy', 'noi nha'])) return 'root_canal';
            if (Str::contains($text, ['cao rang', 'voi rang', 'chay mau chan rang', 'viem loi', 'viem nuou'])) return 'scaling';
            if (Str::contains($text, ['sau rang', 'tram rang', 'e buot'])) return 'filling';
            return null;
        };

        $currentTopic = $detectTopic($normalized);
        $contextTopic = $currentTopic ?? $detectTopic($recentContext);

        // 0. Lời chào / Cảm ơn
        if (preg_match('/^(xin chao|chao|hello|hi|alo|ad oi|shop oi|cho hoi)[\s!?.]*$/', $normalized)) {
            return [
                'reply' => "Kính chào Quý khách đến với **Nha Khoa Smile**!\n\n"
                    . "Em là Trợ lý Tư vấn Y khoa AI, sẵn sàng hỗ trợ Anh/Chị 24/7 về:\n"
                    . "• **Tư vấn triệu chứng & phác đồ** (răng khôn, Implant, niềng răng, răng sứ, điều trị tủy...)\n"
                    . "• **Báo giá niêm yết & thời gian thực hiện** từ hệ thống phòng khám\n"
                    . "• **Kiểm tra lịch trống của Bác sĩ** và đặt lịch ưu tiên không cần chờ đợi\n\n"
                    . "Anh/Chị đang quan tâm đến vấn đề răng miệng nào để em tư vấn chi tiết ạ?",
                'actions' => [
                    ['label' => '💰 Xem Bảng giá', 'url' => route('public.services'), 'primary' => false],
                    ['label' => '📅 Đặt lịch khám', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        if (Str::contains($normalized, ['cam on', 'thank', 'ok ban', 'ok em', 'tot qua', 'tuyet voi']) && mb_strlen($normalized) < 35) {
            return [
                'reply' => "Rất hân hạnh được đồng hành cùng Anh/Chị! Nếu cần hỗ trợ thêm về lịch khám, chi phí hay chăm sóc răng miệng sau điều trị, Anh/Chị cứ nhắn cho Nha Khoa Smile bất cứ lúc nào nhé.",
                'actions' => [
                    ['label' => '📅 Đặt lịch khám', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 1. So sánh / hỏi đồng thời cả Niềng răng & Bọc răng sứ
        if (Str::contains($normalized, ['nieng rang', 'chinh nha', 'invisalign']) && Str::contains($normalized, ['rang su', 'veneer', 'boc su'])) {
            $srvOrtho = $findService(['nieng rang']);
            $srvCrown = $findService(['cercon']);
            $srvVeneer = $findService(['veneer']);
            $pOrtho = $srvOrtho ? number_format((float) $srvOrtho->price, 0, ',', '.') . ' đ' : 'xem bảng giá hiện hành';
            $pCrown = $srvCrown ? number_format((float) $srvCrown->price, 0, ',', '.') . ' đ' : 'xem bảng giá hiện hành';
            $pVeneer = $srvVeneer ? number_format((float) $srvVeneer->price, 0, ',', '.') . ' đ' : 'xem bảng giá hiện hành';

            return [
                'reply' => "Để Anh/Chị dễ lựa chọn giữa **Niềng răng** và **Bọc răng sứ**, Nha Khoa Smile tóm tắt nhanh theo chỉ định y khoa:\n\n"
                    . "• **" . ($srvOrtho?->name ?? 'Niềng răng chỉnh nha') . " ({$pOrtho}):** Phù hợp khi răng chen chúc, hô/móm, sai khớp cắn — **bảo tồn 100% răng thật**, hiệu quả vĩnh viễn (thời gian 12–24 tháng).\n"
                    . "• **Bọc răng sứ Cercon HT ({$pCrown}/răng) hoặc dán Veneer Emax ({$pVeneer}/răng):** Phù hợp khi răng xỉn màu nặng, sứt mẻ, hình thể nhỏ/thưa nhẹ — hoàn thiện thẩm mỹ nhanh chỉ sau **2 buổi (3–5 ngày)**.\n\n"
                    . "Anh/Chị nên chụp phim & thăm khám trực tiếp để Bác sĩ đo khớp cắn và tư vấn phương án bảo tồn răng tốt nhất.",
                'actions' => [
                    ['label' => '📅 Đặt lịch tư vấn 1:1', 'url' => route('public.booking'), 'primary' => true],
                    ['label' => '✨ Xem bảng giá chi tiết', 'url' => route('public.services'), 'primary' => false],
                ],
            ];
        }

        // 2. Câu hỏi nối tiếp thông minh: "Có đau không?" / "Sợ đau"
        if (Str::contains($normalized, ['co dau khong', 'dau khong', 'so dau', 'gay te', 'e buot khong'])) {
            return [
                'reply' => "Anh/Chị hoàn toàn có thể yên tâm về trải nghiệm điều trị êm ái tại **Nha Khoa Smile**:\n\n"
                    . "• **Gây tê chuẩn Pháp (Septanest 4%):** Tác dụng nhanh, kiểm soát cảm giác đau hoàn toàn trong suốt quá trình làm thủ thuật.\n"
                    . "• **Công nghệ sóng siêu âm Piezotome:** Áp dụng cho nhổ răng khôn & tiểu phẫu, không làm tổn thương mô mềm, giảm sưng tối đa.\n"
                    . "• **Quy trình vô trùng 1 chiều & kê đơn giảm đau phù hợp** giúp hồi phục nhẹ nhàng sau điều trị.",
                'actions' => [
                    ['label' => '📅 Đặt lịch thăm khám nhẹ nhàng', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 3. Câu hỏi về Bảo hành / Chính hãng
        if (Str::contains($normalized, ['bao hanh', 'chinh hang', 'phoi su', 'the bao hanh', 'ben khong', 'duoc bao lau'])) {
            return [
                'reply' => "**Chính sách Bảo hành Chính hãng tại Nha Khoa Smile:**\n\n"
                    . "• **Trụ Implant Straumann (Thụy Sĩ):** Cam kết chính hãng 100%, bảo hành dài hạn/trọn đời theo tiêu chuẩn hãng.\n"
                    . "• **Răng sứ thẩm mỹ Cercon HT / Veneer Emax:** Bảo hành chính hãng **10 – 15 năm**, có mã tra cứu nguồn gốc phôi sứ.\n"
                    . "• Toàn bộ lịch sử điều trị và thông tin bảo hành được lưu trữ vĩnh viễn trên **Bệnh án điện tử DCMS**.",
                'actions' => [
                    ['label' => '🔍 Tra cứu hồ sơ DCMS', 'url' => route('public.lookup'), 'primary' => false],
                    ['label' => '📅 Đặt lịch tư vấn', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 4. Câu hỏi về Trả góp / Thanh toán
        if (Str::contains($normalized, ['tra gop', 'chia dot', 'chuyen khoan', 'quet ma', 'vietqr', 'hoa don vat'])) {
            return [
                'reply' => "**Chính sách Thanh toán & Trả góp tại Nha Khoa Smile:**\n\n"
                    . "• **Thanh toán linh hoạt:** Hỗ trợ tiền mặt, thẻ ngân hàng (POS) và **quét mã VietQR MBBank tự động xác nhận trong 3–5 giây**.\n"
                    . "• **Hỗ trợ thanh toán theo lộ trình / trả góp 0%** đối với các dịch vụ chuyên sâu như Niềng răng và Cấy ghép Implant.\n"
                    . "• Minh bạch từng hạng mục dịch vụ, đơn thuốc và xuất **Hóa đơn điện tử VAT** đầy đủ.",
                'actions' => [
                    ['label' => '🔐 Xem hóa đơn & VietQR', 'url' => route('patient.login'), 'primary' => false],
                    ['label' => '📅 Đặt lịch tư vấn', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 5. Câu hỏi về đối tượng đặc biệt: Mang thai / Trẻ em / Tiểu đường / Huyết áp / Dị ứng
        if (Str::contains($normalized, ['mang thai', 'co bau', 'ba bau', 'tre em', 'be ', 'tieu duong', 'huyet ap', 'di ung'])) {
            return [
                'reply' => "**Lưu ý Y khoa cho nhóm khách hàng cần chăm sóc đặc biệt:**\n\n"
                    . "• **Phụ nữ mang thai:** Tam cá nguyệt thứ 2 (tháng 4–6) là giai đoạn an toàn nhất cho các thủ thuật nha khoa cơ bản; tránh chụp X-quang không cần thiết.\n"
                    . "• **Bệnh nền (Tiểu đường, Huyết áp) & Dị ứng thuốc:** Bác sĩ sẽ kiểm tra chỉ số ổn định trước khi tiểu phẫu/Implant và ghi nhận cảnh báo dị ứng tự động trên hồ sơ DCMS khi kê đơn.\n"
                    . "• **Trẻ em:** Có Bác sĩ chuyên khoa Nha khoa trẻ em & tiền chỉnh nha theo dõi quá trình thay răng.",
                'actions' => [
                    ['label' => '📅 Đặt lịch tư vấn cùng Bác sĩ', 'url' => route('public.booking'), 'primary' => true],
                    ['label' => '📞 Hotline 0775 761 388', 'url' => 'tel:0775761388', 'primary' => false],
                ],
            ];
        }

        // 6. Hỏi lịch trống của Bác sĩ (đọc lịch thật ngày mai từ DB!)
        if (Str::contains($normalized, ['lich trong', 'co trong khong', 'gio trong', 'ngay mai', 'lich bac si', 'khi nao trong'])) {
            $tomorrow = Carbon::tomorrow();
            $dateStr = $tomorrow->toDateString();
            $dateLabel = $tomorrow->format('d/m/Y');

            $targetDoc = null;
            $cleanedForDocMatch = preg_replace('/\b(lich|gio|con|co|nao|khung gio|ngay mai)\s+trong\b/u', ' ', $normalized);
            $ignoreTokens = ['bs', 'ths', 'cki', 'ckii', 'bac', 'si', 'van', 'thi', 'duc', 'ngoc', 'minh', 'thu', 'hoang', 'phuong', 'nguyen', 'tran', 'le', 'mai', 'vu'];
            foreach ($doctors as $doc) {
                $docLower = Str::lower(Str::ascii($doc->user->name ?? ''));
                $docClean = preg_replace('/[^a-z0-9\s]/', ' ', $docLower);
                foreach (array_filter(explode(' ', $docClean)) as $part) {
                    if (strlen($part) >= 3 && !in_array($part, $ignoreTokens, true) && preg_match('/\b' . preg_quote($part, '/') . '\b/', $cleanedForDocMatch)) {
                        $targetDoc = $doc;
                        break 2;
                    }
                }
            }

            if ($targetDoc) {
                $busy = Appointment::getDoctorBusySlots($targetDoc->id, $dateStr);
                $docName = $targetDoc->user->name ?? 'Bác sĩ';
                $busyText = empty($busy)
                    ? "hiện **còn trống toàn bộ khung giờ (08:00 – 20:00)**"
                    : "đã có lịch ở khung giờ: **" . collect($busy)->map(fn ($s) => "{$s['start']}–{$s['end']}")->implode(', ') . "** (các khung giờ còn lại đều trống)";

                return [
                    'reply' => "Lịch làm việc ngày mai (**{$dateLabel}**) của **{$docName}**:\n\n"
                        . "• Bác sĩ {$busyText}.\n"
                        . "• Anh/Chị có thể bấm nút bên dưới để chọn đúng khung giờ mong muốn ngay ạ!",
                    'actions' => [
                        ['label' => "📅 Đặt lịch với {$docName}", 'url' => $bookingUrl(null, $targetDoc), 'primary' => true],
                    ],
                ];
            }

            return [
                'reply' => "Phòng khám mở cửa **08:00 – 20:00** tất cả các ngày (Thứ 2 – Chủ Nhật).\n\n"
                    . "• Khi vào trang **Đặt lịch Online**, Anh/Chị chỉ cần chọn **Bác sĩ** và **Ngày khám**, hệ thống sẽ **tự động hiển thị ngay các khung giờ đã kín / còn trống** theo thời gian thực!",
                'actions' => [
                    ['label' => '📅 Xem khung giờ trống & Đặt lịch', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 6.5. Hỏi về Đội ngũ / Số lượng Bác sĩ (ưu tiên TRƯỚC câu hỏi nối tiếp "bao nhiêu")
        if (Str::contains($normalized, ['bac si', 'bs ', 'chuyen gia', 'ai kham', 'doi ngu'])) {
            $docCount = $doctors->count();
            $docList = $doctors->map(function ($d) {
                $name = $d->user->name ?? ('Bác sĩ #' . $d->id);
                $spec = $d->specialty ?: 'Chuyên khoa Răng Hàm Mặt';
                return "• **{$name}** — {$spec}";
            })->implode("\n");

            return [
                'reply' => "Hiện tại **Nha Khoa Smile** có **{$docCount} Bác sĩ Chuyên khoa** trực tiếp thăm khám và điều trị:\n\n{$docList}\n\nAnh/Chị có thể chủ động chọn Bác sĩ mong muốn và xem khung giờ trống thực tế ngay trên trang Đặt lịch!",
                'actions' => [
                    ['label' => '👨‍⚕️ Xem hồ sơ Bác sĩ', 'url' => route('public.doctors'), 'primary' => true],
                    ['label' => '📅 Chọn Bác sĩ & Đặt lịch', 'url' => route('public.booking'), 'primary' => false],
                ],
            ];
        }

        // 7. Câu hỏi nối tiếp về Thời gian thực hiện ("mất bao lâu?")
        if (Str::contains($normalized, ['mat bao lau', 'bao lau', 'may buoi', 'thoi gian lam']) && $contextTopic) {
            $timelines = [
                'wisdom' => '**Nhổ răng khôn Piezotome:** Thực hiện khoảng **30 – 45 phút/răng** trong 1 buổi, tái khám cắt chỉ/kiểm tra sau 7 ngày.',
                'implant' => '**Cấy ghép Implant:** Đặt trụ mất khoảng **60 – 90 phút**, sau đó chờ tích hợp xương **3 – 6 tháng** trước khi gắn mão sứ hoàn chỉnh.',
                'ortho' => '**Niềng răng chỉnh nha:** Buổi gắn mắc cài đầu tiên khoảng **60 phút**; tổng lộ trình chỉnh nha từ **12 – 24 tháng** (tái khám 1 tháng/lần).',
                'veneer' => '**Bọc răng sứ / Dán Veneer:** Hoàn thiện nhanh trong **2 lần hẹn (3 – 5 ngày)**, mỗi buổi khoảng 60 phút.',
                'whitening' => '**Tẩy trắng răng Laser Whitening:** Hoàn tất ngay trong **1 buổi duy nhất (~60 phút)**.',
                'root_canal' => '**Điều trị tủy răng:** Từ **1 – 2 buổi** (mỗi buổi ~45 – 60 phút) tùy số lượng ống tủy.',
                'scaling' => '**Cạo vôi răng & Đánh bóng:** Thực hiện nhanh gọn trong **20 – 30 phút**.',
                'filling' => '**Trám răng thẩm mỹ Composite:** Hoàn tất trong **1 buổi (~30 phút)**.',
            ];
            return [
                'reply' => "Về thời gian thực hiện dự kiến:\n\n• " . ($timelines[$contextTopic] ?? 'Thời gian thăm khám trung bình từ **30 – 60 phút** tùy tình trạng răng miệng.') . "\n\nAnh/Chị có muốn đặt trước khung giờ thuận tiện nhất để không phải chờ đợi không ạ?",
                'actions' => [
                    ['label' => '📅 Đặt lịch ngay', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 8. Câu hỏi nối tiếp về Giá khi đã có ngữ cảnh trước đó (chỉ khớp khi hỏi về tiền/giá)
        if (
            Str::contains($normalized, ['bao nhieu tien', 'gia bao nhieu', 'het bao nhieu', 'ton bao nhieu', 'gia sao', 'chi phi', 'gia the nao'])
            && !$currentTopic
            && $contextTopic
        ) {
            $topicKeywords = [
                'wisdom' => ['rang khon'],
                'implant' => ['implant'],
                'ortho' => ['nieng rang'],
                'veneer' => ['rang su'],
                'whitening' => ['tay trang'],
                'root_canal' => ['tuy'],
                'scaling' => ['voi rang'],
                'filling' => ['tram rang'],
            ];
            $srv = $findService($topicKeywords[$contextTopic] ?? []);
            if ($srv) {
                $price = number_format((float) $srv->price, 0, ',', '.') . ' đ';
                $dur = max(15, (int) ($srv->duration_minutes ?? 30));
                return [
                    'reply' => "Chi phí niêm yết cho dịch vụ **{$srv->name}** tại Nha Khoa Smile là **{$price}** (thời lượng dự kiến ~{$dur} phút).\n\nChi phí thực tế sẽ được Bác sĩ báo rõ ràng trước khi điều trị, cam kết không phát sinh ngoài thỏa thuận.",
                    'actions' => [
                        ['label' => '📅 Đặt lịch dịch vụ này', 'url' => $bookingUrl($srv, null), 'primary' => true],
                        ['label' => '💰 Xem toàn bộ Bảng giá', 'url' => route('public.services'), 'primary' => false],
                    ],
                ];
            }
        }

        // 9. Các chủ đề chuyên môn cụ thể
        if ($currentTopic === 'wisdom') {
            $srv = $findService(['piezotome']);
            $doc = $findDoctor(['rang khon', 'tieu phau', 'trong']);
            $priceText = $srv ? number_format((float) $srv->price, 0, ',', '.') . ' đ' : 'vui lòng liên hệ phòng khám';
            $docName = $doc?->user?->name ?? 'BS. CKI Vũ Đức Trọng';

            return [
                'reply' => "**Tư vấn chuyên khoa Răng khôn:**\n\n"
                    . "Răng khôn mọc lệch hoặc lợi trùm dễ gây viêm sưng, đau lan góc hàm và làm sâu răng số 7 kế cận. Anh/Chị nên chụp phim kiểm tra hướng mọc sớm.\n"
                    . "• **Dịch vụ đề xuất:** " . ($srv->name ?? 'Nhổ răng khôn không đau (Piezotome)') . " — **{$priceText}**\n"
                    . "• **Bác sĩ phụ trách:** **{$docName}** (chuyên khoa Tiểu phẫu răng khôn)\n"
                    . "• **Chăm sóc tạm thời:** Súc miệng nước muối sinh lý ấm, chườm lạnh bên ngoài nếu sưng, không tự ý mua kháng sinh.",
                'actions' => [
                    ['label' => '📅 Đặt lịch nhổ răng khôn', 'url' => $bookingUrl($srv, $doc), 'primary' => true],
                    ['label' => '📞 Cấp cứu 0775 761 388', 'url' => 'tel:0775761388', 'primary' => false],
                ],
            ];
        }

        if ($currentTopic === 'implant') {
            $srv = $findService(['implant']);
            $doc = $findDoctor(['implant', 'nam']);
            $priceText = $srv ? number_format((float) $srv->price, 0, ',', '.') . ' đ' : 'vui lòng liên hệ phòng khám';
            $docName = $doc?->user?->name ?? 'BS. CKII Lê Hoàng Nam';

            return [
                'reply' => "**Tư vấn chuyên khoa Cấy ghép Implant:**\n\n"
                    . "Implant là giải pháp phục hồi răng mất tối ưu nhất hiện nay, khôi phục lực ăn nhai như răng thật và ngăn ngừa tiêu xương hàm.\n"
                    . "• **Dịch vụ đề xuất:** " . ($srv->name ?? 'Trồng răng Implant Straumann Thụy Sĩ') . " — **{$priceText}**\n"
                    . "• **Bác sĩ phụ trách:** **{$docName}** (hơn 3.000 ca cấy ghép thành công)\n"
                    . "• **Quy trình chuẩn:** Chụp phim CT ConeBeam 3D đánh giá mật độ xương → Lập kế hoạch số hóa → Đặt trụ nhẹ nhàng không đau.",
                'actions' => [
                    ['label' => '📅 Đặt lịch tư vấn Implant', 'url' => $bookingUrl($srv, $doc), 'primary' => true],
                    ['label' => '🦷 Chi tiết dịch vụ Implant', 'url' => route('public.service.detail', 'implant-chuyen-sau'), 'primary' => false],
                ],
            ];
        }

        if ($currentTopic === 'ortho') {
            $srv = $findService(['nieng rang']);
            $doc = $findDoctor(['invisalign', 'chinh nha', 'uyen', 'ha']);
            $priceText = $srv ? number_format((float) $srv->price, 0, ',', '.') . ' đ' : 'vui lòng liên hệ phòng khám';
            $docName = $doc?->user?->name ?? 'ThS. BS. Mai Phương Uyên';

            return [
                'reply' => "**Tư vấn chuyên khoa Chỉnh nha – Niềng răng:**\n\n"
                    . "Nha Khoa Smile cung cấp đầy đủ **niềng mắc cài tự buộc** và **niềng trong suốt Invisalign**, căn chỉnh khớp cắn chuẩn sinh học.\n"
                    . "• **Gói niêm yết:** " . ($srv->name ?? 'Niềng răng mắc cài kim loại tự buộc') . " — **{$priceText}** (hỗ trợ thanh toán theo lộ trình)\n"
                    . "• **Bác sĩ chuyên khoa:** **{$docName}**\n"
                    . "• Khi thăm khám, Bác sĩ sẽ scan 3D răng và cho Anh/Chị xem trước lộ trình dịch chuyển răng.",
                'actions' => [
                    ['label' => '📅 Đặt lịch tư vấn Niềng răng', 'url' => $bookingUrl($srv, $doc), 'primary' => true],
                    ['label' => '✨ Xem chi tiết Niềng răng', 'url' => route('public.service.detail', 'nieng-rang'), 'primary' => false],
                ],
            ];
        }

        if ($currentTopic === 'veneer') {
            $srv = $findService(['cercon']);
            $doc = $findDoctor(['phuc hinh', 'rang su', 'tran van']);
            $priceText = $srv ? number_format((float) $srv->price, 0, ',', '.') . ' đ' : 'vui lòng liên hệ phòng khám';
            $docName = $doc?->user?->name ?? 'BS. Trần Văn A';

            return [
                'reply' => "**Tư vấn Phục hình & Răng sứ Thẩm mỹ:**\n\n"
                    . "Phù hợp cho răng nhiễm màu nặng, sứt mẻ, thưa hoặc răng đã điều trị tủy cần bảo vệ.\n"
                    . "• **Dịch vụ đề xuất:** " . ($srv->name ?? 'Bọc răng sứ thẩm mỹ Cercon HT') . " — **{$priceText}/răng**\n"
                    . "• **Bác sĩ chuyên khoa:** **{$docName}**\n"
                    . "• Phôi sứ nhập khẩu chính hãng, thiết kế chuẩn màu tự nhiên và lưu bảo hành điện tử trên hệ thống DCMS.",
                'actions' => [
                    ['label' => '📅 Đặt lịch tư vấn Răng sứ', 'url' => $bookingUrl($srv, $doc), 'primary' => true],
                    ['label' => '✨ Xem chi tiết Răng sứ', 'url' => route('public.service.detail', 'rang-su-chuyen-sau'), 'primary' => false],
                ],
            ];
        }

        if ($currentTopic === 'whitening') {
            $srv = $findService(['laser whitening']);
            $doc = $findDoctor(['phuc hinh', 'rang su']);
            $priceText = $srv ? number_format((float) $srv->price, 0, ',', '.') . ' đ' : 'vui lòng liên hệ phòng khám';

            return [
                'reply' => "**Tư vấn Tẩy trắng răng Laser Whitening:**\n\n"
                    . "• **Chi phí niêm yết:** **{$priceText}** (hoàn tất trong **1 buổi ~60 phút**)\n"
                    . "• Bật 2–3 tông màu sáng tự nhiên, sử dụng gel bảo vệ nướu an toàn và hạn chế tối đa ê buốt.\n"
                    . "• Bác sĩ sẽ kiểm tra men răng và làm sạch mảng bám trước khi chiếu đèn để màu răng đều đẹp nhất.",
                'actions' => [
                    ['label' => '📅 Đặt lịch Tẩy trắng răng', 'url' => $bookingUrl($srv, $doc), 'primary' => true],
                ],
            ];
        }

        if (in_array($currentTopic, ['root_canal', 'scaling', 'filling'], true) || Str::contains($normalized, ['dau rang', 'nhuc rang', 'sung nuou', 'hoi mieng'])) {
            $srv = match ($currentTopic) {
                'root_canal' => $findService(['tuy']),
                'scaling' => $findService(['voi rang', 'cao rang']),
                default => $findService(['tram rang']),
            };
            $priceText = $srv ? number_format((float) $srv->price, 0, ',', '.') . ' đ' : 'vui lòng liên hệ phòng khám';
            $doc = $findDoctor(['trong', 'ha', 'tran van']);

            return [
                'reply' => "**Tư vấn Điều trị Bệnh lý Răng miệng:**\n\n"
                    . "Triệu chứng Anh/Chị gặp phải nên được Bác sĩ kiểm tra sớm để xử lý dứt điểm, tránh lan xuống tủy hoặc nha chu.\n"
                    . "• **Dịch vụ phù hợp:** " . ($srv->name ?? 'Khám & điều trị răng tổng quát') . " — **{$priceText}**\n"
                    . "• **Bác sĩ gợi ý:** **" . ($doc?->user?->name ?? 'Bác sĩ chuyên khoa Nha Khoa Smile') . "**\n"
                    . "• Nếu đang đau nhức nhiều trong hôm nay, Anh/Chị có thể đến trực tiếp phòng khám **204 Trần Duy Hưng** để được tiếp nhận khám ngay.",
                'actions' => [
                    ['label' => '📅 Đặt lịch khám ngay', 'url' => $bookingUrl($srv, $doc), 'primary' => true],
                    ['label' => '📞 Hotline 0775 761 388', 'url' => 'tel:0775761388', 'primary' => false],
                ],
            ];
        }

        // 10. Bảng giá & Danh sách dịch vụ tổng hợp
        if (Str::contains($normalized, ['bang gia', 'bao nhieu tien', 'chi phi', 'gia ', 'dich vu'])) {
            $srvCount = $services->count();
            $lines = $services->take(9)->map(function ($s) {
                $dur = max(15, (int) ($s->duration_minutes ?? 30));
                return "• **{$s->name}**: " . number_format((float) $s->price, 0, ',', '.') . " đ (~{$dur}p)";
            })->implode("\n");

            return [
                'reply' => "Hiện tại **Nha Khoa Smile** cung cấp **{$srvCount} dịch vụ chuyên khoa** với bảng giá niêm yết:\n\n{$lines}\n\nAnh/Chị đang quan tâm cụ thể dịch vụ nào để em tư vấn sâu hơn ạ?",
                'actions' => [
                    ['label' => '💰 Xem đầy đủ Bảng giá', 'url' => route('public.services'), 'primary' => true],
                    ['label' => '📅 Đặt lịch khám', 'url' => route('public.booking'), 'primary' => false],
                ],
            ];
        }

        // 12. Địa chỉ, giờ làm việc, liên hệ
        if (Str::contains($normalized, ['dia chi', 'o dau', 'gio mo cua', 'gio lam viec', 'may gio', 'hotline', 'sdt', 'so dien thoai', 'lien he', 'chu nhat'])) {
            return [
                'reply' => "**Thông tin liên hệ Nha Khoa Smile:**\n\n"
                    . "• **Địa chỉ:** 204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội\n"
                    . "• **Giờ làm việc:** **08:00 – 20:00** (Thứ 2 – Chủ Nhật, làm việc cả cuối tuần)\n"
                    . "• **Hotline đặt hẹn & cấp cứu:** **0775 761 388**\n"
                    . "• Đặt lịch online áp dụng từ ngày mai; nếu cần khám ngay trong hôm nay, kính mời Anh/Chị đến trực tiếp quầy lễ tân.",
                'actions' => [
                    ['label' => '🗺️ Chỉ đường Google Maps', 'url' => 'https://www.google.com/maps/dir/?api=1&destination=204+Tr%E1%BA%A7n+Duy+H%C6%B0ng,+Y%C3%AAn+H%C3%B2a,+C%E1%BA%A7u+Gi%E1%BA%A5y,+H%C3%A0+N%E1%BB%99i', 'primary' => false, 'external' => true],
                    ['label' => '📅 Đặt lịch ngay', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // 13. Tra cứu / Bệnh án / Hóa đơn
        if (Str::contains($normalized, ['tra cuu', 'hoa don', 'benh an', 'don thuoc', 'lich hen'])) {
            return [
                'reply' => "**Tra cứu Hồ sơ & Bệnh án điện tử DCMS:**\n\n"
                    . "• Tra cứu nhanh lịch hẹn và hóa đơn chỉ bằng **Số điện thoại** hoặc **Mã bệnh nhân (BN...)**.\n"
                    . "• Đăng nhập **Cổng Bệnh Nhân** để xem chi tiết sơ đồ 32 răng FDI, đơn thuốc bác sĩ kê và thanh toán VietQR tự động.",
                'actions' => [
                    ['label' => '🔍 Tra cứu hồ sơ ngay', 'url' => route('public.lookup'), 'primary' => true],
                    ['label' => '🔐 Cổng Bệnh Nhân', 'url' => route('patient.login'), 'primary' => false],
                ],
            ];
        }

        // 14. Đặt lịch chung
        if (Str::contains($normalized, ['dat lich', 'hen kham', 'dang ky kham', 'book'])) {
            return [
                'reply' => "**Hướng dẫn Đặt lịch khám ưu tiên tại Nha Khoa Smile:**\n\n"
                    . "1. Chọn **Bác sĩ chuyên khoa** — hệ thống tự động hiển thị các khung giờ còn trống.\n"
                    . "2. Chọn **Dịch vụ** và **Ngày giờ khám** (08:00 – 20:00, từ ngày mai trở đi).\n"
                    . "3. Bấm xác nhận — Lễ tân sẽ liên hệ xác nhận giữ ghế khám đúng giờ cho Anh/Chị.",
                'actions' => [
                    ['label' => '📅 Mở trang Đặt lịch ngay', 'url' => route('public.booking'), 'primary' => true],
                ],
            ];
        }

        // Mặc định hướng dẫn rõ ràng, chuyên nghiệp
        return [
            'reply' => "Cảm ơn Anh/Chị đã liên hệ **Nha Khoa Smile**!\n\n"
                . "Để em tư vấn chính xác nhất, Anh/Chị có thể mô tả ngắn gọn:\n"
                . "• **Triệu chứng đang gặp** (ví dụ: *đau răng khôn, ê buốt, mất răng, chảy máu nướu...*)\n"
                . "• **Dịch vụ quan tâm** (*bảng giá, niềng răng, răng sứ, Implant, tẩy trắng...*)\n"
                . "• Hoặc hỏi **lịch trống của Bác sĩ**, **địa chỉ / giờ mở cửa**, **bảo hành & trả góp**.",
            'actions' => [
                ['label' => '💰 Xem Bảng giá', 'url' => route('public.services'), 'primary' => false],
                ['label' => '📅 Đặt lịch khám', 'url' => route('public.booking'), 'primary' => true],
            ],
        ];
    }
}
