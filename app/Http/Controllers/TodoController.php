<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class TodoController extends Controller
{
   public function postTodo(Request $request){

      $this->validate($request,[
         'title' => 'required|min:7',
         'description' => 'required|min:10'
      ]);

      $data = $request->all();

      $model = Todo::create($data);


      return response()->json(['message' => 'resposta'],201);
   }

  public function getTodo(int $todo){
      
      $todo = Todo::find($todo);

      if(!$todo){
         return response()->json(['message' => 'usuário não encontrado'],404);
      }

      return response()->json($todo);

   }

   public function deleteTodo(Request $request, $id){

      $request->merge(['todo_id' => $id]);

      $this->validate($request,[
            'todo_id' => 'required|exists:todos,id'
      ]);

      Todo::find($id)->delete();

   
      return response()->json(['message' => 'usário deletado com sucesso'], 204);
   }

  public function updateTodo(Request $request, $id){

         $request->merge(['todo_id' => $id]);

         $this->validate($request,[
            'todo_id' => 'required|exists:todos,id'
          ]);

         $todo = Todo::find($id);


         $todo->update($request->all());

         return response()->json(['message' => 'Tarefa atualizado com sucesso']);

   }

   public function postTodoStatus(Request $request, int $id, string $status){
      
      if(!$this->validateAvaliableStatus($status)){
         return response()->json(['message' => 'avaliable status: done, undone'],422);
      }

      $todo = Todo::find($id);

      if(!$todo){
         return response()->json(['message' => 'not found'], 404);
      }

      $todo->done();

      return response()->json($todo);

   }

   private function validateAvaliableStatus(string $status){
      return in_array($status, ['done','undone']);
   }

}
