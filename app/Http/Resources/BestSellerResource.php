<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BestSellerResource extends JsonResource
{
    public function toArray($request): array
    {
        // Since the NYT api doesnt have this
        $offset = $this->resource['offset'] ?? 0;
        
        return [
            'author' => $this['author'],
            'isbn' => $this['isbns'],
            'title' => $this['title'],
            //offset is not specified in the NYT api documentation
            'offset' => $offset,
        ];
    }
}
