<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stylesheet -->
    <style media="screen">
        *, *:before, *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #25252a;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Homepage ၏ Header အရောင် (#7b001c) နှင့် ကိုက်ညီသော Animated Background */
        .area {
            background: #25252a;
            background: -webkit-linear-gradient(to left, #43000f, #7b001c);
            width: 100%;
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .circles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.15);
            animation: animate 25s linear infinite;
            bottom: -150px;
        }

        .circles li:nth-child(1){ left: 25%; width: 80px; height: 80px; animation-delay: 0s; }
        .circles li:nth-child(2){ left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s; }
        .circles li:nth-child(3){ left: 70%; width: 20px; height: 20px; animation-delay: 4s; }
        .circles li:nth-child(4){ left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s; }
        .circles li:nth-child(5){ left: 65%; width: 20px; height: 20px; animation-delay: 0s; }
        .circles li:nth-child(6){ left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
        .circles li:nth-child(7){ left: 35%; width: 150px; height: 150px; animation-delay: 7s; }
        .circles li:nth-child(8){ left: 50%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; }
        .circles li:nth-child(9){ left: 20%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; }
        .circles li:nth-child(10){ left: 85%; width: 150px; height: 150px; animation-delay: 0s; animation-duration: 11s; }

        @keyframes animate {
            0%{
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100%{
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }

        /* Glassmorphism Login Form */
        form {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.12);
            position: absolute;
            transform: translate(-50%,-50%);
            top: 50%;
            left: 50%;
            border-radius: 14px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            padding: 40px 35px;
            z-index: 10;
        }

        form * {
            font-family: 'Inter', sans-serif;
            color: #ffffff;
            letter-spacing: 0.3px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 26px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-size: 13px;
            font-weight: 500;
            color: #f3f4f6;
        }

        .input-group {
            position: relative;
            margin-top: 6px;
        }

        input {
            display: block;
            height: 46px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            padding: 0 40px 0 14px;
            font-size: 14px;
            font-weight: 400;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #ffffff;
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        ::placeholder {
            color: #d1d5db;
        }

        /* Password Eye Icon */
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #d1d5db;
            font-size: 16px;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #ffffff;
        }

        /* Homepage ၏ Header အရောင်နှင့် လိုက်ဖက်သော Button ဒီဇိုင်း */
        button {
            margin-top: 25px;
            width: 100%;
            background: #7b001c;
            color: #ffffff;
            padding: 13px 0;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #940022;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        button:active {
            transform: translateY(1px);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.3);
            border: 1px solid rgba(239, 68, 68, 0.5);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #fee2e2;
        }
    </style>
</head>
<body>

    <!-- Homepage နှင့် လိုက်ဖက်သော Animated Background -->
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        
        <h3>Admin Login</h3>

        <!-- Error များကို ဖော်ပြရန် -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <label for="email">Email Address</label>
        <div class="input-group">
            <input type="email" name="email" placeholder="name@example.com" id="email" required value="{{ old('email') }}">
        </div>

        <label for="password">Password</label>
        <div class="input-group">
            <input type="password" name="password" placeholder="••••••••" id="password" required>
            <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <button type="submit">Sign In</button>
    </form>

    <!-- Password Show/Hide JavaScript -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>