<?php

namespace App\Http\Services;

use App\Http\Services\Contracts\ICacheService;
use Illuminate\Support\Facades\Cache;


class RedisCacheService implements ICacheService
{
    public function get(string $key): array|null
    {
        return Cache::get($key);
    }

    public function put(string $key, mixed $value, int $ttl): bool
    {
        return Cache::put($key, $value, $ttl);
    }

    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    public function add(string $key, mixed $value, int $ttl): bool
    {
        $data = $this->get($key);
        if (!empty($data)) {
            $value = array_merge($data, $value);
        }

        return $this->put($key, $value, $ttl);
    }
}