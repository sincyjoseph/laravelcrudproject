<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" 
        crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css"
        rel="stylesheet">
    <title>Laravel Todo</title>
</head>
<body>
    
<div class="container">
    <h1 class="text-center text-primary">User Registration List</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewUser" style="float: left;">Add User</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<!-- User create model pop up-->
<div class="modal fade" id="userCreateModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="usermodalHeading"></h4>
            </div>

            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">

                    <meta name="csrf-token" content="{{ csrf_token() }}" />

                    <input type="hidden" name="HI" id="HI">
                    <div class="form-group">
                        Username: 
                        <input type="text" class="form-control" id="username" name="username" 
                        placeholder="Enter username" value="" required>
                    </div>
                    <div class="form-group">
                        Password: 
                        <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Enter password" value="" required>
                    </div>
                    <div class="form-group">
                        Email:
                        <input type="email" class="form-control" id="email" name="email" 
                        placeholder="Enter email" value="" required>
                    </div>
                    <div class="form-group">
                        Gender: 
                        <label class="form-check-label">Male</label>
                        <input type="radio" class="form-check-input" id="male" name="gender" value="male" >
                        <label class="form-check-label">Female</label>
                        <input type="radio" class="form-check-input" id="female" name="gender" value="female">
                    </div>
                    <div class="form-group">
                        Address: 
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        Declaration: 
                        <input type="checkbox" class="form-check-input" id="declaration" name="declaration" value="checked">
                    </div>
                    <button type="submit" class="btn btn-primary" id="savebtn" value="save">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" 
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(function(){

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
            columns: [ 
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'username', name: 'username'},
                {data: 'password', name: 'password'},
                {data: 'email', name: 'email'},
                {data: 'gender', name: 'gender'},
                {data: 'address', name: 'address'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action'},
            ]
    });

    $("#createNewUser").click(function(){
        $('#HI').val('');
        $('#userForm').trigger("reset");
        $('#usermodalHeading').html("Add Student");
        $('#userCreateModal').modal('show');
    });

    $('#savebtn').click(function(e){
        e.preventDefault();
        $(this).html('Save');
        $.ajax({
            data:$('#userForm').serialize(),
            url:"{{ route('users.store') }}",
            type:"POST",
            dataType:'json',
            success:function(data){
                $('#userForm').trigger('reset');
                $('#userCreateModal').modal('hide');
                table.draw();
            },
            error:function(data){
                console.log("Error:", data);
                $('#savebtn').html('Save');
            }
        })
    });

    $('body').on('click', '.deleteUser', function(){
        var HI = $(this).data('id');
        console.log(HI);
        confirm("Are you sure want to delete");
        $.ajax({
            type:"DELETE",
            url:"{{route('users.store')}}"+'/'+HI,
            success:function(data){
                table.draw();
            },
            error:function(data){
                console.log('Error:', data);
            }
        })
    });

    $('body').on('click', '.editUser', function(){
        var HI = $(this).data('id');
        $.get("{{route('users.index')}}"+"/"+HI+"/edit",function(data){
            $('#usermodalHeading').html("Edit User");
            $('#userCreateModal').modal('show');
            $('#HI').val(data.id);
            $('#username').val(data.username);
            $('#password').val(data.password);
            $('#email').val(data.email);
            $('#gender').val(data.gender);
            $('#address').val(data.address);
            $('#declaration').val(data.declaration);
        });
    });

});
</script>
</body>
</html>
