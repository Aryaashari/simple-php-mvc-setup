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
            margin: 70px auto;
        }

        @media (min-width: 767px) {
            .card {
                width: 400px;
            }
        }

    </style>

    <title>EWallet - Change Password</title>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center fw-bold">
                    <h1 class="fs-2">CHANGE PASSWORD</h1>
                </div>
                <form action="/password/change" method="post">

                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password" class="form-control" name="oldPassword" id="oldPassword">
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="newPassword" id="newPassword">
                    </div>

                    <div class="mb-3">
                        <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirmNewPassword" id="confirmNewPassword">
                    </div>
                    
                    <button class="mb-3 btn btn-primary w-100" type="submit">Change</button>
                    <a href="/" class="mb-3 btn btn-danger w-100">Back</a>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php if(false) : ?>
        <script>

            swal('Hallo');
        </script>
    <?php endif; ?>

</body>
</html>