<?php

namespace Ewallet\Domain;

class Wallet {

    public ?int $id, $user_id, $pin;
    public ?float  $balance;
    public ?string $create_time, $update_time;

    public function __construct(?int $id = null, ?int $user_id = null, ?float $balance = null, ?int $pin = null, ?string $create_time = null, ?string $update_time = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->balance = $balance;
        $this->pin = $pin;
        $this->create_time = $create_time;
        $this->update_time = $update_time;
    }

}