<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $artista;

    /**
     * @ORM\Column(type="string")
     */
    protected $titulo;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $capa;
    
    /**
     * @ORM\Column(name="categoria_id", type="integer")
     */
    protected $categoriaId;  
    
    /**
     * @ManyToOne(targetEntity="Categoria")
     * @JoinColumn(name="categoria_id", referencedColumnName="id")
     */     
    protected $categoria;     

    /**
    * @param $artista
    */
    public function __construct($artista, $titulo, $capa, $categoriaId)
    {
        $this->artista = $artista;
        $this->titulo = $titulo;
        $this->capa = $capa;
        $this->categoriaId = $categoriaId;
    }

    /**
     * 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of artista
     */ 
    public function getArtista()
    {
        return $this->artista;
    }

    /**
     * Set the value of artista
     *
     * @return  self
     */ 
    public function setArtista($artista)
    {
        $this->artista = $artista;

        return $this;
    }

    /**
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of capa
     */ 
    public function getCapa()
    {
        return $this->capa;
    }

    /**
     * Set the value of capa
     *
     * @return  self
     */ 
    public function setCapa($capa)
    {
        $this->capa = $capa;

        return $this;
    }

    /**
     * Get the value of categoriaId
     */ 
    public function getCategoriaId()
    {
        return $this->categoriaId;
    }

    /**
     * Set the value of categoriaId
     *
     * @return  self
     */ 
    public function setCategoriaId($categoriaId)
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }

    /**
     * Get the value of categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }
}