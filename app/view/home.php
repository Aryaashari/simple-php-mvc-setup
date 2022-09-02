<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>

        .img-avatar {
            width: 100px;
            height: 100px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
            margin: 30px auto;
            display: block;
        }

        .topup {
            margin-right: 15px;
            border: 2px solid black;
            border-radius: 10px;
            padding: 5px;
        }

        .topup:hover {
            cursor: pointer;
        }
        
        .transfer {
            border: 2px solid black;
            border-radius: 10px;
            padding: 5px;
        }

        .transfer:hover {
            cursor: pointer;
        }

        .icon {
            width: 20px;
            height: 20px;
        }

        .history .left > .icon {
            width: 40px;
            height: 40px;
            background-color: white;
            padding: 5px;
            border-radius: 10px;
            margin-right: 10px;
        }

        .history-note > .icon {
            width: 13px;
            height: 13px;
            margin-top: 4px;
        }

        .history-note .history-nominal {
            font-size: 13px;
            font-weight: bold;
            margin-left: 5px;
        }

        .history-note .history-nominal.plus {
            color: #4CAF50;
        }

        .history-note .history-nominal.minus {
            color: #FF3F62;
        }

    </style>

    <title>Home</title>
</head>
<body>

    <div class="container">

        <div class="profile-section card bg-primary mt-3">
            <img src="assets/img/arya.jpg" class="img-avatar" alt="profile-photo">
            <p class="name text-center fw-bold fs-3 text-white  lh-1">Arya Dul Fitra Ashari</p>
            <p class="accountNumber text-center text-white lh-1">12345678</p>
            <div class="buttonGroup mx-auto my-3">
                <button class="btn btn-light">Profile</button>
                <button class="btn btn-warning">Setting</button>
                <button class="btn btn-danger">Logout</button>
            </div>

            <div class="card bg-light text-center p-2 m-5">
                <p class="balance-text fw-normal fs-4 lh-1">Balance</p>
                <p class="balance-number fw-bold fs-2 lh-1">IDR 5.000.000</p>
                <div class="features d-flex justify-content-center">
                    <div class="topup" onclick="">
                        <img src="assets/img/topup.png" class="icon" alt="topup-icon">
                        <p class="fw-bold fs-6">Top Up</p>
                    </div>
                    <div class="transfer" onclick="">
                        <img src="assets/img/transfer.png" class="icon" alt="topup-icon">
                        <p class="fw-bold fs-6">Transfer</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="history-section card bg-secondary p-4 mt-3 mb-5 text-white">
            <p class="text-center fw-bold">Don't have any history</p>

            <h3 class="text-center fw-bold">Histories</h3>
            <div class="histories">
                <h5 class="month mb-4 mt-4">Agustus 2022</h5>
                <div class="history d-flex align-items-center justify-content-between mb-2">
                    <div class="left d-flex align-items-center">
                        <img src="assets/img/topup.png" class="icon" alt="topup-icon">
                        <div class="history-text">
                            <p class="history-name mb-0">To Up to wallet</p>
                            <div class="history-note d-flex">
                                <img src="assets/img/plus.png" alt="plus-icon" class="icon">
                                <p class="history-nominal plus mb-0">IDR 10.000</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="right">
                        <div class="history-date">
                            <p class="date mb-0 text-end">30 Agustus 2022</p>
                            <p class="time mb-0 text-end">16:00</p>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>