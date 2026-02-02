<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 | Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            font-family: Arial, Helvetica, sans-serif;
            color: #e5e7eb;
        }

        .box {
            text-align: center;
            padding: 40px;
            border-radius: 12px;
            background: #020617;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            max-width: 420px;
            width: 90%;
        }

        h1 {
            font-size: 96px;
            margin: 0;
            color: #ef4444;
        }

        h2 {
            margin: 10px 0;
            font-weight: 600;
        }

        p {
            font-size: 15px;
            opacity: 0.9;
            margin-bottom: 25px;
        }

        a {
            display: inline-block;
            padding: 10px 18px;
            background: #ef4444;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        a:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>

    <div class="box">
        <h1>404</h1>
        <h2>Not Found</h2>
        <a href="{{ route('login') }}">Go to Admin Login</a>
    </div>

</body>
</html>
