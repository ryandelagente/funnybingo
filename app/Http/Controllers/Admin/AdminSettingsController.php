<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings', [
            'ga_id'            => config('app.google_analytics_id'),
            'adsense_client'   => config('app.adsense_client'),
            'admin_password'   => config('app.admin_password'),
            'gsc_verification' => config('app.gsc_verification'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'google_analytics_id' => ['nullable', 'string', 'max:30', 'regex:/^(G-[A-Z0-9]+)?$/'],
            'adsense_client'      => ['nullable', 'string', 'max:30', 'regex:/^(ca-pub-[0-9]+)?$/'],
            'gsc_verification'    => ['nullable', 'string', 'max:100'],
            'admin_password'      => ['required', 'string', 'min:8', 'max:100'],
        ]);

        $this->setEnvValue('GOOGLE_ANALYTICS_ID', $request->google_analytics_id ?? '');
        $this->setEnvValue('ADSENSE_CLIENT',      $request->adsense_client ?? '');
        $this->setEnvValue('GSC_VERIFICATION',    $request->gsc_verification ?? '');
        $this->setEnvValue('ADMIN_PASSWORD',      $request->admin_password);

        Artisan::call('config:clear');
        Artisan::call('config:cache');

        return redirect()->route('admin.settings')
                         ->with('success', 'Settings saved and config cache refreshed.');
    }

    private function setEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env');
        $env     = file_get_contents($envPath);

        if (str_contains($env, "{$key}=")) {
            $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
        } else {
            $env .= PHP_EOL . "{$key}={$value}";
        }

        file_put_contents($envPath, $env);
    }
}
