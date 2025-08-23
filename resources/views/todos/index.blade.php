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
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                        <table class="table {{$theme=='dark' ? 'table-dark' : 'table-striped'}}" id="todos-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todos as $todo)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $todo->title }}</td>
                                    <td>{{ $todo->description }}</td>
                                    <td>
                                        @if($todo->is_completed)
                                            <span class="btn btn-sm text-black bg-success">Completed</span>
                                        @else
                                            <span class="btn btn-sm text-black bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#todos-table').DataTable({
        paging: true,       
        searching: true,   
        ordering: true,    
        info: true      
    });
});
</script>
@endpush