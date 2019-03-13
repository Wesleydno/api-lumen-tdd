<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class UserTest extends TestCase
{
use DatabaseTransactions;

    public function testCreateUser()
    {
        $dados = [
            'name'     => 'Fulano '.date('ymdis').'-'. rand(1,100),
            'email'    => 'Fulano@email.com',
            'password' => '123456'
        ];
        $this->post('/api/user', $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        $this->seeInDatabase('users',[
            'name'  =>  $dados['name'],
            'email' =>  $dados['email']
        ]);



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

    public function testUpdateUser()
    {
        $user = \App\User::first();
        $dados = [
            'name'     => 'Ciclano '.date('ymdis').'_'. rand(1,100),
            'email'    => 'Ciclano'.date('ymdis').'_'. rand(1,100).'@email.com',
            'password' => '123456'
        ];

        $this->put('/api/user/'.$user->id, $dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        $this->notSeeInDatabase('users',[
            'name'  =>  $user->name,
            'email' =>  $user->email,
            'id'    =>  $user->id
        ]);



    }
}
