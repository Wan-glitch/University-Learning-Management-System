<!DOCTYPE html>
<html>
<head>
    <title>Your Account Information Updated</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}!</h1>
    <p>Your account information has been updated with the following details:</p>
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>
    <p>Please log in and change your password as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>
