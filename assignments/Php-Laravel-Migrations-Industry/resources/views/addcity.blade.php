<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>add city</title>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>Add City</h1>
    <form id="cityForm" method="POST" action="{{ route('addcity.store') }}">
        @csrf
        <label>City Name:</label>
        <input type="text" name="cname" id="cityname" required>
        <br>
        <label>State:</label>
        <input type="text" name="state" id="state" required>
        <br>
        <button type="submit">Add City</button>
    </form>
</body>

</html>
