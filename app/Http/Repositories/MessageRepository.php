<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\IMessageRepository;
use App\Models\Message;


class MessageRepository implements IMessageRepository
{

    public function update(array $data): bool {
        return Message::where('uuid', $data['uuid'])->update([
            'status' => $data['status']
            ]);
    }


    public function getMessagesByStatus(string $status): array {
        return Message::where('status', $status)->get()->toArray();
    }
}
