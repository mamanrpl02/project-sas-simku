<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Maintenance</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(135deg, #06080a, #bdc3c7);
            color: #fff;
            text-align: center;
        }

        .container {
            width: 80%;
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 4rem;
            margin: 0;
        }

        p {
            font-size: 1.2rem;
            margin: 30px 0 30px;
        }

        .timer {
            font-size: 1.5rem;
            font-weight: bold;
        }

        button {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #c0392b;
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

        @media (max-width: 480px) {
            h1 {
                font-size: 2.5rem;
            }

            p {
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- <h1>503</h1> --}}
        <p>Situs web kami sedang dalam perbaikan. Silakan periksa lagi nanti.</p>
        <p class="timer">
            Mengarahkan kembali dalam <span id="countdown">10</span> detik...</p>
        <button onclick="retryNow()">Retry Now</button>
    </div>

    <script>
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                redirectToHome();
            }
        }, 1000);

        function redirectToHome() {
            window.location.href = '/'; // Replace '/' with your homepage URL
        }

        function retryNow() {
            redirectToHome();
        }
    </script>
</body>

</html>
