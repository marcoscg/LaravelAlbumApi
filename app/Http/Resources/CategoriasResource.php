<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Repositories\CategoriaRepository;

class CategoriasResource extends ResourceCollection
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
            'categoria' => $this->collection->transform(function($page){
                return [
                    'id' => $page->getId(),
                    'descricao' => $page->getDescricao(),
                    'qt_album' => $this->qtAlbum($page->getId()),
                ];
            }),
        ];
    }

    /**
     * 
     */
    public function qtAlbum($id) 
    {        
        $repository = new CategoriaRepository(app('Doctrine\ORM\EntityManagerInterface'));

        return $repository->qtAlbum($id);
	}     
}
