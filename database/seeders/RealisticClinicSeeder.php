<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\MaterialUsage;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Role;
use App\Models\Service;
use App\Models\Supply;
use App\Models\User;
use App\Support\ContactInquiryStore;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealisticClinicSeeder extends Seeder
{
    public function run(): void
    {
        $patientRole = Role::firstOrCreate(['name' => 'Patient'], ['description' => 'Bệnh nhân & khách hàng']);

        $doctors = Doctor::with('user')->get()->keyBy(fn ($d) => $d->user->email ?? ('doc_' . $d->id));
        $services = Service::all()->keyBy('service_code');
        $supplies = Supply::all()->keyBy('name');

        if ($doctors->isEmpty() || $services->isEmpty()) {
            return;
        }

        // 1. Bổ sung 3 đầu thuốc sắp hết tồn kho (<= 20) để kích hoạt cảnh báo tồn kho thực tế
        $lowStockMedicines = [
            [
                'name' => 'Gel bôi nhiệt miệng Kamistad-Gel N',
                'category' => 'Thuốc bôi niêm mạc',
                'unit' => 'Tuýp',
                'import_price' => 38000,
                'price' => 58000,
                'stock_quantity' => 11,
                'expiry_date' => Carbon::now()->addMonths(10)->toDateString(),
                'description' => 'Giảm đau, kháng viêm nhanh các vết loét nhiệt miệng và viêm nướu nhẹ.',
            ],
            [
                'name' => 'Alpha Choay (Chymotrypsin)',
                'category' => 'Chống phù nề',
                'unit' => 'Vỉ',
                'import_price' => 28000,
                'price' => 45000,
                'stock_quantity' => 15,
                'expiry_date' => Carbon::now()->addMonths(14)->toDateString(),
                'description' => 'Giảm phù nề, tiêu sưng sau nhổ răng khôn và phẫu thuật cấy ghép Implant.',
            ],
            [
                'name' => 'Augmentin 625mg (GlaxoSmithKline)',
                'category' => 'Kháng sinh cao cấp',
                'unit' => 'Hộp',
                'import_price' => 145000,
                'price' => 210000,
                'stock_quantity' => 18,
                'expiry_date' => Carbon::now()->addMonths(18)->toDateString(),
                'description' => 'Kháng sinh phổ rộng nhập khẩu điều trị nhiễm khuẩn răng hàm mặt mức độ vừa và nặng.',
            ],
        ];

        foreach ($lowStockMedicines as $med) {
            Medicine::updateOrCreate(['name' => $med['name']], $med);
        }

        $medicines = Medicine::all()->keyBy('name');
        $now = Carbon::now();

        // 2. Tạo thêm 14 bệnh nhân thực tế tại Hà Nội (tổng 20 bệnh nhân), rải ngày tạo qua 3 tháng
        $extraPatients = [
            ['code' => 'BN2026110007', 'name' => 'Vũ Thị Lan Hương', 'email' => 'lanhuong.vu@gmail.com', 'phone' => '0987100107', 'gender' => 'Nữ', 'dob' => '1991-04-12', 'cccd' => '001191007107', 'job' => 'Kế toán trưởng', 'address' => 'Số 18 Trung Kính, Cầu Giấy, Hà Nội', 'allergy' => 'Không', 'history' => 'Khỏe mạnh', 'contact' => 'Chồng: Nguyễn Minh Đức (0987100907)', 'days_ago' => 1],
            ['code' => 'BN2026110008', 'name' => 'Ngô Quang Huy', 'email' => 'quanghuy.ngo@gmail.com', 'phone' => '0987100108', 'gender' => 'Nam', 'dob' => '1985-09-21', 'cccd' => '001085008108', 'job' => 'Kiến trúc sư', 'address' => 'Ngõ 68 Hoàng Đạo Thúy, Thanh Xuân, Hà Nội', 'allergy' => 'Không ghi nhận', 'history' => 'Cao huyết áp nhẹ', 'contact' => 'Vợ: Đỗ Mai Chi (0987100908)', 'days_ago' => 2],
            ['code' => 'BN2026110009', 'name' => 'Bùi Thanh Hằng', 'email' => 'thanhhang.bui@gmail.com', 'phone' => '0987100109', 'gender' => 'Nữ', 'dob' => '1996-02-14', 'cccd' => '001196009109', 'job' => 'Chuyên viên Nhân sự', 'address' => '102 Thái Thịnh, Đống Đa, Hà Nội', 'allergy' => 'Dị ứng hải sản nhẹ', 'history' => 'Bình thường', 'contact' => 'Mẹ: Phạm Thị Loan (0987100909)', 'days_ago' => 3],
            ['code' => 'BN2026110010', 'name' => 'Đỗ Mạnh Cường', 'email' => 'manhcuong.do@gmail.com', 'phone' => '0987100110', 'gender' => 'Nam', 'dob' => '1979-11-03', 'cccd' => '001079010110', 'job' => 'Giám đốc Kinh doanh', 'address' => 'KĐT Vinhomes Smart City, Nam Từ Liêm, Hà Nội', 'allergy' => 'Không', 'history' => 'Mỡ máu nhẹ', 'contact' => 'Vợ: Trần Ngọc Bích (0987100910)', 'days_ago' => 4],
            ['code' => 'BN2026110011', 'name' => 'Trịnh Ngọc Diệp', 'email' => 'ngocdiep.trinh@gmail.com', 'phone' => '0987100111', 'gender' => 'Nữ', 'dob' => '2000-07-19', 'cccd' => '001200011111', 'job' => 'Thiết kế đồ họa', 'address' => '45 Xuân Thủy, Cầu Giấy, Hà Nội', 'allergy' => 'Không', 'history' => 'Khỏe mạnh', 'contact' => 'Chị gái: Trịnh Thu Hà (0987100911)', 'days_ago' => 6],
            ['code' => 'BN2026110012', 'name' => 'Phan Tuấn Kiệt', 'email' => 'tuankiet.phan@gmail.com', 'phone' => '0987100112', 'gender' => 'Nam', 'dob' => '1993-01-28', 'cccd' => '001093012112', 'job' => 'Lập trình viên Senior', 'address' => '24 Nguyễn Cơ Thạch, Nam Từ Liêm, Hà Nội', 'allergy' => 'Không', 'history' => 'Viêm xoang dị ứng', 'contact' => 'Bố: Phan Văn Long (0987100912)', 'days_ago' => 9],
            ['code' => 'BN2026110013', 'name' => 'Lý Thu Trang', 'email' => 'thutrang.ly@gmail.com', 'phone' => '0987100113', 'gender' => 'Nữ', 'dob' => '1989-05-08', 'cccd' => '001189013113', 'job' => 'Giảng viên Đại học', 'address' => '88 Láng Hạ, Đống Đa, Hà Nội', 'allergy' => 'Dị ứng Lidocain nhẹ', 'history' => 'Khỏe mạnh', 'contact' => 'Chồng: Lê Quang Vinh (0987100913)', 'days_ago' => 12],
            ['code' => 'BN2026110014', 'name' => 'Nguyễn Hải Đăng', 'email' => 'haidang.nguyen@gmail.com', 'phone' => '0987100114', 'gender' => 'Nam', 'dob' => '1982-08-15', 'cccd' => '001082014114', 'job' => 'Chủ nhà hàng', 'address' => '156 Võ Chí Công, Tây Hồ, Hà Nội', 'allergy' => 'Không', 'history' => 'Bình thường', 'contact' => 'Vợ: Hoàng Thị Yến (0987100914)', 'days_ago' => 16],
            ['code' => 'BN2026110015', 'name' => 'Dương Khánh Linh', 'email' => 'khanhlinh.duong@gmail.com', 'phone' => '0987100115', 'gender' => 'Nữ', 'dob' => '1997-12-09', 'cccd' => '001197015115', 'job' => 'Biên tập viên truyền hình', 'address' => '29 Liễu Giai, Ba Đình, Hà Nội', 'allergy' => 'Không', 'history' => 'Khỏe mạnh', 'contact' => 'Mẹ: Nguyễn Kim Oanh (0987100915)', 'days_ago' => 20],
            ['code' => 'BN2026110016', 'name' => 'Hoàng Đức Anh', 'email' => 'ducanh.hoang@gmail.com', 'phone' => '0987100116', 'gender' => 'Nam', 'dob' => '1990-03-27', 'cccd' => '001090016116', 'job' => 'Quản lý Dự án Xây dựng', 'address' => '72 Trần Thái Tông, Cầu Giấy, Hà Nội', 'allergy' => 'Không', 'history' => 'Đau dạ dày nhẹ', 'contact' => 'Vợ: Vũ Thanh Tâm (0987100916)', 'days_ago' => 24],
            ['code' => 'BN2026110017', 'name' => 'Tạ Minh Châu', 'email' => 'minhchau.ta@gmail.com', 'phone' => '0987100117', 'gender' => 'Nữ', 'dob' => '1986-06-30', 'cccd' => '001186017117', 'job' => 'Dược sĩ', 'address' => '19 Bà Triệu, Hai Bà Trưng, Hà Nội', 'allergy' => 'Không', 'history' => 'Khỏe mạnh', 'contact' => 'Chồng: Phạm Gia Huy (0987100917)', 'days_ago' => 35],
            ['code' => 'BN2026110018', 'name' => 'Chu Việt Hoàng', 'email' => 'viethoang.chu@gmail.com', 'phone' => '0987100118', 'gender' => 'Nam', 'dob' => '1973-10-11', 'cccd' => '001073018118', 'job' => 'Kinh doanh Bất động sản', 'address' => 'KĐT Ciputra, Tây Hồ, Hà Nội', 'allergy' => 'Không', 'history' => 'Tiền tiểu đường ổn định', 'contact' => 'Con trai: Chu Minh Quân (0987100918)', 'days_ago' => 42],
            ['code' => 'BN2026110019', 'name' => 'Mai Phương Thảo', 'email' => 'phuongthao.mai@gmail.com', 'phone' => '0987100119', 'gender' => 'Nữ', 'dob' => '1999-09-04', 'cccd' => '001199019119', 'job' => 'Tiếp viên hàng không', 'address' => '55 Nguyễn Văn Cừ, Long Biên, Hà Nội', 'allergy' => 'Không', 'history' => 'Khỏe mạnh', 'contact' => 'Mẹ: Trần Thị Nga (0987100919)', 'days_ago' => 58],
            ['code' => 'BN2026110020', 'name' => 'Cao Xuân Bách', 'email' => 'xuanbach.cao@gmail.com', 'phone' => '0987100120', 'gender' => 'Nam', 'dob' => '1984-02-22', 'cccd' => '001084020120', 'job' => 'Luật sư', 'address' => '33 Phan Đình Phùng, Ba Đình, Hà Nội', 'allergy' => 'Không', 'history' => 'Khỏe mạnh', 'contact' => 'Vợ: Lê Hải Yến (0987100920)', 'days_ago' => 68],
        ];

        $patientsMap = Patient::all()->keyBy('patient_code');

        foreach ($extraPatients as $p) {
            $createdAt = $now->copy()->subDays($p['days_ago'])->setTime(9, 0);

            $user = User::updateOrCreate(
                ['phone' => $p['phone']],
                [
                    'name' => $p['name'],
                    'email' => $p['email'],
                    'password' => Hash::make('password'),
                    'role_id' => $patientRole->id,
                    'cccd' => $p['cccd'],
                    'address' => $p['address'],
                    'is_active' => true,
                ]
            );

            $patient = Patient::updateOrCreate(
                ['patient_code' => $p['code']],
                [
                    'name' => $p['name'],
                    'gender' => $p['gender'],
                    'dob' => $p['dob'],
                    'job' => $p['job'],
                    'address' => $p['address'],
                    'email' => $p['email'],
                    'phone' => $p['phone'],
                    'allergy_history' => $p['allergy'],
                    'medical_history' => $p['history'],
                    'contact_person' => $p['contact'],
                    'user_id' => $user->id,
                ]
            );

            // Rải ngày tạo hồ sơ để thống kê "Bệnh nhân mới trong tháng" phản ánh đúng từng tháng
            Patient::where('id', $patient->id)->update(['created_at' => $createdAt, 'updated_at' => $createdAt]);
            $patientsMap[$p['code']] = $patient->fresh();
        }

        // Helper tạo ca khám hoàn chỉnh (Lịch hẹn + Bệnh án + Đơn thuốc + Vật tư + Hóa đơn + Thanh toán)
        $docA = $doctors['bacsi@smile.com'] ?? $doctors->first();
        $docNam = $doctors['nam.le@smile.com'] ?? $doctors->first();
        $docHa = $doctors['ha.nguyen@smile.com'] ?? $doctors->first();
        $docUyen = $doctors['uyen.mai@smile.com'] ?? $doctors->first();
        $docTrong = $doctors['trong.vu@smile.com'] ?? $doctors->first();

        $completedCases = [
            // === 7 NGÀY GẦN NHẤT (Biểu đồ doanh thu 7 ngày trên Dashboard & Tháng hiện tại) ===
            [
                'inv_code' => 'HD2026112701', 'patient' => 'BN2026110007', 'doctor' => $docA, 'service' => 'SV009', 'qty' => 4,
                'days_ago' => 0, 'hour' => 9, 'min' => 0, 'method' => 'qr', 'discount' => 1000000,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 2, 'supply' => 'Găng tay y tế Nitrile không bột', 'supply_qty' => 2,
                'diagnosis' => 'Nhiễm màu Tetracycline độ III nhóm răng cửa hàm trên (R12, R11, R21, R22).',
                'plan' => 'Mài chỉnh tối thiểu, lấy dấu Scan 3D, gắn 4 mão sứ Cercon HT thẩm mỹ.',
                'teeth' => ['11' => ['status' => 'crown', 'note' => 'Bọc sứ Cercon HT'], '21' => ['status' => 'crown', 'note' => 'Bọc sứ Cercon HT']],
            ],
            [
                'inv_code' => 'HD2026112702', 'patient' => 'BN2026110008', 'doctor' => $docTrong, 'service' => 'SV003', 'qty' => 2,
                'days_ago' => 0, 'hour' => 11, 'min' => 0, 'method' => 'cash', 'discount' => 0,
                'med_name' => 'Augmentin 625mg (GlaxoSmithKline)', 'med_qty' => 1, 'supply' => 'Thuốc tê Septanest 4% SP (Pháp)', 'supply_qty' => 4,
                'diagnosis' => 'Răng khôn mọc lệch 48 và 18 gây dắt thức ăn và viêm lợi trùm tái phát.',
                'plan' => 'Nhổ đồng thời 2 răng khôn bên phải bằng máy siêu âm Piezotome, khâu chỉ tự tiêu Vicryl 4.0.',
                'teeth' => ['48' => ['status' => 'impacted', 'note' => 'Nhổ Piezotome'], '18' => ['status' => 'impacted', 'note' => 'Nhổ Piezotome']],
            ],
            [
                'inv_code' => 'HD2026112601', 'patient' => 'BN2026110009', 'doctor' => $docA, 'service' => 'SV005', 'qty' => 1,
                'days_ago' => 1, 'hour' => 10, 'min' => 0, 'method' => 'qr', 'discount' => 0,
                'med_name' => 'Gel bôi nhiệt miệng Kamistad-Gel N', 'med_qty' => 1, 'supply' => 'Bông gòn tiệt trùng nha khoa dạng cuộn', 'supply_qty' => 2,
                'diagnosis' => 'Răng xỉn màu thực phẩm mức độ II, men răng chắc khỏe.',
                'plan' => 'Cạo vôi đánh bóng + Tẩy trắng răng công nghệ Laser Whitening 2 chu kỳ.',
                'teeth' => ['11' => ['status' => 'healthy', 'note' => 'Bật 3 tông màu A1']],
            ],
            [
                'inv_code' => 'HD2026112602', 'patient' => 'BN2026110010', 'doctor' => $docNam, 'service' => 'SV007', 'qty' => 1,
                'days_ago' => 1, 'hour' => 14, 'min' => 30, 'method' => 'qr', 'discount' => 2000000,
                'med_name' => 'Alpha Choay (Chymotrypsin)', 'med_qty' => 2, 'supply' => 'Chỉ khâu phẫu thuật tự tiêu Vicryl 4.0', 'supply_qty' => 2,
                'diagnosis' => 'Mất răng cối lớn hàm dưới R46 lâu năm, xương hàm còn đủ thể tích.',
                'plan' => 'Phẫu thuật cấy trụ Implant Straumann SLA Active đường kính 4.1mm, hướng dẫn vệ sinh hậu phẫu.',
                'teeth' => ['46' => ['status' => 'implant', 'note' => 'Đặt trụ Implant Straumann']],
            ],
            [
                'inv_code' => 'HD2026112501', 'patient' => 'BN2026110011', 'doctor' => $docUyen, 'service' => 'SV008', 'qty' => 1,
                'days_ago' => 2, 'hour' => 15, 'min' => 0, 'method' => 'qr', 'discount' => 2000000,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 2, 'supply' => 'Găng tay y tế Nitrile không bột', 'supply_qty' => 1,
                'diagnosis' => 'Khớp cắn hô nhẹ, chen chúc răng cửa hàm trên.',
                'plan' => 'Gắn mắc cài tự buộc 2 hàm, đi dây cung NiTi 0.014, hẹn tái khám sau 4 tuần.',
                'teeth' => ['12' => ['status' => 'misaligned', 'note' => 'Gắn mắc cài chỉnh nha']],
            ],
            [
                'inv_code' => 'HD2026112402', 'patient' => 'BN2026110012', 'doctor' => $docTrong, 'service' => 'SV006', 'qty' => 1,
                'days_ago' => 3, 'hour' => 16, 'min' => 0, 'method' => 'cash', 'discount' => 0,
                'med_name' => 'Ibuprofen 400mg', 'med_qty' => 15, 'supply' => 'Thuốc tê Septanest 4% SP (Pháp)', 'supply_qty' => 2,
                'diagnosis' => 'Viêm tủy không hồi phục răng hàm lớn R36 do sâu mặt xa.',
                'plan' => 'Điều trị nội nha 3 ống tủy bằng trâm máy Protaper, trám bít Gutta-percha và tái tạo cùi.',
                'teeth' => ['36' => ['status' => 'root_canal', 'note' => 'Đã điều trị tủy hoàn tất']],
            ],
            [
                'inv_code' => 'HD2026112301', 'patient' => 'BN2026110013', 'doctor' => $docA, 'service' => 'SV009', 'qty' => 2,
                'days_ago' => 4, 'hour' => 9, 'min' => 30, 'method' => 'qr', 'discount' => 0,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 1, 'supply' => 'Bông gòn tiệt trùng nha khoa dạng cuộn', 'supply_qty' => 2,
                'diagnosis' => 'Mẻ cạnh cắn răng 11 và 21 do chấn thương cũ, miếng trám cũ đổi màu.',
                'plan' => 'Phục hình 2 răng sứ Cercon HT khớp màu tự nhiên.',
                'teeth' => ['11' => ['status' => 'crown', 'note' => 'Sứ Cercon HT'], '21' => ['status' => 'crown', 'note' => 'Sứ Cercon HT']],
            ],
            [
                'inv_code' => 'HD2026112201', 'patient' => 'BN2026110014', 'doctor' => $docHa, 'service' => 'SV004', 'qty' => 3,
                'days_ago' => 5, 'hour' => 10, 'min' => 30, 'method' => 'cash', 'discount' => 0,
                'med_name' => 'Paracetamol 500mg', 'med_qty' => 10, 'supply' => 'Bông gòn tiệt trùng nha khoa dạng cuộn', 'supply_qty' => 1,
                'diagnosis' => 'Sâu cổ răng nhẹ ở các răng 14, 15, 24 do chải răng sai cách.',
                'plan' => 'Trám thẩm mỹ cổ răng Composite 3M Z350 XT, hướng dẫn chải răng Bass cải tiến.',
                'teeth' => ['14' => ['status' => 'filled', 'note' => 'Trám cổ răng Composite']],
            ],
            [
                'inv_code' => 'HD2026112101', 'patient' => 'BN2026110015', 'doctor' => $docA, 'service' => 'SV005', 'qty' => 1,
                'days_ago' => 6, 'hour' => 14, 'min' => 0, 'method' => 'qr', 'discount' => 0,
                'med_name' => 'Vitamin C 500mg', 'med_qty' => 20, 'supply' => 'Găng tay y tế Nitrile không bột', 'supply_qty' => 1,
                'diagnosis' => 'Nhu cầu thẩm mỹ trắng sáng răng trước lịch ghi hình.',
                'plan' => 'Lấy cao răng siêu âm + Tẩy trắng răng Laser Whitening.',
                'teeth' => ['21' => ['status' => 'healthy', 'note' => 'Trắng sáng tự nhiên']],
            ],

            // === CÁC NGÀY ĐẦU THÁNG HIỆN TẠI (Tháng 11/2026) ===
            [
                'inv_code' => 'HD2026111801', 'patient' => 'BN2026110016', 'doctor' => $docTrong, 'service' => 'SV003', 'qty' => 1,
                'days_ago' => 9, 'hour' => 11, 'min' => 0, 'method' => 'qr', 'discount' => 0,
                'med_name' => 'Rodogyl (Spiramycin + Metronidazol)', 'med_qty' => 20, 'supply' => 'Thuốc tê Septanest 4% SP (Pháp)', 'supply_qty' => 2,
                'diagnosis' => 'Răng khôn hàm dưới 48 mọc ngầm gây sâu mặt xa răng 47.',
                'plan' => 'Nhổ răng khôn 48 bằng Piezotome + kê đơn kháng sinh, giảm đau.',
                'teeth' => ['48' => ['status' => 'impacted', 'note' => 'Đã nhổ an toàn']],
            ],
            [
                'inv_code' => 'HD2026111501', 'patient' => 'BN2026110014', 'doctor' => $docNam, 'service' => 'SV009', 'qty' => 3,
                'days_ago' => 12, 'hour' => 15, 'min' => 0, 'method' => 'qr', 'discount' => 500000,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 1, 'supply' => 'Găng tay y tế Nitrile không bột', 'supply_qty' => 2,
                'diagnosis' => 'Cầu răng cũ hở bờ viền vùng R24-R26.',
                'plan' => 'Tháo cầu cũ, làm sạch cùi răng và phục hình cầu 3 đơn vị Cercon HT.',
                'teeth' => ['25' => ['status' => 'crown', 'note' => 'Cầu sứ Cercon HT']],
            ],
            [
                'inv_code' => 'HD2026111101', 'patient' => 'BN2026110012', 'doctor' => $docHa, 'service' => 'SV002', 'qty' => 1,
                'days_ago' => 16, 'hour' => 9, 'min' => 0, 'method' => 'cash', 'discount' => 0,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 1, 'supply' => 'Bông gòn tiệt trùng nha khoa dạng cuộn', 'supply_qty' => 1,
                'diagnosis' => 'Vôi răng độ II, viêm lợi nhẹ vùng răng cửa dưới.',
                'plan' => 'Cạo vôi răng siêu âm và đánh bóng 2 hàm.',
                'teeth' => ['31' => ['status' => 'calculus', 'note' => 'Đã lấy cao răng sạch']],
            ],
            [
                'inv_code' => 'HD2026110601', 'patient' => 'BN2026110015', 'doctor' => $docA, 'service' => 'SV006', 'qty' => 1,
                'days_ago' => 21, 'hour' => 14, 'min' => 0, 'method' => 'qr', 'discount' => 0,
                'med_name' => 'Efferalgan Codeine', 'med_qty' => 8, 'supply' => 'Thuốc tê Septanest 4% SP (Pháp)', 'supply_qty' => 2,
                'diagnosis' => 'Viêm tủy cấp răng 16.',
                'plan' => 'Điều trị nội nha răng 16 và trám tái tạo.',
                'teeth' => ['16' => ['status' => 'root_canal', 'note' => 'Đã trám bít ống tủy']],
            ],

            // === THÁNG TRƯỚC (Tháng 10/2026) ===
            [
                'inv_code' => 'HD2026102401', 'patient' => 'BN2026110017', 'doctor' => $docNam, 'service' => 'SV007', 'qty' => 1,
                'days_ago' => 34, 'hour' => 10, 'min' => 0, 'method' => 'qr', 'discount' => 1500000,
                'med_name' => 'Augmentin 625mg (GlaxoSmithKline)', 'med_qty' => 1, 'supply' => 'Chỉ khâu phẫu thuật tự tiêu Vicryl 4.0', 'supply_qty' => 2,
                'diagnosis' => 'Mất răng hàm dưới R36 do nhổ cách đây 1 năm.',
                'plan' => 'Cấy ghép 1 trụ Implant Straumann Thụy Sĩ.',
                'teeth' => ['36' => ['status' => 'implant', 'note' => 'Cấy ghép Implant']],
            ],
            [
                'inv_code' => 'HD2026101801', 'patient' => 'BN2026110018', 'doctor' => $docA, 'service' => 'SV009', 'qty' => 4,
                'days_ago' => 40, 'hour' => 14, 'min' => 30, 'method' => 'qr', 'discount' => 1000000,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 2, 'supply' => 'Găng tay y tế Nitrile không bột', 'supply_qty' => 2,
                'diagnosis' => 'Mòn mặt nhai và nứt men nhóm răng cửa hàm trên.',
                'plan' => 'Bọc 4 răng sứ thẩm mỹ Cercon HT.',
                'teeth' => ['11' => ['status' => 'crown', 'note' => 'Bọc sứ Cercon HT']],
            ],
            [
                'inv_code' => 'HD2026101001', 'patient' => 'BN2026110017', 'doctor' => $docTrong, 'service' => 'SV003', 'qty' => 1,
                'days_ago' => 48, 'hour' => 9, 'min' => 30, 'method' => 'cash', 'discount' => 0,
                'med_name' => 'Alpha Choay (Chymotrypsin)', 'med_qty' => 1, 'supply' => 'Thuốc tê Septanest 4% SP (Pháp)', 'supply_qty' => 2,
                'diagnosis' => 'Răng khôn 28 mọc lệch má gây cọ xát niêm mạc.',
                'plan' => 'Nhổ răng khôn 28 bằng Piezotome.',
                'teeth' => ['28' => ['status' => 'impacted', 'note' => 'Đã nhổ']],
            ],

            // === 2 THÁNG TRƯỚC (Tháng 09/2026) ===
            [
                'inv_code' => 'HD2026092501', 'patient' => 'BN2026110019', 'doctor' => $docUyen, 'service' => 'SV008', 'qty' => 1,
                'days_ago' => 63, 'hour' => 10, 'min' => 0, 'method' => 'qr', 'discount' => 2000000,
                'med_name' => 'Nước súc miệng Chlorhexidine 0.12%', 'med_qty' => 2, 'supply' => 'Găng tay y tế Nitrile không bột', 'supply_qty' => 1,
                'diagnosis' => 'Khớp cắn chéo nhẹ răng nanh hàm trên.',
                'plan' => 'Niềng răng mắc cài tự buộc toàn hàm.',
                'teeth' => ['13' => ['status' => 'misaligned', 'note' => 'Chỉnh nha mắc cài']],
            ],
            [
                'inv_code' => 'HD2026091401', 'patient' => 'BN2026110020', 'doctor' => $docA, 'service' => 'SV005', 'qty' => 1,
                'days_ago' => 74, 'hour' => 15, 'min' => 30, 'method' => 'qr', 'discount' => 0,
                'med_name' => 'Gel bôi nhiệt miệng Kamistad-Gel N', 'med_qty' => 1, 'supply' => 'Bông gòn tiệt trùng nha khoa dạng cuộn', 'supply_qty' => 1,
                'diagnosis' => 'Nhiễm màu trà và cà phê toàn hàm.',
                'plan' => 'Tẩy trắng răng Laser Whitening.',
                'teeth' => ['11' => ['status' => 'healthy', 'note' => 'Tẩy trắng Laser']],
            ],
        ];

        foreach ($completedCases as $c) {
            $patient = $patientsMap[$c['patient']] ?? null;
            $service = $services[$c['service']] ?? null;
            $doctor = $c['doctor'];
            if (!$patient || !$service || !$doctor) {
                continue;
            }

            $visitTime = $now->copy()->subDays($c['days_ago'])->setTime($c['hour'], $c['min'], 0);

            $appointment = Appointment::updateOrCreate(
                ['patient_id' => $patient->id, 'appointment_time' => $visitTime],
                [
                    'doctor_id' => $doctor->id,
                    'service_id' => $service->id,
                    'status' => 'completed',
                    'note' => $c['diagnosis'],
                ]
            );

            $record = MedicalRecord::updateOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'symptoms' => $c['diagnosis'],
                    'diagnosis' => $c['diagnosis'],
                    'treatment_plan' => $c['plan'],
                    'teeth_data' => json_encode($c['teeth']),
                    'note' => 'Điều trị hoàn tất, bệnh nhân ổn định.',
                ]
            );

            MedicalRecordDetail::updateOrCreate(
                ['medical_record_id' => $record->id, 'service_id' => $service->id],
                ['quantity' => $c['qty'], 'note' => $service->name]
            );

            $med = $medicines[$c['med_name']] ?? null;
            $medTotal = 0;
            if ($med) {
                $prescription = Prescription::updateOrCreate(
                    ['medical_record_id' => $record->id],
                    [
                        'note' => 'Sử dụng đúng liều lượng hướng dẫn, tái khám định kỳ.',
                        'follow_up_date' => $visitTime->copy()->addDays(7),
                    ]
                );

                PrescriptionDetail::updateOrCreate(
                    ['prescription_id' => $prescription->id, 'medicine_name' => $med->name],
                    [
                        'medicine_id' => $med->id,
                        'dosage' => 'Theo chỉ định bác sĩ',
                        'quantity' => $c['med_qty'],
                        'usage_morning' => '1 lần',
                        'usage_noon' => '',
                        'usage_evening' => '1 lần',
                        'usage_night' => '',
                        'instructions' => 'Dùng sau bữa ăn.',
                    ]
                );

                $medTotal = floatval($med->price) * $c['med_qty'];
            }

            $supply = $supplies[$c['supply']] ?? $supplies->first();
            if ($supply) {
                MaterialUsage::firstOrCreate(
                    [
                        'appointment_id' => $appointment->id,
                        'medical_record_id' => $record->id,
                        'supply_id' => $supply->id,
                    ],
                    [
                        'doctor_id' => $doctor->id,
                        'quantity' => $c['supply_qty'],
                        'note' => 'Tiêu hao trong ca ' . $service->name,
                    ]
                );
            }

            $serviceTotal = floatval($service->price) * $c['qty'];
            $subtotal = $serviceTotal + $medTotal;
            $discount = floatval($c['discount']);
            $taxable = max(0, $subtotal - $discount);
            $vat = round($taxable * 0.10);
            $final = $taxable + $vat;

            $invoice = Invoice::updateOrCreate(
                ['invoice_code' => $c['inv_code']],
                [
                    'patient_id' => $patient->id,
                    'appointment_id' => $appointment->id,
                    'total_amount' => $subtotal,
                    'discount' => $discount,
                    'vat_amount' => $vat,
                    'final_amount' => $final,
                    'status' => 'paid',
                ]
            );

            // Đồng bộ timestamp hóa đơn về đúng ngày khám để biểu đồ 7 ngày & báo cáo theo ngày/tháng chính xác
            Invoice::where('id', $invoice->id)->update(['created_at' => $visitTime, 'updated_at' => $visitTime]);

            InvoiceDetail::updateOrCreate(
                ['invoice_id' => $invoice->id, 'item_name' => 'Dịch vụ: ' . $service->name],
                [
                    'unit_price' => floatval($service->price),
                    'quantity' => $c['qty'],
                    'total_price' => $serviceTotal,
                ]
            );

            if ($med) {
                InvoiceDetail::updateOrCreate(
                    ['invoice_id' => $invoice->id, 'item_name' => 'Thuốc: ' . $med->name . ' (' . $med->unit . ')'],
                    [
                        'unit_price' => floatval($med->price),
                        'quantity' => $c['med_qty'],
                        'total_price' => $medTotal,
                    ]
                );
            }

            $payment = Payment::updateOrCreate(
                ['invoice_id' => $invoice->id],
                [
                    'payment_method' => $c['method'],
                    'amount' => $final,
                    'status' => 'completed',
                ]
            );
            Payment::where('id', $payment->id)->update(['created_at' => $visitTime, 'updated_at' => $visitTime]);
        }

        // 3. Thêm 1 hóa đơn chưa thanh toán hôm nay + 2 lịch hẹn chờ khám / sắp tới
        $p10 = $patientsMap['BN2026110010'] ?? null;
        if ($p10 && isset($services['SV002'])) {
            $aptUnpaid = Appointment::updateOrCreate(
                ['patient_id' => $p10->id, 'appointment_time' => $now->copy()->setTime(15, 30)],
                [
                    'doctor_id' => $docHa->id,
                    'service_id' => $services['SV002']->id,
                    'status' => 'completed',
                    'note' => 'Tái khám vệ sinh răng miệng và kiểm tra sau cấy ghép.',
                ]
            );

            $invUnpaid = Invoice::updateOrCreate(
                ['invoice_code' => 'HD2026112799'],
                [
                    'patient_id' => $p10->id,
                    'appointment_id' => $aptUnpaid->id,
                    'total_amount' => 275000,
                    'discount' => 0,
                    'vat_amount' => 27500,
                    'final_amount' => 302500,
                    'status' => 'unpaid',
                ]
            );

            InvoiceDetail::updateOrCreate(
                ['invoice_id' => $invUnpaid->id, 'item_name' => 'Dịch vụ: Cạo vôi răng & Đánh bóng siêu âm'],
                ['unit_price' => 200000, 'quantity' => 1, 'total_price' => 200000]
            );
            InvoiceDetail::updateOrCreate(
                ['invoice_id' => $invUnpaid->id, 'item_name' => 'Thuốc: Nước súc miệng Chlorhexidine 0.12% (Chai)'],
                ['unit_price' => 75000, 'quantity' => 1, 'total_price' => 75000]
            );
        }

        // Lịch hẹn chờ khám hôm nay & lịch sắp tới
        $upcomingSeeds = [
            ['patient' => 'BN2026110013', 'doctor' => $docUyen, 'service' => 'SV001', 'days' => 0, 'hour' => 16, 'min' => 30, 'status' => 'waiting', 'note' => 'Khách đã đến quầy check-in tư vấn niềng Invisalign.'],
            ['patient' => 'BN2026110016', 'doctor' => $docA, 'service' => 'SV005', 'days' => 1, 'hour' => 10, 'min' => 30, 'status' => 'confirmed', 'note' => 'Đặt lịch tẩy trắng răng Laser cuối tuần.'],
            ['patient' => 'BN2026110019', 'doctor' => $docNam, 'service' => 'SV007', 'days' => 2, 'hour' => 9, 'min' => 0, 'status' => 'pending', 'note' => 'Đặt lịch online tư vấn trồng răng Implant cho người thân.'],
            ['patient' => 'BN2026110020', 'doctor' => $docTrong, 'service' => 'SV003', 'days' => 3, 'hour' => 14, 'min' => 0, 'status' => 'pending', 'note' => 'Đau răng khôn hàm dưới, muốn chụp phim CT 3D.'],
        ];

        foreach ($upcomingSeeds as $up) {
            $pt = $patientsMap[$up['patient']] ?? null;
            $sv = $services[$up['service']] ?? null;
            if (!$pt || !$sv || !$up['doctor']) {
                continue;
            }
            Appointment::updateOrCreate(
                ['patient_id' => $pt->id, 'appointment_time' => $now->copy()->addDays($up['days'])->setTime($up['hour'], $up['min'], 0)],
                [
                    'doctor_id' => $up['doctor']->id,
                    'service_id' => $sv->id,
                    'status' => $up['status'],
                    'note' => $up['note'],
                ]
            );
        }

        // 4. Tạo dữ liệu Yêu cầu tư vấn từ Website nếu chưa có
        if (ContactInquiryStore::all()->count() < 3) {
            ContactInquiryStore::add([
                'name' => 'Nguyễn Thu Phương',
                'phone' => '0918223344',
                'email' => 'thuphuong.hn@gmail.com',
                'topic' => 'Tư vấn Niềng răng Invisalign',
                'message' => 'Cho mình hỏi chi phí niềng răng Invisalign trả góp và thời gian thăm khám cuối tuần tại cơ sở Trần Duy Hưng.',
            ]);
            ContactInquiryStore::add([
                'name' => 'Trần Minh Quang',
                'phone' => '0904556677',
                'email' => 'quang.tran@gmail.com',
                'topic' => 'Cấy ghép Implant Straumann',
                'message' => 'Bố mình 62 tuổi bị mất 2 răng hàm dưới, muốn đăng ký chụp CT ConeBeam 3D miễn phí và tư vấn cùng BS Nam.',
            ]);
            $resolved = ContactInquiryStore::add([
                'name' => 'Lê Bảo Ngọc',
                'phone' => '0976889900',
                'email' => 'baongoc.le@gmail.com',
                'topic' => 'Dán sứ Veneer thẩm mỹ',
                'message' => 'Mình muốn làm 8 răng sứ Veneer, xin bảng giá chi tiết và chính sách bảo hành chính hãng.',
            ]);
            ContactInquiryStore::resolve($resolved['id'], 'Lễ tân Ngọc Ánh');
        }
    }
}
