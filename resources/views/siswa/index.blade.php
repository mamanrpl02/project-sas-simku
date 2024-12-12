<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5em;
        }

        .balance {
            text-align: center;
            padding: 20px;
            font-size: 1.2em;
        }

        .menu {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .menu button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }

        .menu button:hover {
            background-color: #0056b3;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            padding: 10px;
        }

        .grid-item {
            background-color: #f1f1f1;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            font-size: 0.8em;
        }

        .grid-item img {
            max-width: 40px;
            margin-bottom: 5px;
        }

        .footer {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .footer button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .footer img {
            max-width: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">DASHBOARD</div>
        <div class="balance">
            <p>Saldo: <strong>Rp 400</strong></p>
        </div>
        <div class="menu">
            <button>Pindai</button>
            <button>Isi Saldo</button>
            <button>Kirim</button>
            <button>Minta</button>
        </div>
        <div class="grid">
            <div class="grid-item">
                <img src="https://via.placeholder.com/40" alt="Pulsa">
                <p>Pulsa & Data</p>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/40" alt="Rewards">
                <p>A+ Rewards</p>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/40" alt="Deals">
                <p>DANA Deals</p>
            </div>
            <div class="grid-item">
                <img src="https://via.placeholder.com/40" alt="Listrik">
                <p>Listrik</p>
            </div>
        </div>
        <div class="footer">
            <button><img src="https://via.placeholder.com/30" alt="Home"></button>
            <button><img src="https://via.placeholder.com/30" alt="Activity"></button>
            <button><img src="https://via.placeholder.com/30" alt="Pay"></button>
            <button><img src="https://via.placeholder.com/30" alt="Wallet"></button>
            <button><img src="https://via.placeholder.com/30" alt="Profile"></button>
        </div>
    </div>
</body>

</html>
