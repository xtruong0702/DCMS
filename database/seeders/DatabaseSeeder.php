<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\Supply;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordDetail;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------------
        // 1. TẠO CÁC ROLE HỆ THỐNG
        // -------------------------------------------------------------
        $adminRole = Role::firstOrCreate(['name' => 'Admin'], ['description' => 'Quản trị viên toàn quyền']);
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor'], ['description' => 'Bác sĩ nha khoa chuyên khoa']);
        $receptionRole = Role::firstOrCreate(['name' => 'Receptionist'], ['description' => 'Nhân viên lễ tân & điều phối']);
        $patientRole = Role::firstOrCreate(['name' => 'Patient'], ['description' => 'Bệnh nhân & khách hàng']);

        // -------------------------------------------------------------
        // 2. CẤU HÌNH PHÒNG KHÁM (System Settings)
        // -------------------------------------------------------------
        $settings = [
            'clinic_name' => 'Nha Khoa Smile',
            'clinic_hotline' => '1900 1234',
            'clinic_address' => '123 Nguyễn Văn Cừ, Quận 5, TP. Hồ Chí Minh',
            'vat_percentage' => '10',
            'currency_unit' => 'VNĐ',
            'bank_id' => 'TCB',
            'bank_account_no' => '6362566666',
            'bank_account_name' => 'PHAM XUAN TRUONG',
        ];
        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(['setting_key' => $key], ['setting_value' => $value]);
        }

        // -------------------------------------------------------------
        // 3. TẠO TÀI KHOẢN ADMIN
        // -------------------------------------------------------------
        User::updateOrCreate(
            ['email' => 'admin@smile.com'],
            [
                'name' => 'Quản trị viên Hệ thống',
                'password' => Hash::make('password'),
                'phone' => '0901234567',
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // -------------------------------------------------------------
        // 4. DANH SÁCH LỄ TÂN (Receptionists)
        // -------------------------------------------------------------
        $receptionistsData = [
            [
                'name' => 'Lễ tân Ngọc Ánh',
                'email' => 'letan@smile.com',
                'phone' => '0912345678',
            ],
            [
                'name' => 'Lễ tân Mai Phương',
                'email' => 'phuong.letan@smile.com',
                'phone' => '0967890123',
            ],
        ];

        foreach ($receptionistsData as $rData) {
            $rUser = User::updateOrCreate(
                ['email' => $rData['email']],
                [
                    'name' => $rData['name'],
                    'password' => Hash::make('password'),
                    'phone' => $rData['phone'],
                    'role_id' => $receptionRole->id,
                    'is_active' => true,
                ]
            );
            Receptionist::firstOrCreate(['user_id' => $rUser->id]);
        }

        // -------------------------------------------------------------
        // 5. DANH SÁCH BÁC SĨ (Doctors)
        // -------------------------------------------------------------
        $doctorsData = [
            [
                'email' => 'bacsi@smile.com',
                'name' => 'BS. Trần Văn A',
                'phone' => '0923456789',
                'specialty' => 'Nha khoa Phục hình & Răng sứ thẩm mỹ',
                'description' => 'Hơn 10 năm kinh nghiệm chuyên sâu về dán sứ Veneer không mài nhỏ, bọc răng sứ thẩm mỹ Cercon/Lava cao cấp.',
            ],
            [
                'email' => 'nam.le@smile.com',
                'name' => 'BS. CKII Lê Hoàng Nam',
                'phone' => '0934567890',
                'specialty' => 'Cấy ghép Implant & Phục hình xương hàm',
                'description' => 'Tốt nghiệp Chuyên khoa II Đại học Y Dược TP.HCM, thành viên Hiệp hội Cấy ghép Implant Quốc tế (ITI), trên 3000 ca cấy ghép thành công.',
            ],
            [
                'email' => 'ha.nguyen@smile.com',
                'name' => 'ThS.BS Nguyễn Thu Hà',
                'phone' => '0945678901',
                'specialty' => 'Chỉnh nha - Niềng răng & Nha khoa trẻ em',
                'description' => 'Thạc sĩ Răng Hàm Mặt, Bác sĩ chứng chỉ chỉnh nha Invisalign Platinum Hoa Kỳ, chỉnh nha toàn diện cho người lớn và trẻ nhỏ.',
            ],
            [
                'email' => 'trong.vu@smile.com',
                'name' => 'BS. CKI Vũ Đức Trọng',
                'phone' => '0956789012',
                'specialty' => 'Tiểu phẫu Răng khôn & Bệnh lý nha chu',
                'description' => 'Bác sĩ chuyên khoa Phẫu thuật trong miệng, chuyên nhổ răng khôn mọc ngầm phức tạp không đau bằng sóng siêu âm Piezotome.',
            ],
        ];

        $doctors = [];
        foreach ($doctorsData as $dData) {
            $dUser = User::updateOrCreate(
                ['email' => $dData['email']],
                [
                    'name' => $dData['name'],
                    'password' => Hash::make('password'),
                    'phone' => $dData['phone'],
                    'role_id' => $doctorRole->id,
                    'is_active' => true,
                ]
            );
            $doctors[$dData['email']] = Doctor::updateOrCreate(
                ['user_id' => $dUser->id],
                [
                    'specialty' => $dData['specialty'],
                    'description' => $dData['description'],
                ]
            );
        }

        // -------------------------------------------------------------
        // 6. DANH MỤC DỊCH VỤ (Services)
        // -------------------------------------------------------------
        $servicesData = [
            ['service_code' => 'SV001', 'name' => 'Khám tổng quát & Tư vấn', 'price' => 100000, 'duration_minutes' => 20, 'type' => 'diagnostic'],
            ['service_code' => 'SV002', 'name' => 'Cạo vôi răng & Đánh bóng siêu âm', 'price' => 200000, 'duration_minutes' => 30, 'type' => 'treatment'],
            ['service_code' => 'SV003', 'name' => 'Nhổ răng khôn không đau (Piezotome)', 'price' => 1500000, 'duration_minutes' => 45, 'type' => 'treatment'],
            ['service_code' => 'SV004', 'name' => 'Trám răng thẩm mỹ Composite 3M', 'price' => 300000, 'duration_minutes' => 30, 'type' => 'treatment'],
            ['service_code' => 'SV005', 'name' => 'Tẩy trắng răng Laser Whitening', 'price' => 2500000, 'duration_minutes' => 60, 'type' => 'cosmetic'],
            ['service_code' => 'SV006', 'name' => 'Điều trị tủy răng (Nội nha)', 'price' => 1200000, 'duration_minutes' => 60, 'type' => 'treatment'],
            ['service_code' => 'SV007', 'name' => 'Trồng răng Implant Straumann Thụy Sĩ', 'price' => 25000000, 'duration_minutes' => 90, 'type' => 'implant'],
            ['service_code' => 'SV008', 'name' => 'Niềng răng mắc cài kim loại tự buộc', 'price' => 32000000, 'duration_minutes' => 60, 'type' => 'orthodontic'],
            ['service_code' => 'SV009', 'name' => 'Bọc răng sứ thẩm mỹ Cercon HT', 'price' => 4000000, 'duration_minutes' => 60, 'type' => 'cosmetic'],
        ];

        $services = [];
        foreach ($servicesData as $s) {
            $services[$s['service_code']] = Service::updateOrCreate(
                ['service_code' => $s['service_code']],
                [
                    'name' => $s['name'],
                    'price' => $s['price'],
                    'duration_minutes' => $s['duration_minutes'],
                    'type' => $s['type'],
                    'is_active' => true,
                ]
            );
        }

        // -------------------------------------------------------------
        // 7. DANH MỤC THUỐC (Medicines)
        // -------------------------------------------------------------
        $medicinesData = [
            [
                'name' => 'Amoxicillin 500mg',
                'category' => 'Kháng sinh',
                'unit' => 'Viên',
                'import_price' => 1500,
                'price' => 2500,
                'stock_quantity' => 500,
                'expiry_date' => Carbon::now()->addYears(2)->toDateString(),
                'description' => 'Kháng sinh phổ rộng phòng ngừa và điều trị nhiễm khuẩn răng miệng.'
            ],
            [
                'name' => 'Paracetamol 500mg',
                'category' => 'Giảm đau - Hạ sốt',
                'unit' => 'Viên',
                'import_price' => 800,
                'price' => 1500,
                'stock_quantity' => 1000,
                'expiry_date' => Carbon::now()->addYears(3)->toDateString(),
                'description' => 'Giảm đau nhẹ đến vừa, hạ sốt sau các thủ thuật nha khoa thông thường.'
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'category' => 'Kháng viêm - Giảm đau (NSAID)',
                'unit' => 'Viên',
                'import_price' => 1200,
                'price' => 2000,
                'stock_quantity' => 400,
                'expiry_date' => Carbon::now()->addYears(2)->toDateString(),
                'description' => 'Kháng viêm và giảm đau hiệu quả trong đau tủy răng và sau tiểu phẫu.'
            ],
            [
                'name' => 'Rodogyl (Spiramycin + Metronidazol)',
                'category' => 'Kháng sinh nha khoa đặc trị',
                'unit' => 'Viên',
                'import_price' => 3000,
                'price' => 5000,
                'stock_quantity' => 350,
                'expiry_date' => Carbon::now()->addYears(2)->toDateString(),
                'description' => 'Kháng sinh kết hợp đặc trị viêm nha chu, viêm nướu, áp xe ổ răng.'
            ],
            [
                'name' => 'Nước súc miệng Chlorhexidine 0.12%',
                'category' => 'Dung dịch sát khuẩn miệng',
                'unit' => 'Chai',
                'import_price' => 45000,
                'price' => 75000,
                'stock_quantity' => 150,
                'expiry_date' => Carbon::now()->addYears(1)->toDateString(),
                'description' => 'Sát khuẩn khoang miệng, chống mảng bám, thúc đẩy lành thương nướu.'
            ],
            [
                'name' => 'Efferalgan Codeine',
                'category' => 'Giảm đau mạnh kết hợp',
                'unit' => 'Viên',
                'import_price' => 4000,
                'price' => 6500,
                'stock_quantity' => 250,
                'expiry_date' => Carbon::now()->addYears(2)->toDateString(),
                'description' => 'Giảm đau mức độ vừa và nặng sau nhổ răng khôn hoặc phẫu thuật xương hàm.'
            ],
            [
                'name' => 'Vitamin C 500mg',
                'category' => 'Vitamin & Khoáng chất',
                'unit' => 'Viên',
                'import_price' => 500,
                'price' => 1000,
                'stock_quantity' => 600,
                'expiry_date' => Carbon::now()->addYears(2)->toDateString(),
                'description' => 'Bổ sung vitamin C, hỗ trợ tăng sức bền mao mạch và lành thương nhanh.'
            ],
        ];

        $medicines = [];
        foreach ($medicinesData as $m) {
            $medicines[$m['name']] = Medicine::updateOrCreate(['name' => $m['name']], $m);
        }

        // -------------------------------------------------------------
        // 8. VẬT TƯ TIÊU HAO (Supplies)
        // -------------------------------------------------------------
        $suppliesData = [
            ['name' => 'Găng tay y tế Nitrile không bột', 'unit' => 'Hộp', 'import_price' => 85000, 'stock_quantity' => 60, 'minimum_stock' => 10],
            ['name' => 'Thuốc tê Septanest 4% SP (Pháp)', 'unit' => 'Ống', 'import_price' => 18000, 'stock_quantity' => 200, 'minimum_stock' => 30],
            ['name' => 'Kim gây tê nha khoa 30G siêu ngắn', 'unit' => 'Hộp', 'import_price' => 120000, 'stock_quantity' => 35, 'minimum_stock' => 5],
            ['name' => 'Bông gòn tiệt trùng nha khoa dạng cuộn', 'unit' => 'Gói', 'import_price' => 25000, 'stock_quantity' => 80, 'minimum_stock' => 15],
            ['name' => 'Chỉ khâu phẫu thuật tự tiêu Vicryl 4.0', 'unit' => 'Tép', 'import_price' => 65000, 'stock_quantity' => 120, 'minimum_stock' => 20],
        ];
        foreach ($suppliesData as $sup) {
            Supply::updateOrCreate(['name' => $sup['name']], $sup);
        }

        // -------------------------------------------------------------
        // 9. DANH SÁCH BỆNH NHÂN (Patients) & TÀI KHOẢN ĐĂNG NHẬP
        // -------------------------------------------------------------
        $patientsData = [
            [
                'patient_code' => 'BN2026110001',
                'name' => 'Nguyễn Văn Hùng',
                'email' => 'hung.nguyen@gmail.com',
                'phone' => '0981112233',
                'gender' => 'Nam',
                'dob' => '1988-06-12',
                'cccd' => '001088001234',
                'job' => 'Kỹ sư phần mềm',
                'address' => 'Số 15, Lê Duẩn, Quận 1, TP. Hồ Chí Minh',
                'allergy_history' => 'Dị ứng Penicillin',
                'medical_history' => 'Viêm dạ dày nhẹ',
                'contact_person' => 'Vợ: Lê Thị Thoa (0981112234)',
            ],
            [
                'patient_code' => 'BN2026110002',
                'name' => 'Trần Thị Mai',
                'email' => 'mai.tran@gmail.com',
                'phone' => '0982223344',
                'gender' => 'Nữ',
                'dob' => '1995-10-24',
                'cccd' => '079195002345',
                'job' => 'Chuyên viên tài chính ngân hàng',
                'address' => '45/8 Huỳnh Tấn Phát, Quận 7, TP. Hồ Chí Minh',
                'allergy_history' => 'Không có tiền sử dị ứng thuốc',
                'medical_history' => 'Khỏe mạnh bình thường',
                'contact_person' => 'Mẹ: Nguyễn Thị Hòa (0982223345)',
            ],
            [
                'patient_code' => 'BN2026110003',
                'name' => 'Lê Quốc Bảo',
                'email' => 'bao.le@gmail.com',
                'phone' => '0983334455',
                'gender' => 'Nam',
                'dob' => '2001-03-18',
                'cccd' => '079201003456',
                'job' => 'Sinh viên Đại học Bách Khoa',
                'address' => '78 Sư Vạn Hạnh, Quận 10, TP. Hồ Chí Minh',
                'allergy_history' => 'Không dị ứng',
                'medical_history' => 'Bình thường',
                'contact_person' => 'Bố: Lê Văn Tuấn (0983334456)',
            ],
            [
                'patient_code' => 'BN2026110004',
                'name' => 'Hoàng Minh Anh',
                'email' => 'minhanh.hoang@gmail.com',
                'phone' => '0984445566',
                'gender' => 'Nữ',
                'dob' => '1992-12-05',
                'cccd' => '079192004567',
                'job' => 'Trưởng phòng Marketing',
                'address' => '120 Nguyễn Thị Minh Khai, Quận 3, TP. Hồ Chí Minh',
                'allergy_history' => 'Dị ứng Aspirin',
                'medical_history' => 'Huyết áp thấp',
                'contact_person' => 'Chồng: Trần Hoàng Nam (0984445567)',
            ],
            [
                'patient_code' => 'BN2026110005',
                'name' => 'Đặng Thu Thảo',
                'email' => 'thuthao.dang@gmail.com',
                'phone' => '0985556677',
                'gender' => 'Nữ',
                'dob' => '1998-08-30',
                'cccd' => '079198005678',
                'job' => 'Chủ shop thời trang',
                'address' => '35 Quang Trung, Gò Vấp, TP. Hồ Chí Minh',
                'allergy_history' => 'Không',
                'medical_history' => 'Khỏe mạnh',
                'contact_person' => 'Em gái: Đặng Thu Trang (0985556678)',
            ],
            [
                'patient_code' => 'BN2026110006',
                'name' => 'Phạm Đức Thắng',
                'email' => 'thang.pham@gmail.com',
                'phone' => '0986667788',
                'gender' => 'Nam',
                'dob' => '1975-04-16',
                'cccd' => '079075006789',
                'job' => 'Giám đốc doanh nghiệp',
                'address' => '210 Phan Xích Long, Phú Nhuận, TP. Hồ Chí Minh',
                'allergy_history' => 'Không ghi nhận',
                'medical_history' => 'Tiểu đường tuýp 2 thể nhẹ (đang kiểm soát đường huyết ổn định)',
                'contact_person' => 'Vợ: Nguyễn Thúy Nga (0986667789)',
            ],
        ];

        $patients = [];
        foreach ($patientsData as $pData) {
            // Tạo User cho Bệnh nhân để họ có thể đăng nhập bằng Phone hoặc Email
            $pUser = User::updateOrCreate(
                ['phone' => $pData['phone']],
                [
                    'name' => $pData['name'],
                    'email' => $pData['email'],
                    'password' => Hash::make('password'),
                    'role_id' => $patientRole->id,
                    'cccd' => $pData['cccd'],
                    'address' => $pData['address'],
                    'is_active' => true,
                ]
            );

            // Tạo Patient record
            $patients[$pData['patient_code']] = Patient::updateOrCreate(
                ['patient_code' => $pData['patient_code']],
                [
                    'name' => $pData['name'],
                    'gender' => $pData['gender'],
                    'dob' => $pData['dob'],
                    'job' => $pData['job'],
                    'address' => $pData['address'],
                    'email' => $pData['email'],
                    'phone' => $pData['phone'],
                    'allergy_history' => $pData['allergy_history'],
                    'medical_history' => $pData['medical_history'],
                    'contact_person' => $pData['contact_person'],
                    'user_id' => $pUser->id,
                ]
            );
        }

        // -------------------------------------------------------------
        // 10. TẠO LỊCH HẸN, HỒ SƠ BỆNH ÁN, ĐƠN THUỐC, HÓA ĐƠN CHI TIẾT
        // -------------------------------------------------------------

        // =============================================================
        // CA 1: Bệnh nhân Nguyễn Văn Hùng - Nhổ răng khôn Piezotome
        // Trạng thái: ĐÃ HOÀN THÀNH - HÓA ĐƠN ĐÃ THANH TOÁN QUA VIETQR
        // =============================================================
        $p1 = $patients['BN2026110001'];
        $doc1 = $doctors['trong.vu@smile.com'];
        $srv1 = $services['SV003'];

        $apt1 = Appointment::updateOrCreate(
            ['patient_id' => $p1->id, 'appointment_time' => Carbon::now()->subDays(5)->setTime(9, 30)],
            [
                'doctor_id' => $doc1->id,
                'service_id' => $srv1->id,
                'status' => 'completed',
                'note' => 'Bệnh nhân đau sưng góc hàm dưới bên trái nhiều ngày, cần khám và chỉ định nhổ răng khôn.',
            ]
        );

        $teethData1 = json_encode([
            '38' => ['status' => 'impacted', 'note' => 'Răng khôn mọc lệch 90 độ, kẹt chân răng số 37, lợi trùm sưng phù nề'],
        ]);

        $medRecord1 = MedicalRecord::updateOrCreate(
            ['appointment_id' => $apt1->id],
            [
                'patient_id' => $p1->id,
                'doctor_id' => $doc1->id,
                'symptoms' => 'Đau nhức dữ dội góc hàm trái, há miệng hạn chế, nướu trùm quanh thân răng 38 sưng đỏ có mủ nhẹ.',
                'diagnosis' => 'Viêm lợi trùm cấp răng khôn hàm dưới mọc lệch ngầm (Răng số 38).',
                'treatment_plan' => 'Gây tê vùng Septanest, rạch vạt bộc lộ, chia cắt thân răng và nhổ bằng máy Piezotome không sang chấn, bơm rửa sạch, khâu tự tiêu Vicryl 4.0.',
                'teeth_data' => $teethData1,
                'note' => 'Ca tiểu phẫu thành công, bệnh nhân cầm máu tốt, dặn dò kiêng cữ kỹ sau nhổ.',
            ]
        );

        MedicalRecordDetail::updateOrCreate(
            ['medical_record_id' => $medRecord1->id, 'service_id' => $srv1->id],
            ['quantity' => 1, 'note' => 'Nhổ răng số 38 bằng máy siêu âm Piezotome']
        );

        // Kê đơn thuốc cho Ca 1
        $prescription1 = Prescription::updateOrCreate(
            ['medical_record_id' => $medRecord1->id],
            [
                'note' => 'Uống thuốc đúng giờ sau bữa ăn. Chườm lạnh má trong 24h đầu, không khạc nhổ mạnh, không dùng ống hút.',
                'follow_up_date' => Carbon::now()->addDays(2)->setTime(9, 30),
            ]
        );

        $medRodogyl = $medicines['Rodogyl (Spiramycin + Metronidazol)'];
        $medPara = $medicines['Paracetamol 500mg'];
        $medChlor = $medicines['Nước súc miệng Chlorhexidine 0.12%'];

        PrescriptionDetail::updateOrCreate(
            ['prescription_id' => $prescription1->id, 'medicine_name' => $medRodogyl->name],
            [
                'medicine_id' => $medRodogyl->id,
                'dosage' => '2 viên/ngày chia 2 lần',
                'quantity' => 20,
                'usage_morning' => '1 viên',
                'usage_noon' => '',
                'usage_evening' => '1 viên',
                'usage_night' => '',
                'instructions' => 'Uống sau bữa ăn no, không dùng đồ uống có cồn.',
            ]
        );

        PrescriptionDetail::updateOrCreate(
            ['prescription_id' => $prescription1->id, 'medicine_name' => $medPara->name],
            [
                'medicine_id' => $medPara->id,
                'dosage' => '500mg mỗi lần khi đau',
                'quantity' => 10,
                'usage_morning' => '1 viên',
                'usage_noon' => '',
                'usage_evening' => '1 viên',
                'usage_night' => '',
                'instructions' => 'Cách 4-6 tiếng uống 1 viên nếu đau nhiều.',
            ]
        );

        PrescriptionDetail::updateOrCreate(
            ['prescription_id' => $prescription1->id, 'medicine_name' => $medChlor->name],
            [
                'medicine_id' => $medChlor->id,
                'dosage' => '15ml ngậm 1 phút',
                'quantity' => 1,
                'usage_morning' => '1 lần',
                'usage_noon' => '',
                'usage_evening' => '1 lần',
                'usage_night' => '',
                'instructions' => 'Súc miệng nhẹ nhàng sau đánh răng, không nuốt.',
            ]
        );

        // Hóa đơn Ca 1 (Đã thanh toán)
        $inv1Subtotal = 1500000 + 175000; // Dịch vụ 1.500.000 + Gói thuốc 175.000
        $inv1Vat = $inv1Subtotal * 0.10;
        $inv1Total = $inv1Subtotal + $inv1Vat;

        $inv1 = Invoice::updateOrCreate(
            ['invoice_code' => 'HD2026111901'],
            [
                'patient_id' => $p1->id,
                'appointment_id' => $apt1->id,
                'total_amount' => $inv1Subtotal,
                'discount' => 0,
                'vat_amount' => $inv1Vat,
                'final_amount' => $inv1Total,
                'status' => 'paid',
            ]
        );

        InvoiceDetail::updateOrCreate(
            ['invoice_id' => $inv1->id, 'item_name' => 'Nhổ răng khôn không đau (Piezotome) - R38'],
            ['unit_price' => 1500000, 'quantity' => 1, 'total_price' => 1500000]
        );

        InvoiceDetail::updateOrCreate(
            ['invoice_id' => $inv1->id, 'item_name' => 'Gói thuốc & Nước súc miệng hậu phẫu'],
            ['unit_price' => 175000, 'quantity' => 1, 'total_price' => 175000]
        );

        Payment::updateOrCreate(
            ['invoice_id' => $inv1->id],
            [
                'payment_method' => 'qr',
                'amount' => $inv1Total,
                'status' => 'completed',
            ]
        );

        // =============================================================
        // CA 2: Bệnh nhân Trần Thị Mai - Cạo vôi răng & Trám răng composite
        // Trạng thái: ĐÃ KHÁM XONG - HÓA ĐƠN CHƯA THANH TOÁN (DEMO QUÉT QR)
        // =============================================================
        $p2 = $patients['BN2026110002'];
        $doc2 = $doctors['bacsi@smile.com'];
        $srv2 = $services['SV002'];
        $srv4 = $services['SV004'];

        $apt2 = Appointment::updateOrCreate(
            ['patient_id' => $p2->id, 'appointment_time' => Carbon::now()->setTime(8, 30)],
            [
                'doctor_id' => $doc2->id,
                'service_id' => $srv2->id,
                'status' => 'completed',
                'note' => 'Khách hàng cảm thấy ê buốt nhẹ khi uống nước đá lạnh, muốn vệ sinh răng miệng và kiểm tra sâu răng.',
            ]
        );

        $teethData2 = json_encode([
            '46' => ['status' => 'decay', 'note' => 'Sâu men ngà mặt nhai rãnh sâu'],
            '11' => ['status' => 'calculus', 'note' => 'Vôi răng mảng bám cổ răng độ 2'],
            '21' => ['status' => 'calculus', 'note' => 'Vôi răng mảng bám cổ răng độ 2'],
            '31' => ['status' => 'calculus', 'note' => 'Vôi răng dưới nướu'],
            '41' => ['status' => 'calculus', 'note' => 'Vôi răng dưới nướu'],
        ]);

        $medRecord2 = MedicalRecord::updateOrCreate(
            ['appointment_id' => $apt2->id],
            [
                'patient_id' => $p2->id,
                'doctor_id' => $doc2->id,
                'symptoms' => 'Chảy máu nướu khi chải răng buổi sáng, ê buốt thoáng qua ở răng cối lớn hàm dưới bên phải khi ăn ngọt.',
                'diagnosis' => 'Viêm nướu do vôi răng toàn hàm độ 2 + Sâu men ngà răng 46 mặt nhai.',
                'treatment_plan' => 'Lấy cao răng siêu âm toàn hàm, đánh bóng men răng; nạo sạch mô ngà mủn răng 46, soi etching, bonding và trám thẩm mỹ Composite 3M.',
                'teeth_data' => $teethData2,
                'note' => 'Trám răng 46 khớp cắn tốt, bệnh nhân hài lòng.',
            ]
        );

        MedicalRecordDetail::updateOrCreate(
            ['medical_record_id' => $medRecord2->id, 'service_id' => $srv2->id],
            ['quantity' => 1, 'note' => 'Cạo vôi răng siêu âm & Đánh bóng 2 hàm']
        );
        MedicalRecordDetail::updateOrCreate(
            ['medical_record_id' => $medRecord2->id, 'service_id' => $srv4->id],
            ['quantity' => 1, 'note' => 'Trám thẩm mỹ composite mặt nhai răng 46']
        );

        // Kê đơn thuốc Ca 2
        $prescription2 = Prescription::updateOrCreate(
            ['medical_record_id' => $medRecord2->id],
            [
                'note' => 'Duy trì thói quen dùng chỉ nha khoa, súc miệng hàng ngày. Hạn chế nhai đồ quá cứng trong 24h đầu.',
                'follow_up_date' => Carbon::now()->addMonths(6),
            ]
        );

        PrescriptionDetail::updateOrCreate(
            ['prescription_id' => $prescription2->id, 'medicine_name' => $medChlor->name],
            [
                'medicine_id' => $medChlor->id,
                'dosage' => 'Ngậm 15ml buổi tối',
                'quantity' => 1,
                'usage_morning' => '',
                'usage_noon' => '',
                'usage_evening' => '1 lần',
                'usage_night' => '',
                'instructions' => 'Sau khi đánh răng, ngậm súc trong 60 giây.',
            ]
        );

        // Hóa đơn Ca 2: CHƯA THANH TOÁN (Unpaid) để test thanh toán trực tiếp!
        $inv2Subtotal = 200000 + 300000 + 75000; // Cạo vôi + Trám răng + Nước súc miệng
        $inv2Vat = $inv2Subtotal * 0.10;
        $inv2Total = $inv2Subtotal + $inv2Vat;

        $inv2 = Invoice::updateOrCreate(
            ['invoice_code' => 'HD2026112401'],
            [
                'patient_id' => $p2->id,
                'appointment_id' => $apt2->id,
                'total_amount' => $inv2Subtotal,
                'discount' => 0,
                'vat_amount' => $inv2Vat,
                'final_amount' => $inv2Total,
                'status' => 'unpaid', // Cực kỳ tiện cho demo quét QR tự động!
            ]
        );

        InvoiceDetail::updateOrCreate(
            ['invoice_id' => $inv2->id, 'item_name' => 'Cạo vôi răng & Đánh bóng siêu âm'],
            ['unit_price' => 200000, 'quantity' => 1, 'total_price' => 200000]
        );
        InvoiceDetail::updateOrCreate(
            ['invoice_id' => $inv2->id, 'item_name' => 'Trám răng thẩm mỹ Composite 3M (R46)'],
            ['unit_price' => 300000, 'quantity' => 1, 'total_price' => 300000]
        );
        InvoiceDetail::updateOrCreate(
            ['invoice_id' => $inv2->id, 'item_name' => 'Nước súc miệng Chlorhexidine 0.12%'],
            ['unit_price' => 75000, 'quantity' => 1, 'total_price' => 75000]
        );

        // =============================================================
        // CA 3: Bệnh nhân Lê Quốc Bảo - Tư vấn chỉnh nha niềng răng
        // Trạng thái: ĐANG KHÁM (in_progress)
        // =============================================================
        $p3 = $patients['BN2026110003'];
        $doc3 = $doctors['ha.nguyen@smile.com'];
        $srv8 = $services['SV008'];

        $apt3 = Appointment::updateOrCreate(
            ['patient_id' => $p3->id, 'appointment_time' => Carbon::now()->setTime(10, 15)],
            [
                'doctor_id' => $doc3->id,
                'service_id' => $srv8->id,
                'status' => 'in_progress',
                'note' => 'Bệnh nhân cảm thấy thiếu tự tin vì răng cửa hàm trên chen chúc khấp khểnh, muốn tư vấn gói niềng răng.',
            ]
        );

        MedicalRecord::updateOrCreate(
            ['appointment_id' => $apt3->id],
            [
                'patient_id' => $p3->id,
                'doctor_id' => $doc3->id,
                'symptoms' => 'Chen chúc răng cửa trên và dưới độ II, khớp cắn sâu nhẹ.',
                'diagnosis' => 'Lệch lạc răng hàm mặt Angle Class II tiểu nhóm 1, chen chúc răng trước.',
                'treatment_plan' => 'Lấy dấu hàm thạch cao, chụp phim X-Quang Panorama và Cephalo, lên phác đồ niềng răng mắc cài tự buộc 18 tháng.',
                'teeth_data' => json_encode(['12' => ['status' => 'misaligned', 'note' => 'Mọc lệch vào trong'], '22' => ['status' => 'misaligned', 'note' => 'Xoay trục 30 độ']]),
                'note' => 'Đang tiến hành tư vấn kế hoạch niềng răng và phân tích chi phí cho phụ huynh và bệnh nhân.',
            ]
        );

        // =============================================================
        // CA 4: Bệnh nhân Hoàng Minh Anh - Tẩy trắng răng Laser
        // Trạng thái: ĐANG CHỜ KHÁM (waiting) - Đã check-in tại quầy
        // =============================================================
        $p4 = $patients['BN2026110004'];
        $srv5 = $services['SV005'];

        Appointment::updateOrCreate(
            ['patient_id' => $p4->id, 'appointment_time' => Carbon::now()->setTime(14, 00)],
            [
                'doctor_id' => $doc2->id,
                'service_id' => $srv5->id,
                'status' => 'waiting',
                'note' => 'Khách hàng chuẩn bị chụp ảnh cưới cuối tuần, đặt lịch tẩy trắng răng Laser Whitening sáng bật tông.',
            ]
        );

        // =============================================================
        // CA 5: Bệnh nhân Đặng Thu Thảo - Đau nhức buốt răng số 16
        // Trạng thái: ĐÃ XÁC NHẬN (confirmed) - Lịch hẹn ngày mai
        // =============================================================
        $p5 = $patients['BN2026110005'];
        $docNam = $doctors['nam.le@smile.com'];
        $srv6 = $services['SV006'];

        Appointment::updateOrCreate(
            ['patient_id' => $p5->id, 'appointment_time' => Carbon::now()->addDay()->setTime(9, 00)],
            [
                'doctor_id' => $docNam->id,
                'service_id' => $srv6->id,
                'status' => 'confirmed',
                'note' => 'Đau nhức buốt giật theo nhịp đập ở răng hàm trên bên phải về đêm, uống thuốc giảm đau không đỡ.',
            ]
        );

        // =============================================================
        // CA 6: Bệnh nhân Phạm Đức Thắng - Mất răng 36, muốn trồng Implant
        // Trạng thái: ĐANG CHỜ DUYỆT (pending) - Lịch hẹn mới đặt online
        // =============================================================
        $p6 = $patients['BN2026110006'];
        $srv7 = $services['SV007'];

        Appointment::updateOrCreate(
            ['patient_id' => $p6->id, 'appointment_time' => Carbon::now()->addDays(2)->setTime(15, 30)],
            [
                'doctor_id' => $docNam->id,
                'service_id' => $srv7->id,
                'status' => 'pending',
                'note' => 'Khách hàng bị mất răng cối hàm dưới số 36 đã lâu, ăn nhai khó khăn, muốn được tư vấn cấy ghép Implant Straumann.',
            ]
        );

        // =============================================================
        // CA 7: Lịch sử khám cũ hoàn thành của Phạm Đức Thắng (2 tuần trước)
        // Trạng thái: ĐÃ HOÀN THÀNH - HÓA ĐƠN ĐÃ THANH TOÁN TIỀN MẶT
        // =============================================================
        $apt7 = Appointment::updateOrCreate(
            ['patient_id' => $p6->id, 'appointment_time' => Carbon::now()->subDays(14)->setTime(10, 00)],
            [
                'doctor_id' => $docNam->id,
                'service_id' => $services['SV001']->id,
                'status' => 'completed',
                'note' => 'Khám tổng quát định kỳ và kiểm tra mật độ xương hàm vùng mất răng số 36.',
            ]
        );

        $medRecord7 = MedicalRecord::updateOrCreate(
            ['appointment_id' => $apt7->id],
            [
                'patient_id' => $p6->id,
                'doctor_id' => $docNam->id,
                'symptoms' => 'Mất răng cối 36 khoảng 2 năm, tụt nướu nhẹ vùng lân cận.',
                'diagnosis' => 'Mất răng số 36 kèm tiêu xương sống hàm mức độ I.',
                'treatment_plan' => 'Chụp phim CT ConeBeam 3D, lập kế hoạch đặt trụ Implant Straumann đường kính 4.1mm, hẹn tuần sau thực hiện.',
                'teeth_data' => json_encode(['36' => ['status' => 'missing', 'note' => 'Đã mất răng, lành thương hoàn toàn']]),
                'note' => 'Chỉ số đường huyết bệnh nhân 6.2 mmol/L ổn định, đủ điều kiện tiến hành cấy ghép Implant an toàn.',
            ]
        );

        MedicalRecordDetail::updateOrCreate(
            ['medical_record_id' => $medRecord7->id, 'service_id' => $services['SV001']->id],
            ['quantity' => 1, 'note' => 'Khám tổng quát chuyên sâu & tư vấn kế hoạch điều trị']
        );

        $inv7Subtotal = 100000;
        $inv7Vat = 10000;
        $inv7Total = 110000;

        $inv7 = Invoice::updateOrCreate(
            ['invoice_code' => 'HD2026111001'],
            [
                'patient_id' => $p6->id,
                'appointment_id' => $apt7->id,
                'total_amount' => $inv7Subtotal,
                'discount' => 0,
                'vat_amount' => $inv7Vat,
                'final_amount' => $inv7Total,
                'status' => 'paid',
            ]
        );

        InvoiceDetail::updateOrCreate(
            ['invoice_id' => $inv7->id, 'item_name' => 'Khám tổng quát & Tư vấn chuyên sâu'],
            ['unit_price' => 100000, 'quantity' => 1, 'total_price' => 100000]
        );

        Payment::updateOrCreate(
            ['invoice_id' => $inv7->id],
            [
                'payment_method' => 'cash',
                'amount' => $inv7Total,
                'status' => 'completed',
            ]
        );

        $this->command->info('=== KHỞI TẠO DỮ LIỆU SEEDER THÀNH CÔNG ===');
        $this->command->info('- Quản trị viên: admin@smile.com (Mật khẩu: password)');
        $this->command->info('- Bác sĩ (4): bacsi@smile.com, nam.le@smile.com, ha.nguyen@smile.com, trong.vu@smile.com');
        $this->command->info('- Lễ tân (2): letan@smile.com, phuong.letan@smile.com');
        $this->command->info('- Bệnh nhân (6): Hùng, Mai, Bảo, Minh Anh, Thảo, Thắng (Tất cả mật khẩu: password)');
        $this->command->info('- Danh mục Dịch vụ (9), Thuốc (7), Vật tư tiêu hao (5)');
        $this->command->info('- Hồ sơ bệnh án, Sơ đồ răng, Đơn thuốc, Hóa đơn (Đã TT qua VietQR & Chưa TT demo)');
    }
}
