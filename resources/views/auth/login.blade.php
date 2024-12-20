<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="img/logoUnesco.png">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Nunito", serif;
            font-weight: 800;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            background: url("img/foto2.jpg"), #000;
            background-position: center;
            background-size: cover;
        }

        .wrapper {
            width: 400px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            border: 2px solid rgba(0, 163, 196, 0.922);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 1px 1px 10px 1px rgba(0, 163, 196, 0.922);
            margin: 0 1rem;
        }

        .wrapper img {
            filter: drop-shadow(0 0 0.1rem rgba(182, 195, 198, 0.922));
            filter: drop-shadow(0 0 0.1rem rgba(182, 195, 198, 0.922));
            filter: drop-shadow(0 0 0.5rem rgba(182, 195, 198, 0.922));
            filter: drop-shadow(0 0 0.5rem rgba(182, 195, 198, 0.922));
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #fff;
            text-shadow: 2px 2px rgba(0, 163, 196, 0.922);
        }

        .input-field {
            position: relative;
            border-bottom: 2px solid rgba(0, 163, 196, 0.922);
            margin: 20px 0;
        }

        .input-field label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px;
            pointer-events: none;
            transition: 0.15s ease;
            font-weight: 500;
            text-shadow: 1px 1px black;

        }

        .input-field input {
            width: 100%;
            height: 40px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #fff;
            text-shadow: 1px 1px black;
            font-weight: 400;
            letter-spacing: 1.5px;
        }

        .input-field input:focus~label,
        .input-field input:valid~label {
            font-size: 0.8rem;
            top: 10px;
            transform: translateY(-120%);
        }

        .forget {
            display: flex;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #fff;
            text-shadow: 2px 2px black;
        }

        .forget .remember_me span {
            font-weight: 400;
        }

        button {
            background: rgba(0, 163, 196, 0.922);
            color: #ffffff;
            font-weight: 800;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 7px;
            font-size: 16px;
            transition: 0.3s ease;
            text-shadow: 2px 2px black;
        }

        button:hover {
            color: #fff;
            background: transparent;
            border: 2px solid white;
            text-shadow: 1px 1px black;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }

        .gagal {
            color: red;
            font-size: 12px;
            font-weight: 400;
            background-color: rgba(176, 241, 255, 0.614);
            border-radius: 5px;
            display: inline;
            padding: 5px 10px;
        }

        @media(max-width:520px) {
            body {
                background: url("img/lognmobile.png"), #000;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                width: 100%;
                background-position: center;
                background-size: cover;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <img src="img/logoNama.png" style="width: 100px" alt="">
        <h2>Login SIMKU</h2>


        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Field -->
            <div class="input-field">
                <input type="email" id="email" name="email" autocomplete="off" value="{{ old('email') }}"
                    required autofocus>
                <label for="email">Enter your email</label>
            </div>

            <!-- Password Field -->
            <div class="input-field">
                <input type="password" id="password" name="password" required>
                <label for="password">Enter your password</label>
            </div>
            @if ($errors->any())
                <div class="gagal">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
            <!-- Remember Me -->
            <div class="forget">
                <label for="remember_me">
                    <input type="checkbox" id="remember_me" name="remember">
                    <span style="font-weight: 700; font-size:0.8rem;">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit">Log In</button>

        </form>
    </div>
</body>
</html>
