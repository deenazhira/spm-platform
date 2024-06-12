<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Subject</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }
            50% { background: linear-gradient(135deg, #fcb69f 0%, #ffecd2 100%); }
            100% { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #ffffff;
            animation: slideInFromTop 1s ease-out;
        }

        @keyframes slideInFromTop {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #ffecd2;
            animation: slideInFromLeft 1s ease-out;
        }

        @keyframes slideInFromLeft {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #5d391e;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fff1e2;
            animation: slideInFromRight 1s ease-out;
        }

        @keyframes slideInFromRight {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        button {
            background-color: #fff6e9;
            color: #000000;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #433528;
            color: #fbecd8;
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ADD A SUBJECT</h1>
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <label for="username">Student Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="code">Subject Code:</label>
            <input type="text" id="code" name="code" required>

            <label for="title">Subject Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="topic_number">Topic Number:</label>
            <input type="number" id="topic_number" name="topic_number" required>

            <button type="submit">Add Subject</button>
        </form>
    </div>
</body>
</html>
