<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$models = [
    'Doctor', 'Receptionist', 'Patient', 'Service', 'Appointment',
    'MedicalRecord', 'MedicalRecordDetail', 'Prescription',
    'PrescriptionDetail', 'Invoice', 'InvoiceDetail', 'Payment', 'SystemSetting'
];

foreach ($models as $model) {
    echo "Generating $model...\n";
    Illuminate\Support\Facades\Artisan::call('make:model', ['name' => $model, '-m' => true, '-f' => true, '-s' => true]);
    echo Illuminate\Support\Facades\Artisan::output();
}
echo "Done!\n";
