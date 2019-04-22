<?php
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
  
//use DatabaseTransactions;

    public $dados = [];
    public $api_token = [];

    public function __construct($name = null, array $data = [], $dataName = ''){
        parent::__construct($name, $data, $dataName);

        $faker = Faker\Factory::create();
        $this->dados = [
            'name'     => $faker->name,
            'email'    => $faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        
       $this->api_token = ['api_token' => DB::table('users')->where('api_token','<>','')->first()->api_token];
    }

  
    public function testCreateUser()
    {

        $this->post('/api/user', $this->dados,$this->api_token);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

        $this->seeInDatabase('users',[
            'name'  =>  $this->dados['name'],
            'email' =>  $this->dados['email']
        ]);

    }


    public function testShowUser()
    {
        $user = User::first();
        $this->get('/api/user/'.$user->id, $this->api_token);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('name', $resposta);
        $this->assertArrayHasKey('email', $resposta);
        $this->assertArrayHasKey('id', $resposta);

    }

    public function testLogin(){
        $this->post('/api/user', $this->dados, $this->api_token);
        $this->assertResponseOk();

        $this->post('/api/login', $this->dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHaskey('api_token', $resposta);

    }

    public function testShowAllUser()
    {
        $this->get('/api/users/',$this->api_token);
        $this->assertResponseOk();
        $this->seeJsonStructure([
            '*' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }

    public function testUpdateUserWithPassword()
    {
        $user = User::first();
        $this->put('/api/user/'.$user->id, $this->dados, $this->api_token);
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


  
    public function testDeleteUser()
    {
      $user = User::first();
      $this->delete('/api/user/'.$user->id, $this->api_token);
      $this->assertResponseOk();
      $this->assertEquals("Removido com sucessoo!", $this->response->content());

    }

   
}
