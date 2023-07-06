<?php 

namespace Ewallet\Model\Wallet;

use Ewallet\Domain\User;

class TransferRequest {

    public string $dest_account, $pin, $nominal;
    public User $user;

    public function __construct(User $user, string $dest_account, string $pin, string $nominal) {
        $this->user = $user;
        $this->dest_account = $dest_account;
        $this->pin = $pin;
        $this->nominal = $nominal;
    }

}