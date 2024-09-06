<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- @vite(['resources/js/scripts.js']) --}}
</head>

<body>
    <div class="container">
        <h2>Create Customer</h2>

        <div id="response-message"></div>

        {{-- @if (Session::has('error'))
            <p class="alert alert-success">{{Session::get('error')}}</p>
        @endif --}}

        <form id="customer-form" action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" class="form-control">
            </div>

            <div class="form-group">
                <label for="gender">Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="other" value="other  ">
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>   
    <script>
        $(document).ready(function() {
            $('#customer-form').on('submit', function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('customers.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        let successHtml = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ${response.success}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
                        $('#response-message').html(successHtml);

                        // Automatically hide the alert after 5 seconds
                        setTimeout(function() {
                            $('.alert').alert('close');
                        }, 5000);

                        $('#customer-form')[0].reset();
                    },


                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>`;
                        $.each(errors, function(key, value) {
                            errorHtml += `<li>${value[0]}</li>`;
                        });
                        errorHtml += `</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
                        $('#response-message').html(errorHtml);

                        // Automatically hide the alert after 5 seconds
                        setTimeout(function() {
                            $('.alert').alert('close');
                        }, 5000);
                    },


                });
            });
        });
    </script>

</body>

</html>
