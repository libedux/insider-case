<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
   
    /**
     * @OA\Schema(
     *   schema="MessageResource",
     *   type="object",
     *   title="Message Resource",
     *   @OA\Property(property="uuid", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
     *   @OA\Property(property="status", type="string", example="Sent"),
     *   @OA\Property(property="content", type="string", example="Hello, world!"),
     *   @OA\Property(property="user", type="object",
     *       @OA\Property(property="id", type="integer", example=1),
     *       @OA\Property(property="phone_number", type="string", example="+123456789")
     *   )
     * )
 */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
