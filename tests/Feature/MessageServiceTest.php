<?php

namespace Tests\Feature;

use App\Http\Services\Contracts\IMessageService;
use App\Http\Services\MessageService;
use App\Models\Message;
use App\Models\User;
use App\Support\Constants\CacheConstant;
use App\Support\Enum\MessageStatus;
use Cache;
use Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MessageServiceTest extends TestCase
{
   use RefreshDatabase, WithFaker;

    protected MessageService $messageService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->messageService = app(abstract: IMessageService::class);
        
        // Set up test configuration
        Config::set([
            'services.sms.base_url' => 'https://webhook.site',
            'services.sms.token' => '791c683d-8fa6-4bb8-adf3-0d5fbca45453',
        ]);

        // Clear cache before each test
        Cache::flush();
    }


 public function test_message_sent_updates_db_and_cache()
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'user_id' => $user->id, 
            'status' => MessageStatus::Pending,
        ]); 

        $responseData = [
            'message_id' => 'msg_12345',
            'status' => 'queued',
            'timestamp' => now()->toISOString()
        ];
         Http::fake([
            'https://webhook.site/791c683d-8fa6-4bb8-adf3-0d5fbca45453' => Http::response($responseData, 200)
        ]);

        $result = $this->messageService->sendMessage($message);
        
        $this->assertTrue($result);

        $this->assertDatabaseHas('messages', [
            'uuid' => $message->uuid,
            'status' => MessageStatus::Sent,
        ]);

        $this->assertNotNull(Cache::get(CacheConstant::SENT_MESSAGES_CACHE_KEY));

    }

    public function test_message_failed_status_when_provider_errors()
    {
     $user = User::factory()->create();
        $message = Message::factory()->create([
            'user_id' => $user->id, 
            'status' => MessageStatus::Pending,
        ]); 

        Http::fake([
            '*' => Http::response('Error', 500),
        ]);

        $responseData = [
            'message_id' => 'msg_12345',
            'status' => 'queued',
            'timestamp' => now()->toISOString()
        ];
         Http::fake([
            'https://webhook.site/791c683d-8fa6-4bb8-adf3-0d5fbca45453' => Http::response($responseData, 200)
        ]);

        $result = $this->messageService->sendMessage($message);
        
        $this->assertFalse($result);

        $this->assertDatabaseHas('messages', [
            'uuid' => $message->uuid,
            'status' => MessageStatus::Failed,
        ]);
    }

}
