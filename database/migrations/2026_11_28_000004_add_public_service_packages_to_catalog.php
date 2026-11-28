<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Package prices that were previously maintained in public Blade templates.
     * Keeping them as normal services makes the public catalog and invoices use
     * the same source of truth.
     */
    private function packages(): array
    {
        return [
            ['PKG-ROOT-ANTERIOR', 'Điều trị tủy răng cửa / răng nanh (1 ống tủy)', 'treatment', 800000, 'Bảo hành: Theo dõi định kỳ. Bao gồm làm sạch bằng máy định vị chóp và trám bít.'],
            ['PKG-ROOT-PREMOLAR', 'Điều trị tủy răng hàm nhỏ (1–2 ống tủy)', 'treatment', 1200000, 'Bảo hành: Theo dõi định kỳ. Trâm xoay máy nội nha và trám tái tạo Composite.'],
            ['PKG-ROOT-MOLAR', 'Điều trị tủy răng hàm lớn (3–4 ống tủy)', 'treatment', 1500000, 'Bảo hành: Theo dõi định kỳ. Nhiều ống tủy phức tạp, chụp phim trước và sau điều trị.'],
            ['PKG-ROOT-REPEAT', 'Điều trị tủy lại (ca chữa tủy cũ bị tái viêm)', 'treatment', 2000000, 'Bảo hành: Theo dõi định kỳ. Tháo vật liệu cũ, khử khuẩn chuyên sâu và trám bít lại.'],

            ['PKG-IMPLANT-OSSTEM', 'Implant Osstem (Hàn Quốc) / trụ', 'implant', 13500000, 'Bảo hành: 10 năm. Trụ Titanium, Abutment và mão sứ Titanium.'],
            ['PKG-IMPLANT-DENTIUM', 'Implant Dentium SuperLine (Mỹ) / trụ', 'implant', 18000000, 'Bảo hành: 15 năm. Trụ Titanium, Abutment và mão toàn sứ Zirconia.'],
            ['PKG-IMPLANT-TEKKA', 'Implant Tekka Global D (Pháp) / trụ', 'implant', 22000000, 'Bảo hành: 20 năm. Thiết kế ren xoắn ổn định sơ khởi và mão toàn sứ.'],
            ['PKG-IMPLANT-STRAUMANN', 'Implant Straumann SLA (Thụy Sĩ) / trụ', 'implant', 25000000, 'Bảo hành: Trọn đời. Abutment chính hãng và mão sứ Cercon.'],
            ['PKG-IMPLANT-SLACTIVE', 'Implant Straumann SLActive (Thụy Sĩ) / trụ', 'implant', 32180000, 'Bảo hành: Trọn đời. Bề mặt hoạt hóa sinh học hỗ trợ tích hợp xương nhanh.'],

            ['PKG-SCALING-GRADE-1-2', 'Cạo vôi răng và đánh bóng siêu âm (độ 1–2) / lần', 'treatment', 200000, 'Bảo hành: Khám tổng quát. Làm sạch toàn hàm hai hàm và đánh bóng khoáng chất.'],
            ['PKG-SCALING-GRADE-3', 'Cạo vôi răng và chăm sóc nha chu (độ 3) / lần', 'treatment', 350000, 'Bảo hành: Khám tổng quát. Cao răng dưới nướu, kèm bơm rửa sát khuẩn túi lợi.'],
            ['PKG-SCALING-AIRFLOW', 'Thổi cát Air-Flow loại bỏ vết ố / lần', 'treatment', 500000, 'Bảo hành: Sạch sáng ngay. Làm sạch kẽ răng bằng tia nước và bột khoáng siêu mịn.'],

            ['PKG-WISDOM-STRAIGHT-UPPER', 'Nhổ răng khôn mọc thẳng hàm trên / răng', 'treatment', 490000, 'Bảo hành: Tái khám miễn phí. Ca đơn giản, thời gian thực hiện khoảng 10–15 phút.'],
            ['PKG-WISDOM-STRAIGHT-LOWER', 'Nhổ răng khôn mọc thẳng hàm dưới / răng', 'treatment', 990000, 'Bảo hành: Tái khám miễn phí. Ca đơn giản, thời gian thực hiện khoảng 10–15 phút.'],
            ['PKG-WISDOM-PIEZOTOME', 'Nhổ răng khôn mọc lệch độ I–II bằng Piezotome / răng', 'treatment', 1500000, 'Bảo hành: Cắt chỉ miễn phí. Răng mọc nghiêng hoặc kẹt một phần dưới nướu.'],
            ['PKG-WISDOM-COMPLEX', 'Nhổ răng khôn mọc lệch hoặc mọc ngầm phức tạp / răng', 'treatment', 2500000, 'Bảo hành: Cắt chỉ miễn phí. Ca phức tạp cần chia chân răng bằng máy siêu âm.'],
            ['PKG-WISDOM-NERVE-RISK', 'Nhổ răng khôn phức tạp sát dây thần kinh / răng', 'treatment', 3500000, 'Bảo hành: Cắt chỉ miễn phí. Bác sĩ đánh giá phim CT trước khi điều trị.'],
            ['PKG-WISDOM-PRF', 'Bổ sung màng huyết tương tự thân PRF / lần', 'treatment', 500000, 'Bảo hành: Tùy chọn thêm. Hỗ trợ cầm máu, giảm sưng và lành thương.'],

            ['PKG-ORTHO-METAL', 'Niềng răng mắc cài kim loại tiêu chuẩn / gói', 'orthodontic', 26000000, 'Bảo hành: Cam kết phác đồ. Hiệu quả cao, phù hợp học sinh và sinh viên.'],
            ['PKG-ORTHO-SELF-LIGATING', 'Niềng răng mắc cài kim loại tự buộc / gói', 'orthodontic', 32000000, 'Bảo hành: Cam kết phác đồ. Giảm ma sát, hỗ trợ rút ngắn thời gian điều trị.'],
            ['PKG-ORTHO-CERAMIC', 'Niềng răng mắc cài sứ tự buộc / gói', 'orthodontic', 42000000, 'Bảo hành: Cam kết phác đồ. Mắc cài màu gần với màu răng tự nhiên.'],
            ['PKG-ORTHO-INVISALIGN-LITE', 'Niềng răng trong suốt Invisalign Lite / gói', 'orthodontic', 68000000, 'Bảo hành: Chính hãng Mỹ. Phù hợp các ca lệch lạc nhẹ đến trung bình.'],
            ['PKG-ORTHO-INVISALIGN-COMPREHENSIVE', 'Niềng răng Invisalign Comprehensive / gói', 'orthodontic', 104000000, 'Bảo hành: Chính hãng Mỹ. Phác đồ toàn diện, mô phỏng 3D ClinCheck.'],

            ['PKG-CROWN-TITANIUM', 'Răng sứ Titan / răng', 'cosmetic', 2000000, 'Bảo hành: 5 năm. Sườn hợp kim Titan phủ sứ Ceramco.'],
            ['PKG-CROWN-ZIRCONIA', 'Răng toàn sứ Zirconia / răng', 'cosmetic', 3500000, 'Bảo hành: 10 năm. Sứ Đức, không đen viền nướu.'],
            ['PKG-CROWN-CERCON', 'Răng toàn sứ Cercon HT / răng', 'cosmetic', 4000000, 'Bảo hành: 12 năm. Sứ Dentsply Đức, độ trong mờ tự nhiên.'],
            ['PKG-CROWN-LAVA', 'Răng toàn sứ Lava Plus 3M / răng', 'cosmetic', 6500000, 'Bảo hành: 15 năm. Công nghệ 3M Hoa Kỳ, chịu lực cao.'],
            ['PKG-CROWN-VENEER-EMAX', 'Mặt dán sứ Veneer Emax / răng', 'cosmetic', 7500000, 'Bảo hành: 15 năm. Sứ Ivoclar Vivadent, siêu mỏng và bảo tồn răng thật.'],
            ['PKG-CROWN-ORODENT', 'Răng sứ Orodent High Translucent / răng', 'cosmetic', 9000000, 'Bảo hành: Trọn đời. Sứ Ý có độ trong quang học cao.'],

            ['PKG-WHITENING-TRAY', 'Tẩy trắng răng tại nhà kèm máng cá nhân / bộ', 'cosmetic', 1200000, 'Bảo hành: Hướng dẫn 1:1. Máng cá nhân và thuốc tẩy chính hãng.'],
            ['PKG-WHITENING-LASER', 'Tẩy trắng răng Laser Whitening tại phòng khám / ca', 'cosmetic', 2500000, 'Bảo hành: Hiệu quả ngay. Chiếu đèn ánh sáng lạnh khoảng 45 phút.'],
            ['PKG-WHITENING-COMBO', 'Gói tẩy trắng Laser và máng duy trì tại nhà', 'cosmetic', 2800000, 'Bảo hành: Trọn gói. Kết hợp tẩy trắng tại phòng khám và duy trì tại nhà.'],

            ['PKG-FILLING-COMPOSITE', 'Trám răng sâu Composite 3M / răng', 'treatment', 300000, 'Bảo hành: 6 tháng. Trám lỗ sâu mặt nhai hoặc mòn cổ răng.'],
            ['PKG-FILLING-COSMETIC', 'Trám răng thẩm mỹ răng cửa hoặc đóng khe thưa / răng', 'cosmetic', 500000, 'Bảo hành: 12 tháng. Composite Nano thẩm mỹ, trùng màu men răng.'],
            ['PKG-FILLING-INLAY', 'Trám Inlay / Onlay sứ CAD/CAM / răng', 'cosmetic', 3000000, 'Bảo hành: 5 năm. Miếng trám sứ chế tác CAD/CAM 3D.'],
        ];
    }

    public function up(): void
    {
        $now = now();

        foreach ($this->packages() as [$code, $name, $type, $price, $description]) {
            if (DB::table('services')->where('service_code', $code)->exists()) {
                continue;
            }

            $duration = match (true) {
                str_starts_with($code, 'PKG-IMPLANT-') => 90,
                str_starts_with($code, 'PKG-ORTHO-') => 60,
                str_starts_with($code, 'PKG-WHITENING-LASER') => 60,
                str_starts_with($code, 'PKG-WHITENING-') => 45,
                str_starts_with($code, 'PKG-WISDOM-') => 45,
                str_starts_with($code, 'PKG-ROOT-') => 60,
                str_starts_with($code, 'PKG-CROWN-') => 60,
                default => 30,
            };

            DB::table('services')->insert([
                'service_code' => $code,
                'name' => $name,
                'type' => $type,
                'price' => $price,
                'duration_minutes' => $duration,
                'description' => $description,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('services')->whereIn('service_code', array_column($this->packages(), 0))->delete();
    }
};
