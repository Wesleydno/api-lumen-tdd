<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{


    public function testCreateUser()
    {
        $dados = [
            'name'     => 'Fulano',
            'email'    => 'Fulanodetal@email.com',
            'password' => '123456'
        ];

        $this->post('/api/user', $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());

        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);



    }
}
