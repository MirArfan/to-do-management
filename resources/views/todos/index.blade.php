@extends('layouts.app')

@section('styles')
  <style>
      #outer {
        width: auto;
        text-align: center;
      }
      .inner {
        display: inline-block;
      }
   </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                 @if(Session::has('success'))
                   <div class="alert alert-success" role="alert">
                     {{ Session::get('success') }}
                    </div>
                 @endif

                 @if(Session::has('info'))
                   <div class="alert alert-info" role="alert">
                     {{ Session::get('info') }}
                    </div>
                 @endif
                 
                  @if(Session::has('error'))
                   <div class="alert alert-danger" role="alert">
                     {{ Session::get('error') }}
                    </div>
                 @endif
                 
                 <a class="btn btn-sm btn-info text-white" href="{{ route('todos.create') }}">Create Todo</a>

                 @if(count($todos) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todos as $todo)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $todo->title }}</td>
                                <td>{{ $todo->description }}</td>
                                <td>
                                    @if($todo->is_completed == 1)
                                        <a class="btn btn-sm bg-success text-white">Completed</a>
                                    @else
                                        <a class="btn btn-sm bg-warning text-white">Pending</a>
                                    @endif
                                </td>
                                <td id="outer">
                                    <a class="inner btn btn-sm bg-success text-white" href="{{ route('todos.show', $todo->id) }}">View</a>
                                    <a class="inner btn btn-sm bg-info text-white" href="{{ route('todos.edit', $todo->id) }}">Edit</a>

                                    
                                    {!! Form::open(['route' => ['todos.destroy', $todo->id], 'method' => 'DELETE', 'class' => 'inner']) !!}
                                        {!! Form::hidden('todo_id', $todo->id) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 @else
                    <h3>No todos created yet</h3>
                 @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
