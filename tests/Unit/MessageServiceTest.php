<?php

namespace Tests\Unit;

use App\Http\Repositories\Contracts\IMessageRepository;
use App\Http\Services\Contracts\ICacheService;
use App\Http\Services\MessageService;
use App\Support\Enum\MessageStatus;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\TestCase;

class MessageServiceTest extends TestCase
{
    private MessageService $messageService;
    private IMessageRepository $mockMessageRepository;
    private ICacheService $mockCacheService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockMessageRepository = Mockery::mock(IMessageRepository::class);
        $this->mockCacheService = Mockery::mock(ICacheService::class);
        $this->messageService = new MessageService(
            $this->mockMessageRepository,
            $this->mockCacheService
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }


    public function test_it_returns_true_when_message_status_is_not_pending()
    {
        // Arrange
        $user = $this->createMockUser('+1234567890');
        $message = $this->createMockMessage('test-uuid', 'Test message', MessageStatus::Sent, $user);

        // Mock static facades
        Log::shouldReceive('info')
            ->once()
            ->with('Message already sent to +1234567890');
        
            $result = $this->messageService->sendMessage($message);

        // Assert
        $this->assertTrue($result);
    }


}