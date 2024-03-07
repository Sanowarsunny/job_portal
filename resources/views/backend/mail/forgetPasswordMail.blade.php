<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password Email</title>
</head>
<body>
    <h1>Hello {{ $mailData['user']->name }}</h1>
    
    <p><a href="{{ route('resetPasswordPage',$mailData['token']) }}">Click Here for Change Password</a></p>

</body>
</html>