<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
