
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Todos app</div>

                <div class="card-body">
                
                        <h3>Edit from</h3>
                       
                        {{-- Laravel Collective Form --}}
                    {!! Form::model($todo, ['route' => ['todos.update', $todo->id], 'method' => 'PUT']) !!}

                        <div class="form-group mb-3">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', old('title', $todo->title), ['class' => 'form-control', 'placeholder' => 'Enter title', 'required']) !!}
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', old('description', $todo->description), ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Enter description']) !!}
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            {!! Form::label('is_completed', 'Status') !!}
                            {!! Form::select('is_completed', [0 => 'Pending', 1 => 'Completed'], old('is_completed', $todo->is_completed), ['class' => 'form-control', 'required']) !!}
                        </div>

                        {!! Form::submit('Update', ['class' => 'btn btn-primary mt-2']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
