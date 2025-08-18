
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Todos app</div>

                <div class="card-body">
                

                <h3>Create Post</h3>
 
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                       
                        <form method="POST" action="{{ route('todos.store') }}">
                        @csrf
                         <div class="form-group">
                                    <label class="col-sm-2 col-form-label">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter title">
                         </div>
                         <div class="form-group">
                                    <label class="col-sm-2 col-form-label">description</label>
                                    <textarea name="description" rows="4" class="form-control" placeholder="Enter description"></textarea>
                         </div>
        
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                         </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
