@extends('layouts.app')


@section('styles')
  <style>
      #outer{
        width: auto;
        text-align:cnter;;
      }
      .inner{
        display:inline-block;
      }

   </style>

@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card {{$theme=='dark' ? 'bg-dark text-white' : 'bg-light'}}">
                <div class="card-header {{$theme=='dark' ? 'bg-secondary text-white' : 'bg-light text-dark'}}">{{ __('Dashboard') }}</div>

                <div class="card-body">

                 @if(Session::has('success'))
                   <div class="alert alert-success {{$theme=='dark' ? 'text-dark' : ''}}" role="alert">
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
                 

                 <a class="btn btn-sm  btn-info mb-2" href="{{route('todos.create')}}">Create Todo</a>

                       @if(count($todos)>0)
                          <table class="table {{$theme=='dark' ? 'table-dark' : 'table-striped'}}">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">description</th>
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
                                        @if($todo->is_completed==1)
                                            <a class="btn btn-sm text-black bg-success" href="" >Completed</a>
                                        @else
                                            <a class="btn btn-sm text-black bg-warning" href="" >Pending</a>
                                        @endif
                                    </td>
                                    <td id="outer">
                                     
                                       <a class=" inner btn btn-sm bg-success text-white" href="{{route('todos.show', $todo->id)}}" >View</a>
                                        <a class="inner btn btn-sm bg-info text-black" href="{{route('todos.edit',$todo->id)}}" >Edit</a>
                                        <form method="post" action="{{route('todos.destroy')}}" class="inner">
                                            @csrf
                                            @method('DELETE')
                                             <input type="hidden" name="todo_id" value="{{$todo->id}}" >
                                             <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                                        </form>
                                    </td>

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
