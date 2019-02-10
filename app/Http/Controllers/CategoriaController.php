<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;

use App\Entities\Categoria;
use App\Repositories\CategoriaRepository;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\CategoriasResource;
use App\Http\Requests\CategoriaRequest As Request;

/**
* @swg\Info(title="Project API", version="1")
*/

class CategoriaController extends Controller
{

    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('auth:api');        
        $this->repository = new CategoriaRepository($em);    
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
        if (isset($_GET['vdescricao'])) {
            $field = 'descricao'; $cond = $_GET['vdescricao'];
        }
        
        $categoria = $this->repository->all($field, $cond);

        return new CategoriasResource($categoria);
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

        $categoria = new Categoria($data['descricao']);

        $categoria = $this->repository->persist($categoria);

        $categoria = new CategoriaResource($categoria);

        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = $this->repository->find($id);   
        
        if (!$categoria)
            return response()->json(['message' => 'Categoria não existe!'], 404);

        return new CategoriaResource($categoria);
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
        $categoria = $this->repository->find($id);   
        
        if (!$categoria)
            return response()->json(['message' => 'Categoria não existe!'], 404);

        $categoria->setDescricao($data['descricao']);

        $categoria = $this->repository->persist($categoria); 
        
        return new CategoriaResource($categoria);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = $this->repository->find($id);   
        
        if (!$categoria)
            return response()->json(['message' => 'Categoria não existe!'], 404);

        $this->repository->remove($categoria); 
        
        return response()->json(['message' => 'Sucess!'], 200);
    }

}
