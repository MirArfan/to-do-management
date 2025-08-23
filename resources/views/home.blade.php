@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card {{$theme=='dark' ? 'bg-dark text-white' : 'bg-light'}}">
                <div class="card-header {{$theme=='dark' ? 'bg-secondary text-white' : 'bg-light text-dark'}}">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <div class="mt-4">
                        <a href="{{ route('todos.index') }}" class="btn btn-primary">
                            Go to To-Do List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
