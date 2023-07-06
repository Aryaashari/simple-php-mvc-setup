<?php

namespace Ewallet\Domain;

class Wallet {

    public ?int $account_number, $pin;
    public ?string $username;
    public float  $balance;
    public ?string $create_time, $update_time;

    public function __construct(?int $account_number = null, ?string $username = null, float $balance = 0, ?int $pin = null, ?string $create_time = null, ?string $update_time = null)
    {
        $this->account_number = $account_number;
        $this->username = $username;
        $this->balance = $balance;
        $this->pin = $pin;
        $this->create_time = $create_time;
        $this->update_time = $update_time;
    }

}