<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Student index</h1>
        <div class="mb-3 text-end">
        <a href="{{ route('students.excel') }}" class="btn btn-primary">output excel</a>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
        </div>
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $value)
                    <tr>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['age'] }}</td>
                        <td><a href="{{ route('students.edit', ['student' => $loop->index + 1]) }}" class="btn btn-warning btn-sm">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
