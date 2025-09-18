<?php

namespace App\Http\Controllers;

use App\Http\Services\Contracts\ICacheService;
use App\Http\Services\Contracts\IMessageService;
use App\Http\Services\MessageService;
use App\Models\Message;
use App\Support\Constants\CacheConstant;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(protected IMessageService $messageService, protected ICacheService $cacheService)
    {

    }

    public function index()
    {
        $this->messageService->sendMessage(Message::first());
        $cacheData = $this->cacheService->get(CacheConstant::SENT_MESSAGES_CACHE_KEY);
        
        if (!empty($cacheData)) {
            return response()->json([
                'data' => $cacheData,
            ]);
        }

        return response()->json([
            'source' => 'database',
            'data' => Message::all()->toArray(), 
        ]);
    }


}
