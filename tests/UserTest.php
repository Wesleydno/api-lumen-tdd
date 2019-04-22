<?php
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
  
use DatabaseTransactions;    //Caso Desabilitada os dados serão persistidos no banco de dados

    public $dados = [];
    public $api_token = [];

    public function __construct($name = null, array $data = [], $dataName = ''){
        parent::__construct($name, $data, $dataName);
        //Carrego em memória  os dados para utilizar nos testes abaixo
        $faker = Faker\Factory::create();
        $this->dados = [
            'name'     => $faker->name,
            'email'    => $faker->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        // Pego um token existente no banco, para que seja possível acessar os métodos que necessitam de auteticação
       $this->api_token = ['api_token' => DB::table('users')->where('api_token','<>','')->first()->api_token];
    }

  
    public function testCreateUser()
    {
        // Crio um novo usuário 
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

    //Busca um usuário pelo id
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
        //Cria um novo usuário passando o token no header 
        $this->post('/api/user', $this->dados, $this->api_token);
        $this->assertResponseOk();
        //Utiliza o usuário criado acima para fazer login
        $this->post('/api/login', $this->dados);
        $this->assertResponseOk();

        $resposta = (array) json_decode($this->response->content());
        $this->assertArrayHaskey('api_token', $resposta);

    }

     //Busca todos os usuários passando o token no header. E também valida a estrutura do json retornado 
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

    //Atualiza usuário informando todos os campos e passando o token no header 
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

     //Atualiza usuário informando apenas nome e email ( menos a senha) e passando o token no header 
    public function testUpdateUserWithoutPassword()
    {
        $faker = Faker\Factory::create();
        $dados = [
            'name'     => $faker->name,
            'email'    => $faker->email,
        ];

        $user = User::first();
        $this->put('/api/user/'.$user->id, $dados, $this->api_token);
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



    //Deleta usuário pasando id e token
    public function testDeleteUser()
    {
      $user = User::first();
      $this->delete('/api/user/'.$user->id, $this->api_token);
      $this->assertResponseOk();
      $this->assertEquals("Removido com sucessoo!", $this->response->content());

    }

   
}
