<?php

namespace Ewallet\Domain;

class Wallet {

    public ?int $id, $user_id, $balance, $pin;
    public ?string $create_time, $update_time;

    public function __construct(?int $id = null, ?int $user_id = null, ?int $balance = null, ?int $pin = null, ?string $create_time = null, ?string $update_time = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->balance = $balance;
        $this->pin = $pin;
        $this->create_time = $create_time;
        $this->update_time = $update_time;
    }

}