<?php

namespace App\Http\Repositories\Contracts;

use App\Models\Message;

interface IMessageRepository
{
    public function update(array $data): bool;

    public function getMessagesByStatus(string $status): array;
}
