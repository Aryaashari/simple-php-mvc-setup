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
            <img src="<?= App::$baseUrl ?>/assets/img/profile/<?= $data["photo"] ?>" class="img-avatar" alt="profile-photo">
            <p class="name text-center fw-bold fs-3 text-white  lh-1"><?= $data["fullname"] ?></p>
            <p class="accountNumber text-center text-white lh-1"><?= $data["accountNumber"] ?></p>
            <div class="buttonGroup mx-auto my-3">
                <a href="/users/profile" class="btn btn-light">Profile</a>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#settingModal">Settings</button>
                <button class="btn btn-danger" id="logoutBtn" onclick="handleLogout()">Logout</button>
            </div>

            <div class="card bg-light text-center p-2 m-5">
                <p class="balance-text fw-normal fs-4 lh-1">Balance</p>
                <p class="balance-number fw-bold fs-2 lh-1">IDR <?= $data["balance"] ?></p>
                <div class="features d-flex justify-content-center">
                    <div class="topup" data-bs-toggle="modal" data-bs-target="#topupModal">
                        <img src="assets/img/topup.png" class="icon" alt="topup-icon">
                        <p class="fw-bold fs-6">Top Up</p>
                    </div>
                    <div class="transfer" data-bs-toggle="modal" data-bs-target="#transferModal">
                        <img src="assets/img/transfer.png" class="icon" alt="topup-icon">
                        <p class="fw-bold fs-6">Transfer</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="history-section card bg-secondary p-4 mt-3 mb-5 text-white">
            <p class="text-center fw-bold">Don't have any history</p>

            <h3 class="text-center fw-bold">Histories</h3>

            <?php if (count($data["histories"]) == 0) : ?>
                <h5 class="text-center mt-5">History kosong</h5>
            <?php else : ?>

                <?php foreach($data["histories"] as $history) : ?>
                    <?php $date = DateTime::createFromFormat("Y-m-d H:i:s", $history->create_time) ?>
                    <div class="histories">
                        <h5 class="month mb-4 mt-4"><?= $date->format('F Y') ?></h5>
                        <div class="history d-flex align-items-center justify-content-between mb-2">
                            <div class="left d-flex align-items-center">
                                <?php if ($history->history_type == "topup") : ?>
                                    <img src="assets/img/topup.png" class="icon" alt="topup-icon">
                                <?php else : ?>
                                    <img src="assets/img/transfer.png" class="icon" alt="transfer-icon">
                                <?php endif; ?>
                                <div class="history-text">
                                    <p class="history-name mb-0"><?=  $history->history_name ?></p>
                                    <div class="history-note d-flex">
                                        <?php if ($history->history_category == "in") : ?>
                                            <img src="assets/img/plus.png" alt="plus-icon" class="icon">
                                            <p class="history-nominal plus mb-0">IDR <?= $history->nominal ?></p>
                                        <?php else : ?>
                                            <img src="assets/img/minus.png" alt="minus-icon" class="icon">
                                            <p class="history-nominal minus mb-0">IDR <?= $history->nominal ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="right">
                                <div class="history-date">
                                    <p class="date mb-0 text-end"><?= $date->format('d F Y') ?></p>
                                    <p class="time mb-0 text-end"><?= $date->format('H:i:s') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            
        </div>

    </div>



    <!-- Modal Top Up -->
    <div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="topupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="topupModalLabel">Top Up</h5>
                    <button type="button" class="btn-close" onclick="resetModalData()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/users/wallet/topup" id="formTopup" method="post">
                    <div class="modal-body">

                        <input type="text" name="nominal" class="form-control" id="topupNominal" placeholder="Min IDR 10.000" autocomplete="off">

                        <input type="text" name="pin" class="form-control d-none" id="pinTopup" placeholder="Enter your PIN" autocomplete="off">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetModalData()" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnTopup" disabled onclick="pinSectionTopup()">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Transfer -->
    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">Transfer</h5>
                    <button type="button" class="btn-close" onclick="resetModalData()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/users/wallet/transfer" method="post" id="formTransfer">
                    <div class="modal-body">

                        <input type="text" name="accountNumber" class="form-control mb-3" id="accountNumber" placeholder="Account Number"autocomplete="off">
                        <input type="text" name="nominal" class="form-control" id="transferNominal" placeholder="Min IDR 10.000" autocomplete="off">

                        <input type="text" name="pin" class="form-control d-none" id="pinTransfer" placeholder="Enter your PIN" autocomplete="off">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="resetModalData()" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnTransfer" disabled onclick="pinSectionTransfer()">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Setting -->
    <div class="modal fade" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingModalLabel">Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="/password/change" class="btn btn-primary w-100 mb-3">Change Password</a>
                    <a href="/password/forgot" class="btn btn-primary w-100 mb-3">Forgot Password</a>
                    <a href="/users/wallet/pin/change" class="btn btn-primary w-100">Change PIN Number</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php

    use Ewallet\Helper\FlashMessage;

    if(isset($_COOKIE['FLASH_MESSAGE_SUCCESS'])) { ?>
        <script>
            alert("OK");
            swal("Success!", '<?= FlashMessage::GetMessage() ?>', "success");
        </script>
    <?php } else if(isset($_COOKIE["FLASH_MESSAGE_ERROR"])) { ?>
        <script>
                swal("Error!", '<?= FlashMessage::GetMessage() ?>', "error");
        </script>
    <?php } ?>
    
    <script>

        let pinTopup = document.getElementById('pinTopup'); 
        let pinTransfer = document.getElementById('pinTransfer'); 

        let topupNominal = document.getElementById('topupNominal');
        let transferNominal = document.getElementById('transferNominal');

        let accountNumber = document.getElementById('accountNumber');

        let btnTransfer = document.getElementById('btnTransfer');
        let btnTopup = document.getElementById('btnTopup');

        let logoutBtn = document.getElementById('logoutBtn');

        pinTopup.addEventListener('keyup', function() {
            btnTopup.removeAttribute('disabled');
        });

        topupNominal.addEventListener('keyup', function() {
            btnTopup.removeAttribute('disabled');
        });


        pinTransfer.addEventListener('keyup', function() {
            btnTransfer.removeAttribute('disabled');
        });

        accountNumber.addEventListener('keyup', function() {
            btnTransfer.removeAttribute('disabled');
        });

        transferNominal.addEventListener('keyup', function() {
            btnTransfer.removeAttribute('disabled');
        });

        function pinSectionTransfer() {
            pinTransfer.classList.remove('d-none');
            transferNominal.classList.add('d-none');
            accountNumber.classList.add('d-none');

            btnTransfer.innerText = "Transfer";
            btnTransfer.removeAttribute('onclick');
            btnTransfer.setAttribute('type', 'submit');
            btnTransfer.setAttribute('disabled', true);
            
        }

        function pinSectionTopup() {
            pinTopup.classList.remove('d-none');
            topupNominal.classList.add('d-none');

            btnTopup.innerText = "Top Up";
            btnTopup.removeAttribute('onclick');
            btnTopup.setAttribute('type', 'submit');
            btnTopup.setAttribute('disabled', true);
        }

        function resetModalData() {
            pinTopup.classList.add('d-none');
            pinTopup.value = "";

            pinTransfer.classList.add('d-none');
            pinTransfer.value = "";

            topupNominal.classList.remove('d-none');
            topupNominal.value = "";

            transferNominal.classList.remove('d-none');
            transferNominal.value = "";

            accountNumber.classList.remove('d-none');
            accountNumber.value = "";

            btnTransfer.innerText = "Next";
            btnTransfer.setAttribute('onclick', 'pinSectionTransfer()');
            btnTransfer.setAttribute('type', 'button');
            btnTransfer.setAttribute('disabled', true);

            btnTopup.innerText = "Next";
            btnTopup.setAttribute('onclick', 'pinSectionTopup()');
            btnTopup.setAttribute('type', 'button');
            btnTopup.setAttribute('disabled', true);
        }

        function handleLogout() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                window.location.href = "/users/login";
                swal("Success!", 'Logout Successfully', "success");
            }
            xhttp.open("POST", "<?php \Ewallet\Config\App::$baseUrl ?>/users/logout");
            xhttp.send();
        }

    </script>


</html>