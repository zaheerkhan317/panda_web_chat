<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 50px;
        }

        h1 {
            color: #555;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div>
        <h1>Password Reset Successful</h1>
        <p>Your password has been reset successfully.</p>
        <p><a href="{{ route('login') }}">Go to Login</a></p>
    </div>
</body>
</html>
