<?php

namespace App\Http\Services\Contracts;

use App\Models\Message;

interface IMessageService
{
    public function sendMessage(Message $message): bool;

}
