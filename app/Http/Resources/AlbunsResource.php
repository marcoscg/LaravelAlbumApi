<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CategoriaResource;
use App\Repositories\CategoriaRepository;

class AlbunsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'album' => $this->collection->transform(function($page){
                return [
                    'id' => $page->getId(),
                    'artista' => $page->getArtista(),
                    'titulo' => $page->getTitulo(),
                    'capa' => $page->getCapa(),
                    'categoria' => new CategoriaResource($page->getCategoria()),
                ];
            }),
        ];
    }
}
