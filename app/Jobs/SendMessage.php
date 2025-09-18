<?php

namespace App\Jobs;

use App\Http\Services\Contracts\IMessageService;
use App\Http\Services\MessageService;
use App\Models\Message;
use App\Support\Enum\MessageStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Message $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(IMessageService $messageService): void
    {
        $result = $messageService->sendMessage($this->message);

        $this->updateMessageStatus($result);
    }


    private function updateMessageStatus(bool $result): void
    {
        $status = $result ? MessageStatus::Sent : MessageStatus::Failed;

        Message::where('id', $this->message->id)
            ->update(['status' => $status]);
    }
}
