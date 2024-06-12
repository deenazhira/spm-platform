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
            font-family: Arial, sans-serif;
            background-image: url('assets/img/aina.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(245, 245, 220, 0.9); /* Beige background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f8f8f8; /* Light beige background for inputs */
        }

        button {
            background-color: #d2b48c; /* Tan color for button */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #a47c48; /* Darker tan on hover */
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
