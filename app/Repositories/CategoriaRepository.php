<?php

namespace App\Repositories;

use App\Entities\Categoria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class CategoriaRepository extends EntityRepository
{
    use Paginatable;
    
    private $em;    
    
    /**
    * ScientistRepository constructor.
    * @param EntityManagerInterface $em
    */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        
        parent::__construct($em, $em->getClassMetadata(Categoria::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 5, $pageName = 'page')
    {
        $builder = $this->createQueryBuilder('u');     
        if ($field) {
            if ($field == 'id') $builder->where('u.id = :cond')->setParameter('cond', $cond);
            if ($field == 'descricao') $builder->where('u.descricao like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('u.id');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Categoria $categoria
    * @return Categoria
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Categoria $categoria)
    {
        $this->getEntityManager()->persist($categoria);
        $this->getEntityManager()->flush();

        return $categoria;
    }

    /**
    * @param Categoria $categoria
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Categoria $categoria)
    {
        $this->getEntityManager()->remove($categoria);
        $this->getEntityManager()->flush();

    }   
    
	public function qtAlbum($id) {
	
        $sql = 'SELECT COUNT(*) as qt FROM album WHERE categoria_id = ' . $id;
        
        $statement = $this->em->getConnection()->prepare($sql);
        $statement->execute();  
        $row = $statement->fetch();
        
    	return $row['qt'];
	}    

}