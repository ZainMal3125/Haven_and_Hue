<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
</head>
<body>
    <form action="{{route('userSubmission')}}" method="post">
        @csrf
        <label for="">First Name</label>
        <input type="text" name="fname">
        <label for="">Last Name</label>
        <input type="text" name="lname">
        <label for="">Email</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="password">
        <label for="">Select Role</label>
            @foreach($role as $role) <br>
            <input type="checkbox" name="role[]" value="{{$role->id}}">{{$role->name}}
            @endforeach
        </select>
<br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>