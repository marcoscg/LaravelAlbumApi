<?php

namespace App\Repositories;

use App\Entities\Album;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class AlbumRepository extends EntityRepository
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
        
        parent::__construct($em, $em->getClassMetadata(Album::class));
    }

    /**
     * 
     */
    public function all($field = '', $cond = '', $perPage = 10, $pageName = 'page')
    {        
        $builder = $this->createQueryBuilder('a');
        $builder->select(['a', 'c'])->Join('a.categoria', 'c');
        if ($field) {
            if ($field == 'id') $builder->where('a.id = :cond')->setParameter('cond', $cond);
            if ($field == 'artista') $builder->where('a.artista like :cond')->setParameter('cond', $cond . '%');
        }
        $builder->orderBy('a.artista');
    
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }    

    /**
    * @param Album $Album
    * @return Album
    * @throws \Doctrine\ORM\ORMException
    */
    public function persist(Album $album)
    {
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush();

        return $album;
    }

    /**
    * @param Album $Album
    * @throws \Doctrine\ORM\ORMException
    */
    public function remove(Album $album)
    {
        $this->getEntityManager()->remove($album);
        $this->getEntityManager()->flush();

    } 

}