<?php

namespace Ewallet\Model\Wallet;

use Ewallet\Domain\User;

class TopupRequest{


    public string $nominal, $pin;
    public User $user; 

    public function __construct(user $user, string $nominal, string $pin) {
        $this->nominal = $nominal;
        $this->pin = $pin;
        $this->user = $user;
    }


}