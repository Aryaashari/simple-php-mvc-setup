<?php

namespace Ewallet\Model\Wallet;

use Ewallet\Domain\User;

class UpdatePinRequest {

    public string $oldPin, $newPin;
    public User $user; 

    public function __construct(User $user, string $oldPin, string $newPin) {
        $this->oldPin = $oldPin;
        $this->newPin = $newPin;
        $this->user = $user;
    }

}