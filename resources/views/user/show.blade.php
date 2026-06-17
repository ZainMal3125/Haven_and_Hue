<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <table id="userTable" border="1px solid black">
        <thead>
            <tr>
                <th>first name</th>
                <th>last name</th>
                <th>email</th>
                <th>role</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userRole as $userRole)
            <tr>
                <td>{{$userRole->user->first_name}}</td>
                <td>{{$userRole->user->last_name}}</td>
                <td>{{$userRole->user->email}}</td>
                <td>{{$userRole->role->name}}</td>
                <td>
                    <form action="{{route('userEdit')}}" method="post">
                        @csrf
                        <input type="hidden" name="edit" value="{{$userRole->id}}">
                        <input type="submit" value="edit">
                    </form>
                    <form action="{{route('userDelete')}}" method="post">
                        @csrf
                        <input type="hidden" name="delete" value="{{$userRole->id}}">
                        <input type="submit" value="delete">
                    </form>
                </td>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $(document).ready(function () {
        $('#userTable').DataTable(
        {
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "lengthMenu": [ [1, 3, 5, 10], [1, 3, 5, 10] ],
        }
        );
    });
</script>
</html>