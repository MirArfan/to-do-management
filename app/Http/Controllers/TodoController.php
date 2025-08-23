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
     public function store(TodoRequest $request){
        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => 0, 
            'user_id' => auth()->id(),
        ]);

        $request->session()->flash('success', 'Todo created successfully!');
        return redirect()->route('todos.index');
    }
    public function show($id)
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
        return view('todos.show',['todo'=>$todo]);
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
    public function update(TodoRequest $request){
       $todo = Todo::where('id', $request->todo_id)
            ->where('user_id', auth()->id())
            ->first();
            
       if(!$todo){
            request()->session()->flash('error', 'Unable to locate the todo');
            return to_route('todos.index')->withErrors([
                'error'=>'Unable to locate the todo'
            ]);
        }
        $todo->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'is_completed'=>$request->is_completed
        ]);
       $request->session()->flash('info', 'Todo updated successfully!');
        return redirect()->route('todos.index');

    }

    public function destroy(Request $request){
       $todo = Todo::where('id', $request->todo_id)
            ->where('user_id', auth()->id())
            ->first();
       if(!$todo){
            request()->session()->flash('error', 'Unable to locate the todo');
            return to_route('todos.index')->withErrors([
                'error'=>'Unable to locate the todo'
            ]);
        }
        $todo->delete();
        $request->session()->flash('success', 'Todo deleted successfully!');
        return redirect()->route('todos.index');

    }
   

    


}
