<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .card {
            background-color: #7FBCD2;
            margin: 100px auto;
        }

        @media (min-width: 767px) {
            .card {
                width: 400px;
            }
        }

    </style>

    <title>EWallet - Login User</title>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center fw-bold">
                    <h1 class="fs-2">LOGIN</h1>
                </div>
                <form action="#">

                    <div class="mb-3">
                        <label for="usernameForm" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="usernameForm">
                    </div>

                    <div class="mb-3">
                        <label for="passwordForm" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="passwordForm">
                        <a href="#" id="forgotPasswordBtn">Forgot Password</a>
                    </div>

                    <button class="mb-3 btn btn-primary w-100" id="btnLogin" type="button">Login</button>
                    
                    <p class="text-center">Don't have an account? <a href="/users/register" class="mb-3">Register</a></p>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="../assets/js/validation/login.js"></script>

    <?php

    use Ewallet\Helper\FlashMessage;

    if(isset($_COOKIE['FLASH_MESSAGE_SUCCESS'])) : ?>
        <script>
            swal("Success!", '<?= FlashMessage::GetMessage() ?>', "success");
        </script>
    <?php elseif(isset($_COOKIE["FLASH_MESSAGE_ERROR"])) : ?>
        <script>
                swal("Error!", '<?= FlashMessage::GetMessage() ?>', "error");
        </script>
    <?php endif; ?>

</body>
</html>