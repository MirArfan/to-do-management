<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #outer {
            width: auto;
            text-align: center;
        }
        .inner {
            display: inline-block;
        }
        .completed {
            text-decoration: line-through;
            color: #6c757d;
        }
        .task-item:hover {
            background-color: #f8f9fa;
        }
        .task-actions {
            opacity: 0.5;
            transition: opacity 0.3s;
        }
        .task-item:hover .task-actions {
            opacity: 1;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn {
            border-radius: 5px;
        }
        .theme-dark {
            background-color: #343a40;
            color: #fff;
        }
        .theme-dark .card {
            background-color: #454d55;
            color: #fff;
        }
        .theme-dark .table {
            color: #fff;
        }
        .theme-dark .form-control {
            background-color: #454d55;
            color: #fff;
            border-color: #6c757d;
        }
    </style>
</head>
<body class="{{$theme=='dark' ? 'theme-dark' : ''}}">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card {{$theme=='dark' ? 'bg-dark text-white' : 'bg-light'}}">
                    <div class="card-header {{$theme=='dark' ? 'bg-secondary text-white' : 'bg-light text-dark'}} d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('Dashboard') }}</h4>
                       
                        <button class="btn btn-sm {{ $theme == 'dark' ? 'btn-light' : 'btn-primary' }}" 
                          data-bs-toggle="modal" data-bs-target="#createTodoModal">
                          <i class="fas fa-plus"></i> Create Todo
                        </button>

                    </div>
                    <div class="card-body">
                        @if(Session::has('success'))
                        <div class="alert alert-success {{$theme=='dark' ? 'bg-success text-white' : ''}}" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if(Session::has('info'))
                        <div class="alert alert-info {{$theme=='dark' ? 'bg-info text-dark' : ''}}" role="alert">
                            {{ Session::get('info') }}
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger {{$theme=='dark' ? 'bg-danger text-white' : ''}}" role="alert">
                            {{ Session::get('error') }}
                        </div>
                        @endif

                        @if(count($todos)>0)
                        <table class="table {{$theme=='dark' ? 'table-dark' : 'table-striped'}} table-hover" id="todos-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todos as $todo)
                                <tr id="todo-{{ $todo->id }}" class="{{ $todo->is_completed ? 'completed' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="todo-title">{{ $todo->title }}</td>
                                    <td class="todo-description">{{ $todo->description }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-todo-id="{{ $todo->id }}" {{ $todo->is_completed ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                @if($todo->is_completed)
                                                <span class="badge bg-success">Completed</span>
                                                @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info edit-todo" data-todo-id="{{ $todo->id }}" data-bs-toggle="modal" data-bs-target="#editTodoModal">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-todo" data-todo-id="{{ $todo->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-4x mb-3 text-muted"></i>
                            <h4>No todos created yet</h4>
                            <p class="text-muted">Get started by creating your first todo item</p>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#createTodoModal">
                                <i class="fas fa-plus"></i> Create Your First Todo
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Todo Modal -->
    <div class="modal fade" id="createTodoModal" tabindex="-1" aria-labelledby="createTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content {{$theme=='dark' ? 'bg-dark text-white' : ''}}">
                <div class="modal-header {{$theme=='dark' ? 'bg-secondary text-white' : ''}}">
                    <h5 class="modal-title" id="createTodoModalLabel">Create New Todo</h5>
                    <button type="button" class="btn-close {{$theme=='dark' ? 'btn-close-white' : ''}}" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               {!! Form::open(['id'=>'createTodoForm']) !!}
                <div class="modal-body">
                    {!! Form::token() !!}
                    <div class="mb-3">
                        {!! Form::label('title','Title',['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control '.$theme=='dark' ? 'bg-dark text-white' : '', 'required']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('description','Description',['class'=>'form-label']) !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control '.$theme=='dark' ? 'bg-dark text-white' : '', 'rows'=>3]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    {!! Form::submit('Create Todo', ['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Edit Todo Modal -->
    <div class="modal fade" id="editTodoModal" tabindex="-1" aria-labelledby="editTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content {{$theme=='dark' ? 'bg-dark text-white' : ''}}">
                <div class="modal-header {{$theme=='dark' ? 'bg-secondary text-white' : ''}}">
                    <h5 class="modal-title" id="editTodoModalLabel">Edit Todo</h5>
                    <button type="button" class="btn-close {{$theme=='dark' ? 'btn-close-white' : ''}}" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(['id'=>'editTodoForm']) !!}
                <div class="modal-body">
                    {!! Form::token() !!}
                    {!! Form::hidden('id', null, ['id'=>'edit_todo_id']) !!}
                    <div class="mb-3">
                        {!! Form::label('edit_title','Title',['class'=>'form-label']) !!} 
                        {!! Form::text('title', null, ['class'=>'form-control '.$theme=='dark' ? 'bg-dark text-white' : '', 'id'=>'edit_title','required']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('edit_description','Description',['class'=>'form-label']) !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control '.$theme=='dark' ? 'bg-dark text-white' : '', 'id'=>'edit_description','rows'=>3]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    {!! Form::submit('Update Todo', ['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // DataTable initialization
            $('#todos-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true
            });


// Create Todo with AJAX -
$('#createTodoForm').on('submit', function(e) {
    e.preventDefault();
    
    // Form data collection
    let formData = $(this).serialize();
    
    // Loading indicator
    let submitBtn = $('#createTodoModal').find('.btn-primary');
    let originalBtnText = submitBtn.html();
    submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...');
    submitBtn.prop('disabled', true);
    
    // ajax for create todo
    $.ajax({
        url: '{{ route("todos.store") }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            // Modal hide and form reset
            $('#createTodoModal').modal('hide');
            $('#createTodoForm')[0].reset();
            
            // Button reset
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
            
            // Success message
            showAlert(response.message || 'Todo created successfully', 'success');
            
            // Check if we need to initialize the table or add a new row
            if ($('#todos-table').hasClass('d-none') || $('#emptyState').is(':visible')) {
                // Hide empty state and show table
                $('#emptyState').addClass('d-none');
                $('#todos-table').removeClass('d-none');
                
                // Initialize DataTable if not already initialized
                if (!$.fn.DataTable.isDataTable('#todos-table')) {
                    $('#todos-table').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        responsive: true
                    });
                }
                
                // Reload the page to show the new data
                location.reload();
            } else {
                // Add new row to existing DataTable
                let table = $('#todos-table').DataTable();
                let todo = response.todo;
                
                let statusBadge = todo.is_completed ? 
                    '<span class="badge bg-success">Completed</span>' : 
                    '<span class="badge bg-warning text-dark">Pending</span>';
                
                let newRow = [
                    table.rows().count() + 1,
                    '<span class="todo-title">' + todo.title + '</span>',
                    '<span class="todo-description">' + (todo.description || '') + '</span>',
                    '<div class="form-check form-switch">' +
                        '<input class="form-check-input status-toggle" type="checkbox" data-todo-id="' + todo.id + '" ' + (todo.is_completed ? 'checked' : '') + '>' +
                        '<label class="form-check-label">' + statusBadge + '</label>' +
                    '</div>',
                    '<div class="btn-group" role="group">' +
                        '<button type="button" class="btn btn-sm btn-info edit-todo" data-todo-id="' + todo.id + '" data-bs-toggle="modal" data-bs-target="#editTodoModal">' +
                            '<i class="fas fa-edit"></i> Edit' +
                        '</button>' +
                        '<button type="button" class="btn btn-sm btn-danger delete-todo" data-todo-id="' + todo.id + '">' +
                            '<i class="fas fa-trash"></i> Delete' +
                        '</button>' +
                    '</div>'
                ];
                
                // Add row to DataTable and draw
                table.row.add(newRow).draw();
                
                // Add ID to the row for targeting
                $('#todos-table tbody tr:last').attr('id', 'todo-' + todo.id);
            }
        },
        error: function(xhr) {
            // Button reset
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
            
            // Error handling
            if(xhr.status === 422) {
                // Remove any existing error messages
                $('.alert-danger').remove();
                
                // Validation errors
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<div class="alert alert-danger mt-3"><ul>';
                
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                
                errorHtml += '</ul></div>';
                
                // Show errors in modal
                $('#createTodoModal .modal-body').prepend(errorHtml);
            } else {
                showAlert('Error creating todo: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
            }
        }
    });
});

// Show alert function
function showAlert(message, type = 'success') {
    // Remove any existing alerts
    $('.alert-dismissible').alert('close');
    
    let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    let themeClass = '{{$theme=="dark" ? "bg-success text-white" : ""}}';
    
    if (type === 'error') {
        themeClass = '{{$theme=="dark" ? "bg-danger text-white" : ""}}';
    }
    
    let alertHtml = '<div class="alert ' + alertClass + ' ' + themeClass + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
    '</div>';
    
    // Prepend alert to card body
    $('.card-body').prepend(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
}

    // Edit todo - load data into modal 
$(document).on('click', '.edit-todo', function() {
    var todoId = $(this).data('todo-id');
    var todoTitle = $('#todo-' + todoId + ' .todo-title').text();
    var todoDescription = $('#todo-' + todoId + ' .todo-description').text();
    
    $('#edit_todo_id').val(todoId);
    $('#edit_title').val(todoTitle);
    $('#edit_description').val(todoDescription);
});





// Update todo with AJAX 
$('#editTodoForm').on('submit', function(e) {
    e.preventDefault();
    var todoId = $('#edit_todo_id').val();
    
    // Loading indicator
    let submitBtn = $('#editTodoModal').find('.btn-primary');
    let originalBtnText = submitBtn.html();
    submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
    submitBtn.prop('disabled', true);
    
    $.ajax({
        url: '/todos/' + todoId,
        method: 'POST',
        data: $(this).serialize() + '&_method=PUT',
        success: function(response) {
            $('#editTodoModal').modal('hide');
            
            // Button reset
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
            
            // Show success message
            showAlert(response.message || 'Todo updated successfully', 'success');
            
            // Update the table row in DataTable if it exists
            if ($.fn.DataTable.isDataTable('#todos-table')) {
                let table = $('#todos-table').DataTable();
                let row = $('#todo-' + todoId);
                let rowIndex = table.row(row).index();
                
                if (rowIndex !== -1) {
                    let rowData = table.row(rowIndex).data();
                    rowData[1] = '<span class="todo-title">' + $('#edit_title').val() + '</span>';
                    rowData[2] = '<span class="todo-description">' + $('#edit_description').val() + '</span>';
                    table.row(rowIndex).data(rowData).draw();
                }
            }
            
            // Also update the DOM for other functionalities
            $('#todo-' + todoId + ' .todo-title').text($('#edit_title').val());
            $('#todo-' + todoId + ' .todo-description').text($('#edit_description').val());
        },
        error: function(xhr) {
            // Button reset
            submitBtn.html(originalBtnText);
            submitBtn.prop('disabled', false);
            
            if (xhr.status === 422) {
                // Validation errors
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<div class="alert alert-danger mt-3"><ul>';
                
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                
                errorHtml += '</ul></div>';
                
                // Show errors in modal
                $('#editTodoModal .modal-body').prepend(errorHtml);
            } else {
                showAlert('Error updating todo: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
            }
        }
    });
});





// Delete todo with AJAX
$(document).on('click', '.delete-todo', function() {
    if (!confirm('Are you sure you want to delete this todo?')) {
        return;
    }
    
    var todoId = $(this).data('todo-id');
    let deleteBtn = $(this);
    let originalBtnText = deleteBtn.html();
    deleteBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    deleteBtn.prop('disabled', true);
    
    $.ajax({
        url: '/todos/' + todoId,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE'
        },
        success: function(response) {
            // Button reset
            deleteBtn.html(originalBtnText);
            deleteBtn.prop('disabled', false);
            
            // Show success message
            showAlert(response.message || 'Todo deleted successfully', 'success');
            
            // Remove from DataTable if it exists
            if ($.fn.DataTable.isDataTable('#todos-table')) {
                let table = $('#todos-table').DataTable();
                let row = $('#todo-' + todoId);
                table.row(row).remove().draw();
                
                // Check if table is empty after deletion
                if (table.rows().count() === 0) {
                    $('#todos-table').addClass('d-none');
                    $('#emptyState').removeClass('d-none');
                }
            } else {
                // Remove the todo row from the table
                $('#todo-' + todoId).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Check if no todos left
                    if ($('#todos-table tbody tr').length === 0) {
                        $('#todos-table').addClass('d-none');
                        $('#emptyState').removeClass('d-none');
                    }
                });
            }
        },
        error: function(xhr) {
            // Button reset
            deleteBtn.html(originalBtnText);
            deleteBtn.prop('disabled', false);
            
            showAlert('Error deleting todo: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
        }
    });
});

// Toggle todo status with AJAX (সম্পূর্ণ সংশোধিত)
$(document).on('change', '.status-toggle', function() {
    var todoId = $(this).data('todo-id');
    var isCompleted = this.checked ? 1 : 0;
    let statusToggle = $(this);
    
    statusToggle.prop('disabled', true);
    
    $.ajax({
        url: '/todos/' + todoId + '/toggle',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            is_completed: isCompleted
        },
        success: function(response) {
            statusToggle.prop('disabled', false);
            
            // Show success message
            showAlert(response.message || 'Todo status updated successfully', 'success');
            
            // Update the UI
            var row = $('#todo-' + todoId);
            if (isCompleted) {
                row.addClass('completed');
                row.find('.badge').removeClass('bg-warning text-dark').addClass('bg-success').text('Completed');
            } else {
                row.removeClass('completed');
                row.find('.badge').removeClass('bg-success').addClass('bg-warning text-dark').text('Pending');
            }
            
            // Update DataTable if it exists
            if ($.fn.DataTable.isDataTable('#todos-table')) {
                let table = $('#todos-table').DataTable();
                let rowIndex = table.row(row).index();
                
                if (rowIndex !== -1) {
                    let rowData = table.row(rowIndex).data();
                    let statusBadge = isCompleted ? 
                        '<span class="badge bg-success">Completed</span>' : 
                        '<span class="badge bg-warning text-dark">Pending</span>';
                    
                    rowData[3] = '<div class="form-check form-switch">' +
                        '<input class="form-check-input status-toggle" type="checkbox" data-todo-id="' + todoId + '" ' + (isCompleted ? 'checked' : '') + '>' +
                        '<label class="form-check-label">' + statusBadge + '</label>' +
                    '</div>';
                    
                    table.row(rowIndex).data(rowData).draw();
                }
            }
        },
        error: function(xhr) {
            statusToggle.prop('disabled', false);
            
            showAlert('Error updating todo status: ' + (xhr.responseJSON?.message || 'Unknown error'), 'error');
            
            // Revert the checkbox on error
            statusToggle.prop('checked', !isCompleted);
        }
    });
});

// Show alert function 
function showAlert(message, type = 'success') {
    // Remove any existing alerts
    $('.alert-dismissible').alert('close');
    
    let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    let themeClass = '{{$theme=="dark" ? "bg-success text-white" : ""}}';
    
    if (type === 'error') {
        themeClass = '{{$theme=="dark" ? "bg-danger text-white" : ""}}';
    }
    
    let alertHtml = '<div class="alert ' + alertClass + ' ' + themeClass + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
    '</div>';
    
    // Prepend alert to card body
    $('.card-body').prepend(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
}
        });
    </script>
</body>
</html>