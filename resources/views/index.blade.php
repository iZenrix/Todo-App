<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Todo</th>
                <th>Active</th>
                <th>Done</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todo as $t)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $t->mahasiswa->nama }}</td>
                    <td>{{ $t->todo }}</td>

                    <td>{{ $t->is_active }}</td>
                    <td>{{ $t->is_done }}</td>
                    <td>@mdo</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
