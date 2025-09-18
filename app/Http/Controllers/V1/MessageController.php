<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Services\Contracts\ICacheService;
use App\Http\Services\Contracts\IMessageService;
use App\Models\Message;
use App\Support\Constants\CacheConstant;

class MessageController extends Controller
{
    public function __construct(protected IMessageService $messageService, protected ICacheService $cacheService)
    {

    }

    /**
     * @OA\Get(
     *      path="/messages",
     *      operationId="getMessagesList",
     *      tags={"Messages"},
     *      summary="Get list of messages",
     *      description="Returns list of messages",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/MessageResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $this->messageService->sendMessage(Message::first());
        return response()->json([
            'data' => MessageResource::collection(Message::paginate(20)),
        ]);
    }


}
