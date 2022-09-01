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
        }
        @media (min-width: 767px) {
            .card {
                width: 400px;
            }
        }

    </style>

    <title>EWallet - Register User</title>
</head>
<body>

    <div class="container">
        <div class="card m-auto mt-2">
            <div class="card-body">
                <div class="card-title text-center fw-bold">
                    <h1 class="fs-2">REGISTER</h1>
                </div>
                <form action="#">

                    <div class="mb-3">
                        <label for="neme" class="form-label">Name</label>
                        <input type="text" class="form-control" id="neme">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>

                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password">
                    </div>

                    <button class="mb-3 btn btn-primary w-100">Next</button>
                    
                    <p class="text-center">Already have an account? <a href="/users/login" class="mb-3">Login</a></p>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>