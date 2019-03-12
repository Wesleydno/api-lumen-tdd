<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class UserTest extends TestCase
{
use DatabaseTransactions;

    public function testCreateUser()
    {
        $dados = [
            'name'     => 'Fulano',
            'email'    => 'Fulanodetal2@email.com',
            'password' => '123456'
        ];

        $this->post('/api/user', $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);



    }

    public function testShowUser()
    {
        $user = \App\User::first();
        $this->get('/api/user/'.$user->id);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

    }
}
