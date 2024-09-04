@extends('layouts.app')


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Invite Users') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#InviteUserModal">
                        {{ __('Invite User') }}
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
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>status</th>
                                        <th>Invitation Sent</th>
                                        <th>Invitation Expiry</th>
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

    <!-- Invite User Modal -->
    <div class="modal fade" id="InviteUserModal" tabindex="-1" role="dialog" aria-labelledby="InviteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="InviteUserModalLabel">{{ __('Invite User') }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <form id="inviteUserId">
                       <meta name="csrf-token" content="{{ csrf_token() }}">
                       <div id="invite-form-errors" class="alert alert-danger d-none"></div>
                       <div class="form-group">
                           <label for="name">{{ __('Name') }}</label>
                           <input type="text" class="form-control" id="name" name="name" required>
                       </div>
                       <div class="form-group">
                           <label for="email">{{ __('Email') }}</label>
                           <input type="email" class="form-control" id="email" name="email" required>
                       </div>
                       <div class="form-group">
                           <label for="phone">{{ __('Phone') }}</label>
                           <input type="text" class="form-control" id="phone" name="phone" required>
                       </div>
                       <div class="form-group">
                           <label for="password">{{ __('Password') }}</label>
                           <input type="password" class="form-control" id="password" name="password" required>
                       </div>
                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitInvitation">{{ __('Send Invitation') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JQuery -->
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
            email: 'Please enter a valid email address',
            phone: 'Phone number must be less then or equal to 12 characters',
            password: 'Password must be at least 8 characters long',
            passwordPattern: 'Password must be include one uppercase letter, one number, and one special character',
        };
        function validateField(input) {
            let errorMessage = '';

            switch (input.attr('name')) {
                case 'name':
                    errorMessage = input.val() === '' ? validationMessages.name : '';
                    break;
                case 'email':
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    errorMessage = input.val() === '' ? validationMessages.name :
                        !emailPattern.test(input.val()) ? validationMessages.email : '';
                    break;
                case 'phone':
                    const phoneValue = input.val();
                    const phonePattern = /^\d+$/; // Only digits allowed
                    errorMessage = phoneValue === '' ? validationMessages.name :
                        !phonePattern.test(phoneValue) ? 'Phone number must contain only numeric values' :
                            phoneValue.length > 12  ? validationMessages.phone : '';
                    break;
                case 'password':
                    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                    errorMessage = input.val() === '' ? validationMessages.name :
                        input.val().length < 8 ? validationMessages.password :
                            !passwordPattern.test(input.val()) ? validationMessages.passwordPattern : '';
                    break;
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
        $(document).ready(function (){
            new DataTable('.table-list',{
                processData:true,
                serverSide:true,
                ajax:{
                    url:'{{url('user-invitations/list')}}',
                    method:'GET'
                },
                columns:[
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status', name: 'status' },
                    { data: 'invitation_time', name: 'invitations_time' },
                    { data: 'invitation_expiry', name: 'invitations_expiry' },
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


            $('#submitInvitation').click(async  function(e){
                e.preventDefault()

                $(this).prop('disabled', true)

                const fields = ['name', 'email', 'phone', 'password'];
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
                    'name':$('#name').val(),
                    'phone':$('#phone').val(),
                    'email':$('#email').val(),
                    'password':$('#password').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
                $.ajax({
                    url:'{{url('invite-user/store')}}',
                    method:'POST',
                    data:data,
                    success:function (response){
                        $('InviteUserModal').modal('hide');
                        window.location.reload();
                    },
                    error:function (error){
                        console.log('Error', error);
                    }
                })


            })
        })

    </script>
@endsection

