
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Todos app</div>

                <div class="card-body">
                
                        <h3>Edit from</h3>
                       
                        <form action="{{ route('todos.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="todo_id" value="{{$todo->id}}">
                         <div class="form-group">
                                    <label class="col-sm-2 col-form-label">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$todo->title}}" placeholder="Enter title">
                         </div>
                         <div class="form-group">
                                    <label class="col-sm-2 col-form-label">description</label>
                                    <textarea name="description" rows="4" class="form-control" placeholder="Enter description">
                                        {{$todo->description}}
                                    </textarea>
                         </div>
                         <div class="mb-3">
                             <lable for="">Status</lable>
                             <select name="is_completed" class="form-control">
                                <option disabled selected>Select Option</option>
                                <option value="1">Completed</option>
                                <option value="0">Pending</option>
                             </select>
                         </div>
        
                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                         </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
