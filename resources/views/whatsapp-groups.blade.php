<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Grup WhatsApp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
        }
        thead{
            border-radius: 10px;
            background-color: #007BFF;
            color: white;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .button {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: 0 auto
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <h2>Daftar Grup WhatsApp</h2>

    <div class="button">
        <a class="btn" href="/admin/presensis">Back</a>

        <!-- Form untuk memperbarui grup -->
        <form action="{{ route('update.group') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Update Grup</button>
        </form>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
    </div>


    <table>
        <thead>
            <tr>
                <th>ID Grup</th>
                <th>Nama Grup</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groups as $group)
                <tr>
                    <td>{{ $group['id'] }}</td>
                    <td>{{ $group['name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
