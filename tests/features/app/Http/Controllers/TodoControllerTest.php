<?php

namespace feature\app\Http\Controllers;

use App\Models\Todo;
use Laravel\Lumen\Testing\TestCase;


class TodoControllerTest extends TestCase {
    
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    public function testUserCanCreateTodo(){
        //preparando teste
        $payload = [
            'title' => 'lavar a louça',
            'description' => 'lavar a louça depois de comer',
            'done' => false,
            'done_at' => null
        ];

        $response = $this->post('/todos', $payload);

        
    
        // depurar o resultado da requisição
        $response->assertResponseStatus(201);

        //testa para ver se foi para o banco de dados o update
        $response->seeInDatabase('todos',$payload);
    }

   public function testUserShouldSendTitleAndDescription(){
        
        $payload = [
            'coisa' => 'nenhuma'
        ];

        $this->post('/todos',$payload);

        $this->assertResponseStatus(422);

   }

   public function testCanRetriveATodo(){
        
        $todo = Todo::factory()->create();

        $url = '/todos/' .$todo->id;

        $response = $this->get($url);

        $response->assertResponseStatus(200);

        $response->seeJsonContains(['title' => $todo->title]);


   }


   public function testIfTheUserCanUpdateATodo(){

        $todo = Todo::factory()->create();

        $payload = [
            'title' => 'alterei o nome do titulo'
        ];

        $response = $this->put('/todos/' .$todo->id, $payload);


        $response->seeJsonContains(['message' => 'Tarefa atualizado com sucesso']);
        

   }

  public function testIfUserCanDeleteATodo(){
        
        $todo = Todo::factory()->create();

        $response = $this->delete('/todos/' .$todo->id);

        $response->assertResponseStatus(204);

        $this->notSeeInDatabase('todos', ['id' => $todo->id]);



   }

  public function testUserCanSetDone(){

        $todo = Todo::factory()->create();

        $response = $this->post('/todos/' .$todo->id. '/status/done');

        $response->assertResponseStatus(200);

        $this->seeInDatabase('todos',[
            'id' => $todo->id,
            'done' => true
        ]);

   }

   public function testCanSetTodoUndone(){

        $todo = Todo::factory()->create(['done' => true]);

        $response = $this->post('/todos/' .$todo->id. '/status/undone');

        $response->assertResponseStatus(200);

        $this->seeInDatabase('todos',[
            'id' => $todo->id,
            'done' => false
        ]);

   }

   public function testUserShouldRecive204WhenTodoNotFound(){

        $response = $this->get('/todos/1221');

        $response->assertResponseStatus(404);

   }

}