
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
                       
                        {{-- Laravel Collective Form --}}
                    {!! Form::open(['route' => 'todos.store']) !!}
                        <div class="form-group mb-3">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Enter title', 'required']) !!}
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Enter description']) !!}
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {!! Form::submit('Submit', ['class' => 'btn btn-primary mt-2']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
