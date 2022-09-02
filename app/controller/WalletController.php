<?php

namespace Ewallet\Controller;

use Ewallet\App\View;

class WalletController {


    public function changePinView() : void {
        View::render('/../view/wallet/change-pin.php');
    }


}