<?php

namespace App\Services;

use App\Models\Configuration;
use Illuminate\Support\Facades\Cache;


class ConfigService
{
    protected array $config = [];

    public function __construct()
    {
        //Cache -- rendimiento
        $this->config = Cache::remember('configuration_cache', 60, function () {
            return Configuration::pluck('valor', 'clave')->toArray();
        });
    }

    public function get(string $clave, $default = null): mixed
    {
        return $this->config[$clave] ?? $default;
    }

    public function all(): array
    {
        return $this->config;
    }

    public function clearCache(): void
    {
        Cache::forget('configuration_cache');
    }
}
