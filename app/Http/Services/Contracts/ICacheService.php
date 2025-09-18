<?php

namespace App\Http\Services\Contracts;

use App\Models\Message;

interface ICacheService
{
    public function get(string $key): array|null;

    public function put(string $key, mixed $value, int $ttl): bool;

    public function forget(string $key): bool;

    public function add(string $key, mixed $value, int $ttl): bool;
}
