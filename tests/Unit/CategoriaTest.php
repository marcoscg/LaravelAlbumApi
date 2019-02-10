<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriaTest extends TestCase
{
    /**
     * 
     */
    public function testGetAll()
    {
        $response = $this->json('GET', 'api/categoria');

        $response->assertStatus(200);
    }
    
    /**
     * 
     */
    public function testGet()
    {
        $response = $this->json('GET', 'api/categoria/1');

        $response->assertStatus(200);
    }  
    
    /**
     * 
     */
    public function testGetNotExist()
    {
        $response = $this->json('GET', 'api/categoria/10000');

        $response->assertStatus(404);
    }     

    /**
     * 
     */
    public function testPost()
    {
        $response = $this->json('POST', 'api/categoria', ['descricao' => 'Sally']);

        $response->assertStatus(201);
    }    
    
    /**
     * 
     */
    public function testPut()
    {
        $response = $this->json('PUT', 'api/categoria/40', ['descricao' => 'Sally...']);

        $response->assertStatus(200);
    }     

    /**
     * 
     */
    public function testDelete()
    {
        $response = $this->json('DELETE', 'api/categoria/41');

        $response->assertStatus(404);
    } 
}
