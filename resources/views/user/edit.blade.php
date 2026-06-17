<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
</head>
<body>
    <form action="{{route('userUpdate')}}" method="post">
        @csrf
        <input type="hidden" name="update" value="{{$update->id}}">
        <label for="">First Name</label>
        <input type="text" name="fname" value="{{$update->first_name}}">
        <label for="">Last Name</label>
        <input type="text" name="lname"value="{{$update->last_name}}">
        <label for="">Email</label>
        <input type="email" name="email" value="{{$update->email}}">
        <input type="submit" value="Submit">
    </form>
</body>
</html>