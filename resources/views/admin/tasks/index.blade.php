@extends('layouts.app')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Tasks') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#assignTaskModal">
                        {{ __('Assign Task') }}
                    </button>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        </script>
    @endif

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-list table table-bordered table-striped table-hover maximized-card" style="max-width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Data will be populated via DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
    <!-- Assign Task Modal -->
    <div class="modal fade" id="assignTaskModal" tabindex="-1" role="dialog" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="assignTaskModalLabel">{{ __('Assign Task') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assignTaskForm">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="taskName">{{ __('Task Name') }}</label>
                            <input type="text" class="form-control" id="taskName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="assignedUser">{{ __('Assigned To') }}</label>
                            <select class="form-control" id="assignedUser" name="user_id" required>
                                <!-- Options will be populated by AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="taskDescription">{{ __('Task Description') }}</label>
                            <textarea class="form-control" id="taskDescription" name="description" rows="3" required></textarea>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="assignTaskButton">{{ __('Assign Task') }}</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Task Modal -->
    <div class="modal fade" id="ViewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">{{ __('View Task') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="viewTaskName">{{ __('Task Name') }}</label>
                        <input type="text" class="form-control" id="viewTaskName" name="name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewTaskDescription">{{ __('Task Description') }}</label>
                        <textarea class="form-control" id="viewTaskDescription" name="description" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="viewAssignedUser">{{ __('Assigned To') }}</label>
                        <ul class="list-group" id="viewAssignedUserList">
                            <!-- Users will be dynamically added here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Task Modal -->
    <div class="modal fade" id="UpdateTaskModal" tabindex="-1" role="dialog" aria-labelledby="updateTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTaskModalLabel">{{ __('Update Task') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateTaskForm">
                        <input type="hidden" id="updateTaskId" name="task_id">
                        <div class="form-group">
                            <label for="updateTaskName">{{ __('Task Name') }}</label>
                            <input type="text" class="form-control" id="updateTaskName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="updateTaskDescription">{{ __('Task Description') }}</label>
                            <textarea class="form-control" id="updateTaskDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="updateAssignedUser">{{ __('Assigned To') }}</label>
                            <select class="form-control" id="updateAssignedUser" name="user_id" required>
                                <!-- Options will be populated by AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="updateAssignedUser">{{ __('Assigned To') }}</label>
                            <ul class="list-group" id="updateAssignedUserList">
                                <!-- Users will be dynamically added here -->
                            </ul>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="updateTaskButton">{{ __('Update Task') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Task Modal -->
    <div class="modal fade" id="DeleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskModalLabel">{{ __('Delete Task') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this task?') }}</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteTaskButton">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.min.js"></script>


    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        input.invalid{

            border-color: red!important;
            border-radius: 4px!important;
        }

    </style>

<script type="text/javascript">
    const validationMessages = {
        name: 'This field is required',
    };
    function validateField(input) {
        let errorMessage = '';

        switch (input.attr('name')) {
            case 'name':
                errorMessage = input.val() === '' ? validationMessages.name : '';
                break
            case 'description':
                errorMessage = input.val() === '' ? validationMessages.name : '';
                break;
            case 'user_id':
                errorMessage = input.val() === '' ? validationMessages.name : '';

        }

        return errorMessage;
    }
    function showError(input, message) {
        input.addClass('invalid');
        input.siblings('.error-message').remove();
        if (message) {
            input.after(`<div class="error-message">${message}</div>`);
        }
    }

    function clearError(input) {
        input.removeClass('invalid');
        input.siblings('.error-message').remove();
    }
    $(document).ready(function () {
        new DataTable('.table-list',{
            processData:true,
            serverSide:true,
            ajax:{
                url:'{{url('tasks/list')}}',
                method:'GET'
            },
            columns:[
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'action', name: 'action' },
            ]
        })

        $('input, select').on('input change', function () {
            const errorMessage = validateField($(this));
            if (errorMessage) {
                showError($(this), errorMessage);
            } else {
                clearError($(this));
            }
        });

        // Fetch users when the modal is opened
        $('#assignTaskModal').on('show.bs.modal', function () {
            $.ajax({
                url: '{{ route('tasks.create') }}',
                method: 'GET',
                success: function (response) {
                    let usersDropdown = $('#assignedUser');
                    usersDropdown.empty();
                    $.each(response.users, function (key, user) {
                        usersDropdown.append(new Option(user.name, user.id));
                    });
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#assignTaskButton').click(function () {
            $(this).prop('disabled', true)

            const fields = ['name', 'description', 'user_id'];
            let hasErrors=false

            fields.forEach(field => {
                const input = $(`[name="${field}"]`);
                const errorMessage = validateField(input);
                if (errorMessage) {
                    showError(input, errorMessage);
                    hasErrors = true;
                }
            });
            if (hasErrors){
                $(this).prop('disabled', false);
                return;
            }

            const data={
                'name': $('#taskName').val(),
                'description': $('#taskDescription').val(),
                'user_id': $('#assignedUser').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            }

            $.ajax({
                url:'{{url('tasks/store')}}',
                method:'POST',
                data:data,

                success:function (response){
                    $('#assignTaskModal').modal('hide');
                    window.location.reload();
                },
                error:function (error){
                    console.log('Error', error);

                }
            })

        })


    //     view task
        $('#ViewTaskModal').on('show.bs.modal', function (e){
            var button = $(e.relatedTarget);
            var action = button.data('action');
            var id = button.data('id');
            console.log(id)

            if(action ==='view'){
                $.ajax({
                    url:'{{url('tasks/show')}}/'+ id,
                    method:'GET',
                    success:function (response){
                        console.log(response)
                        $('#viewTaskName').val(response.task.name);
                        $('#viewTaskDescription').val(response.task.description);
                        // Clear the existing list
                        $('#viewAssignedUserList').empty();

                        // Loop through the users and add them to the list
                        response.task.users.forEach(function (user) {
                            $('#viewAssignedUserList').append('<li class="list-group-item">' + user.name + '</li>');
                        });
                    },
                    error:function (error){
                        console.log('Error',  error)
                    }

                })
            }
        })

        let taskToDeleteId=null

        $(document).on('click', '#delete-btn', function () {
            taskToDeleteId = $(this).data('task-id');
            $('#DeleteTaskModal').modal('show');
        });

        $('#confirmDeleteTaskButton').on('click', function(){
            if(taskToDeleteId !== null){
                $.ajax({
                    url:'tasks/delete/' + taskToDeleteId,
                    method:'DELETE',
                    data:{
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response){
                        $('#dataset-' + taskToDeleteId).remove();
                        $('#deleteTaskModalLabel').modal('hide');
                        window.location.reload();

                    },
                    error:function (error){
                        console.log(error);
                    }
                })
            }
        })


        $('#UpdateTaskModal').on('show.bs.modal', function (e){
            var button= $(e.relatedTarget)
            var id = button.data('id');

            $.ajax({
                url:'{{url('tasks/edit')}}/'+ id,
                method:'GET',
                success:function (response){
                    // console.log(response);
                    $('#updateTaskId').val(response.task.id);
                    $('#updateTaskName').val(response.task.name);
                    $('#updateTaskDescription').val(response.task.description);
                    let usersDropdown = $('#updateAssignedUser');
                    usersDropdown.empty();
                    $.each(response.users, function (key, user) {
                        usersDropdown.append(new Option(user.name, user.id));
                    });

                    $('#updateAssignedUserList').empty();

                    // Loop through the users and add them to the list
                    response.task.users.forEach(function (user) {
                        $('#updateAssignedUserList').append('<li class="list-group-item">' + user.name + '</li>');
                    });

                },
                error:function (error){
                    console.log('Error', error)
                }


            })



        })

        $('#updateTaskButton').click(async  function(){

            let id=$('#updateTaskId').val();


            let name= $('#updateTaskName').val();
            let description=$('#updateTaskDescription').val();
            let user_id=$('#updateAssignedUser').val();
            $(this).prop('disabled', true)

            const fields = [name, description, user_id];
            let hasErrors=false

            fields.forEach(field => {
                const input = $(`[name="${field}"]`);
                const errorMessage = validateField(input);
                if (errorMessage) {
                    showError(input, errorMessage);
                    hasErrors = true;
                }
            });
            if (hasErrors){
                $(this).prop('disabled', false);
                return;
            }


            let data={
                'name': name,
                'description':description,
                'user_id':user_id,
                _token: '{{ csrf_token() }}'
            }

            $.ajax({
                url:'{{url('tasks/update')}}/'+ id,
                method:'POST',
                data:data,
                success:function (response){
                    $('#UpdateTaskModal').modal('hide');

                    // Reload the DataTable
                    window.location.reload();
                },
                error:function (err){
                    console.log('Error', err);
                }
            })



        })




    })

</script>
@endsection
