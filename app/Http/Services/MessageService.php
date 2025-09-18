<?php

namespace App\Http\Services;

use App\Http\Repositories\Contracts\IMessageRepository;
use App\Http\Services\Contracts\ICacheService;
use App\Http\Services\Contracts\IMessageService;
use App\Models\Message;
use App\Support\Constants\CacheConstant;
use App\Support\Enum\MessageStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class MessageService implements IMessageService
{
    public function __construct(protected IMessageRepository $messageRepository, protected ICacheService $cacheService) {}

	public function sendMessage(Message $message): bool
	{
		try {
            if($message->status !== MessageStatus::Pending) {
                Log::info('Message already sent to ' . $message->user?->phone_number);
                return true;
            }

            $url = config('services.sms.base_url') . '/' . config('services.sms.token');
            $response = Http::post($url, [
                'to' => $message->user?->phone_number,
                'content' => $message->content,
            ]);


            if ($response->successful()) {
                Log::info('Message sent successfully to ' . $message->user?->phone_number);
                $this->messageRepository->update([
                    'uuid' => $message->uuid,
                    'status' => MessageStatus::Sent
                ]);

                $this->cacheService->add(CacheConstant::SENT_MESSAGES_CACHE_KEY, $response->body(), 300); 
                return true;
            } else {
                Log::error('Failed to send message. Response: ' . $response->body());
                $this->messageRepository->update([
                    'uuid' => $message->uuid,
                    'status' => MessageStatus::Failed
                ]);
                return false;
            }
            
        } catch (\Throwable $th) {
            Log::error('Failed to send message: ' . $th->getMessage());
            return false;
        }
	}
}
