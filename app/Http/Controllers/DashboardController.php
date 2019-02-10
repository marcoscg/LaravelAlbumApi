<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class DashboardController extends Controller
{

    private $em;

    /**
     * 
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;    
    }

    /**
     * 
     */
    protected function dashboard(Request $request)
    {      
        return response()->json([
        'qt_categoria' => $this->qtRegistro('categoria'),
        'qt_album' => $this->qtRegistro('album'),
      ]);

    } 

    /**
     * 
     * @param unknown $tableGatewayService
     * @return unknown
     */
    public function qtRegistro($tipo) {
    	 
    	if ($tipo == 'categoria') {
    		$sql = 'SELECT COUNT(*) as qt FROM categoria ';
    	} elseif ($tipo == 'album') {
    		$sql = 'SELECT COUNT(*) as qt FROM album ';
        }

        $statement = $this->em->getConnection()->prepare($sql);
        $statement->execute();  
        $row = $statement->fetch();
        
    	return $row['qt'];
    }

}
