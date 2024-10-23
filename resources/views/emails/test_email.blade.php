{{-- resources/views/emails/test_email.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: white;
            text-align: center;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
            background-color: #282c34;
            border-radius: 8px;
        }
        .button {
            background-color: #1877f2;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            display: inline-block; /* Change to inline-block for proper alignment */
            margin-top: 15px;
        }
        .header-image {
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $datamail['title'] }}</h1>
        <img src="data:image/jpeg;base64,{{ $datamail['body'] }}" alt="Image Promotion" class="header-image">
        <p>{{ $datamail['contain'] }}</p>
        <a href="#" class="button">Je découvre</a>
    </div>
</body>
</html>
