<?php
$error = '';
$success_msg = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="css/cssFile.css"> -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <!-- Other scripts or stylesheets if needed -->
    <style>
        #error_message,
        #success_message {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        Registration Form
                    </div>
                    <div id="error_message" class="alert alert-warning" role="alert">
                    </div>
                    <div id="success_message" class="alert alert-success" role="alert">
                    </div>
                    <div class="card-body">
                        <form id="registrationForm" method="POST">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" value="register" name="register" id="registerBtn" class="btn btn-primary">Submit</button>
                            <a href="login.php" class="btn btn-success">login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional - for some features like dropdowns, etc.) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                formData += "&register=register";
                $.ajax({
                    url: 'process_registration.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if (response.error !== '') {
                            alert(response.error)
                            $('#error_message').html(response.error).show();
                            $('#success_message').hide();
                        } else if (response.success_msg !== '') {
                            alert(response.success_msg);
                            $('#success_message').html(response.success_msg).show();
                            $('#error_message').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>