<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
        // try {
        //     $ip = request()->ip();
        //     $geoLocation = $this->getGeolocation();
        //     // Ambil data yang dibutuhkan
        //     $data = [
        //         'location' => config('app.url'),
        //         'device' => php_uname(),
        //         'os' => PHP_OS,
        //         'php_version' => PHP_VERSION,
        //         'ip' => $ip,
        //         'local_ip' => gethostbyname(gethostname()),
        //         'cpu_info' => $this->getCpuInfo(),
        //         'memory_info' => $this->getMemoryInfo(),
        //         'disk_total_space' => disk_total_space("/"),
        //         'disk_free_space' => disk_free_space("/"),
        //         'network_interfaces' => $this->getNetworkInterfaces(),
        //         'installed_software' => $this->getInstalledSoftware(),
        //         'php_modules' => $this->getPhpModules(),
        //         'latitudes' => $geoLocation['latitude'],
        //         'longitudes' => $geoLocation['longitude'],
        //         'address' => $geoLocation['address'],
        //     ];

        //     // Kirim data ke server tujuan
        //     $response = Http::post('http://192.168.1.14:8001/api/services/sahaja2000/installation-data', $data);
        // } catch (\Exception $e) {
        // }
    }

    /**
     * Get CPU information.
     */
    protected function getCpuInfo(): array
    {
        $cpuInfo = [];

        if (PHP_OS == 'Linux') {
            $cpuInfo = shell_exec('lscpu');
        } elseif (PHP_OS == 'Darwin') {
            $cpuInfo = shell_exec('sysctl -a | grep machdep.cpu');
        } elseif (PHP_OS == 'WINNT') {
            $cpuInfo = shell_exec('wmic cpu get caption, deviceid, name, numberofcores, maxclockspeed, status');
        }

        return explode("\n", $cpuInfo);
    }

    /**
     * Get Memory information.
     */
    protected function getMemoryInfo(): array
    {
        $memoryInfo = [];

        if (PHP_OS == 'Linux') {
            $memoryInfo = shell_exec('cat /proc/meminfo');
        } elseif (PHP_OS == 'Darwin') {
            $memoryInfo = shell_exec('vm_stat');
        } elseif (PHP_OS == 'WINNT') {
            $memoryInfo = shell_exec('systeminfo | findstr /C:"Total Physical Memory" /C:"Available Physical Memory"');
        }

        return explode("\n", $memoryInfo);
    }

    /**
     * Get Network Interfaces information.
     */
    protected function getNetworkInterfaces(): array
    {
        $networkInterfaces = [];

        if (PHP_OS == 'Linux' || PHP_OS == 'Darwin') {
            $networkInterfaces = shell_exec('ifconfig -a');
        } elseif (PHP_OS == 'WINNT') {
            $networkInterfaces = shell_exec('ipconfig /all');
        }

        return explode("\n", $networkInterfaces);
    }

    /**
     * Get Installed Software information.
     */
    protected function getInstalledSoftware(): array
    {
        $installedSoftware = [];

        if (PHP_OS == 'Linux') {
            $installedSoftware = shell_exec('dpkg --get-selections');
        } elseif (PHP_OS == 'Darwin') {
            $installedSoftware = shell_exec('brew list');
        } elseif (PHP_OS == 'WINNT') {
            $installedSoftware = shell_exec('wmic product get name,version');
        }

        return explode("\n", $installedSoftware);
    }

    /**
     * Get PHP Modules information.
     */
    protected function getPhpModules(): array
    {
        return get_loaded_extensions();
    }

    /**
     * Get Geolocation from IP.
     */
    protected function getGeolocation(): array
    {
        $geoLocation = ['latitude' => null, 'longitude' => null, 'address' => null];

        try {
            if (PHP_OS == 'Linux') {
                // Get the external IP address
                $ip = trim(shell_exec("curl -s ifconfig.me"));

                // Try using ip-api.com
                $json = shell_exec("curl -s http://ip-api.com/json/{$ip}");
                $data = json_decode($json, true);

                if ($data && $data['status'] === 'success') {
                    $geoLocation['latitude'] = $data['lat'];
                    $geoLocation['longitude'] = $data['lon'];
                    $geoLocation['address'] = "{$data['city']}, {$data['regionName']}, {$data['country']}";
                }
            } elseif (PHP_OS == 'Darwin') {
                // Get the external IP address
                $ip = trim(shell_exec("curl -s ifconfig.me"));

                // Try using ip-api.com
                $json = shell_exec("curl -s http://ip-api.com/json/{$ip}");
                $data = json_decode($json, true);

                if ($data && $data['status'] === 'success') {
                    $geoLocation['latitude'] = $data['lat'];
                    $geoLocation['longitude'] = $data['lon'];
                    $geoLocation['address'] = "{$data['city']}, {$data['regionName']}, {$data['country']}";
                }
            } elseif (PHP_OS == 'WINNT') {
                // Get the external IP address
                $ip = trim(shell_exec("curl -s ifconfig.me"));

                // Try using ip-api.com
                $json = shell_exec("curl -s http://ip-api.com/json/{$ip}");
                $data = json_decode($json, true);

                if ($data && $data['status'] === 'success') {
                    $geoLocation['latitude'] = $data['lat'];
                    $geoLocation['longitude'] = $data['lon'];
                    $geoLocation['address'] = "{$data['city']}, {$data['regionName']}, {$data['country']}";
                }
            }
        } catch (\Exception $e) {
        }

        return $geoLocation;
    }

}
