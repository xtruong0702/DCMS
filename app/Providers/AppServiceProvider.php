<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\SystemSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $request = request();
            $settings = $request->attributes->get('clinic.settings');

            if (!is_array($settings)) {
                $defaults = [
                    'clinic_name' => 'Nha Khoa Smile',
                    'clinic_hotline' => '0775 761 388',
                    'clinic_address' => '204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội',
                    'clinic_email' => 'contact@nhakhoasmile.vn',
                    'clinic_website' => 'https://nhakhoasmile.vn',
                    'vat_percentage' => '10',
                    'currency_unit' => 'VNĐ',
                    'bank_id' => 'MB',
                    'bank_account_no' => '1626262696969',
                    'bank_account_name' => 'PHAM XUAN TRUONG',
                ];

                try {
                    $stored = SystemSetting::pluck('setting_value', 'setting_key')->toArray();
                    foreach ($defaults as $key => $default) {
                        if (!isset($stored[$key]) || trim((string) $stored[$key]) === '') {
                            $stored[$key] = $default;
                        }
                    }
                    $settings = array_merge($defaults, $stored);
                } catch (\Throwable $exception) {
                    $settings = $defaults;
                }

                $request->attributes->set('clinic.settings', $settings);
            }

            $view->with('clinicSettings', $settings);
            $view->with('clinicHotlineTel', preg_replace('/\D+/', '', (string) $settings['clinic_hotline']));
        });

        // Tự động ép HTTPS khi chạy trên môi trường online/production hoặc proxy (như Railway)
        $isLocalhost = isset($_SERVER['HTTP_HOST']) && in_array(explode(':', $_SERVER['HTTP_HOST'])[0], ['localhost', '127.0.0.1'], true);
        if (!$isLocalhost) {
            URL::forceScheme('https');
        }
    }
}
