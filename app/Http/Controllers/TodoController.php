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

   function getTodo(int $todo){
      
      $todo = Todo::find($todo);

      if(!$todo){
         return response()->json(['message' => 'usuário não encontrado'],404);
      }

      return response()->json($todo);

   }

   function deleteTodo(Request $request, $id){

      $request->merge(['todo_id' => $id]);

      $this->validate($request,[
            'todo_id' => 'required|exists:todos,id'
      ]);

      Todo::find($id)->delete();

   
      return response()->json(['message' => 'usário deletado com sucesso'], 204);
   }

   function updateTodo(Request $request, $id){

         $request->merge(['todo_id' => $id]);
         $todo = Todo::find($id);

         if(!$todo){
            return response()->json(['message' => 'usuário não encontrado'],404);
         }

         $todo->update($request->all());

         return response()->json(['message' => 'Tarefa atualizado com sucesso']);

   }

}
