<?php

namespace App\Support\Enum;

enum MessageStatus: string
{
    case Pending = 'pending';
    case Sent = 'sent';
    case Failed = 'failed';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Sent => 'Sent',
            self::Failed => 'Failed',
        };
    }
}
