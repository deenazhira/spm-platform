<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        }

        .container {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            color: #fff;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 26px;
            text-align: center;
            color: #fff6e0;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            background: #fff1e2;
        }

        .error {
            color: #ffcccc;
            font-size: 0.9rem;
            margin-top: -15px;
            margin-bottom: 10px;
        }

        button {
            background-color: #fff6e9;
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        button:hover {
            background-color: #433528;
            color: #fff6e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a New Subject</h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('subjects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="username">Student Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>

            <label for="code">Subject Code:</label>
            <input type="text" id="code" name="code" value="{{ old('code') }}" required>

            <label for="title">Subject Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>

            <label for="topic_number">Topic Number:</label>
            <input type="number" id="topic_number" name="topic_number" value="{{ old('topic_number') }}" required>

            <label for="syllabus">Upload Syllabus (PDF only):</label>
            <input type="file" id="syllabus" name="syllabus" accept=".pdf" required>

            <button type="submit">Add Subject</button>
        </form>
    </div>
</body>
</html>
