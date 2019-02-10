<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Album;
use App\Repositories\AlbumRepository;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbunsResource;
use App\Http\Requests\AlbumRequest As Request;

class AlbumController extends Controller
{

    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->middleware('auth:api');        
        $this->repository = new AlbumRepository($em);    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field = ''; $cond = '';
        if (isset($_GET['vid'])) {
            $field = 'id'; $cond = $_GET['vid'];
        }
        if (isset($_GET['pesquisa'])) {
            $field = 'artista'; $cond = $_GET['pesquisa'];
        }
        
        $album = $this->repository->all($field, $cond);

        return new AlbunsResource($album);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->all(); 

        $album = new Album($data['artista'],$data['titulo'],$data['capa'],$data['categoria_id']);

        $album = $this->repository->persist($album);

        return new AlbumResource($album);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = $this->repository->find($id);   
        
        if (!$album)
            return response()->json(['message' => 'Album não existe!'], 404);

        return new AlbumResource($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $album = $this->repository->find($id);   
        
        if (!$album)
            return response()->json(['message' => 'Album não existe!'], 404);

        $album->setArtista($data['artista']);
        $album->setTitulo($data['titulo']);
        $album->setCapa($data['capa']);
        $album->setCategoriaId($data['categoria_id']);

        $album = $this->repository->persist($album); 
        
        return new AlbumResource($album);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = $this->repository->find($id);   
        
        if (!$album)
            return response()->json(['message' => 'Album não existe!'], 404);

        $this->repository->remove($album); 
        
        return response()->json(['message' => 'Sucess!'], 202);
    }

}
