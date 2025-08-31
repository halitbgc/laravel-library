<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'author'         => $this->author->name,
            'author_id'      => $this->author_id,
            'genre_id'       => $this->genre_id,
            'genre'          => $this->genre->name,
            'description'    => $this->description,
            'published_year' => $this->published_year,
            'pages'          => $this->pages,
            'created_at'     => $this->created_at?->toISOString(),
            'updated_at'     => $this->updated_at?->toISOString(),
        ];
    }
}
