<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(){
      $todos = Todo::where('user_id', auth()->id())->get();
      return view('todos.index', compact('todos'));
    }
     public function create(){
        return view('todos.create');
    }

    // JSON list for AJAX
    public function list(){
        $todos = Todo::where('user_id', auth()->id())->get();
        return response()->json($todos);
    }


    //  public function store(TodoRequest $request){
        
    //     $todo= Todo::create([
    //         'title' => $request->title,
    //         'description' => $request->description,
    //         'is_completed' => 0, 
    //         'user_id' => auth()->id(),
    //     ]);
    //     if($request->ajax()){
    //         return response()->json([
    //             'success'=>true,
    //             'message'=>'Todo created successfully!',
    //             'data'=> $todo
    //         ]);
    //     }
    //     $request->session()->flash('success', 'Todo created successfully!');
    //     return redirect()->route('todos.index');
    // }
    
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $todo = Todo::create([
        'title' => $request->title,
        'description' => $request->description,
        'is_completed' => false,
        'user_id' => auth()->id(),
    ]);

    return response()->json([
        'message' => 'Todo created successfully',
        'todo' => $todo
    ], 201);
}



    
    public function show($id)
    {
        $todo = Todo::where('id', $id)  
        ->where('user_id', auth()->id())
        ->first();

        if(!$todo){
           return response()->json(['success'=>false,'message'=>'Todo not found'],404);
      
        }
         return response()->json($todo);
    }
    public function edit($id)
    {
         $todo = Todo::where('id', $id)   
        ->where('user_id', auth()->id())
        ->first();

        if(!$todo){
            request()->session()->flash('error', 'Unable to locate the todo');
            return to_route('todos.index')->withErrors([
                'error'=>'Unable to locate the todo'
            ]);
        }
        return view('todos.edit',['todo'=>$todo]);
   
    }
    public function update(TodoRequest $request , $id){
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        if(!$todo){
            return response()->json(['success'=>false,'message'=>'Todo not found'],404);
        }

        $todo->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'is_completed' => $request->is_completed ?? 0,
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Todo updated successfully!',
            'data'=>$todo
        ]);

    }

    public function destroy($id){
       $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();
       if(!$todo){
            return response()->json(['success'=>false,'message'=>'Todo not found'],404);
        }
       $todo->delete();
        return response()->json(['success'=>true,'message'=>'Todo deleted successfully!']);
     }

    public function toggle(Request $request, Todo $todo)
     {
        $request->validate([
            'is_completed' => 'required|boolean',
        ]);

        $todo->update([
            'is_completed' => $request->is_completed,
        ]);

        return response()->json(['message' => 'Todo status updated successfully']);
     }

    


}
