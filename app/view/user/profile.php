<?php 
use Ewallet\Config\App;
?>

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
            margin: 20px auto;
        }

        .box-avatar {
            width: 100px;
            height: 100px;
            position: relative;
            margin: 20px auto;
        }

        .img-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }

        .pen-icon {
            width: 30px;
            height: 30px;
            position: absolute;
            right: 0;
            bottom: 0;
            background-color: white;
            border-radius: 50%;
            padding: 7px;
            object-fit: contain;
        }

        .pen-icon:hover {
            cursor: pointer;
        }

        @media (min-width: 767px) {
            .card {
                width: 600px;
            }
        }

    </style>

    <title>EWallet - Profile User</title>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center fw-bold">
                    <h1 class="fs-3">PROFILE</h1>
                </div>
                <form action="/users/profile" method="POST" enctype="multipart/form-data">

                    <div class="box-avatar">
                        <img src="<?= App::$baseUrl ?>/assets/img/profile/<?= $data["photo"] ?>" id="imgAvatar" class="img-avatar" alt="profile-photo">
                        <label for="photoProfile" class="btn">
                            <img src="../assets/img/pen.png" class="pen-icon" alt="pen-icon">
                        </label>
                        <input id="photoProfile" style="visibility:hidden;" name="profilePhoto" accept="image/png, image/jpeg" type="file">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= $data["fullName"] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" disabled name="email" id="email" value="<?= $data["email"] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $data["username"] ?>">
                    </div>

                    <button class="mb-3 btn btn-primary w-100" id="saveBtn" type="submit" disabled>Save</button>
                    <a href="/" class="mb-3 btn btn-danger w-100">Back</a>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        let photoProfile = document.getElementById('photoProfile');
        let name = document.getElementById('name');
        let email = document.getElementById('email');
        let username = document.getElementById('username');

        let saveBtn = document.getElementById('saveBtn');

        let imgAvatar = document.getElementById('imgAvatar');

        photoProfile.addEventListener('change', function(e) {
            saveBtn.removeAttribute('disabled');
            let reader = new FileReader();
            reader.onload = function(e) {
                imgAvatar.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(photoProfile.files[0]);
        });

        name.addEventListener('keyup', function() {
            saveBtn.removeAttribute('disabled');
        });

        email.addEventListener('keyup', function() {
            saveBtn.removeAttribute('disabled');
        });

        username.addEventListener('keyup', function() {
            saveBtn.removeAttribute('disabled');
        });

    </script>

    <?php if(false) : ?>
        <script>

            swal('Hallo');
        </script>
    <?php endif; ?>

</body>
</html>