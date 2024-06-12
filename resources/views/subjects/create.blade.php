<!-- resources/views/subjects/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include any additional CSS or JS files as needed -->
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a Subject</h1>
        <form action="{{ route('store.subject') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Subject Name:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="code">Subject Code:</label>
                <input type="text" id="code" name="code" class="form-control" required>
            </div>
            <!-- Add more form fields as needed -->

            <button type="submit" class="btn btn-primary">Add Subject</button>
        </form>
    </div>
</body>
</html>
