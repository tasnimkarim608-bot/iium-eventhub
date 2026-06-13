<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIUM Event Hub</title>
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

        /* Dark overlay for better text visibility */
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

        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 40px;
        }

        .logo-container {
            margin-bottom: 60px;
        }

        .eventhub-logo {
            max-width: 500px;
            width: 100%;
            margin-bottom: 20px;
        }

        .app-logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .role-buttons {
            display: flex;
            flex-direction: column;
            gap: 25px;
            align-items: center;
        }

        .role-btn {
            width: 300px;
            padding: 20px 40px;
            font-size: 24px;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            font-family: inherit;
        }

        .role-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .student-btn {
            background-color: #00A19D;
            color: white;
        }

        .organizer-btn {
            background-color: #FFD100;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="/images/Textlogo.png" alt="IIUM Event Hub" class="eventhub-logo">
            <br>
            <img src="/images/Logo.png" alt="IIUM Logo" class="app-logo">
        </div>

        <div class="role-buttons">
            <button class="role-btn student-btn" onclick="window.location='{{ route('student.login') }}'">
    Student Login
</button>
<button class="role-btn organizer-btn" onclick="window.location='{{ route('organizer.login') }}'">
    Organizer Login
</button>
        </div>
    </div>
</body>
</html>