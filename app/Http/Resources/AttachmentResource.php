<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->filename,
            'size' => $this->formatSize($this->byte_size),
            'url' => URL::signedRoute('attachments.show', $this->id),
        ];
    }

    private function formatSize($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
