<?php

namespace App\Console\Commands;

use App\Jobs\SendMessage;
use App\Models\Message;
use App\Support\Enum\MessageStatus;
use Illuminate\Console\Command;

class ProcessMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Messages from the queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing messages...');

        Message::where('status', MessageStatus::Pending)
            ->limit(2)
            ->each(function ($message) {
                $this->info("Dispatching message ID: {$message->id}");
                SendMessage::dispatch($message);
            });

        $this->info('Messages processed successfully.');
    }
}
