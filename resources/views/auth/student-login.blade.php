<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - IIUM Event Hub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('/images/bg.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-box {
            position: relative;
            z-index: 2;
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 400px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #0066cc;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #0066cc;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #0052a3;
        }

        .back-link {
            margin-top: 20px;
            display: block;
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="/images/Logo.png" alt="Logo" style="width: 80px; margin-bottom: 20px;">
        <h2>Student Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" value="student">
            <div class="input-group">
                <label>Matric ID</label>
                <input type="text" name="email" placeholder="Enter Matric ID" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
<a href="{{ route('role.select') }}" class="back-link">← Back to Role Selection</a>    </div>
</body>
</html>