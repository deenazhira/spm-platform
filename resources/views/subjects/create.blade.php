<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Subject</title>
</head>
<body>
    <h1>Create New Subject</h1>
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <label for="title">Subject Title:</label><br>
        <input type="text" id="title" name="title"><br><br>
        <button type="submit">Create Subject</button>
    </form>
</body>
</html>
