<?php

namespace Ewallet\Domain;

class History {

    public ?int $id, $wallet_id;
    public ?string $history_name, $history_category, $create_time;

    public function __construct(?int $id = null, ?int $wallet_id = null, ?string $history_name = null, ?string $history_category = null, ?string $create_time = null)
    {
        $this->id = $id;
        $this->wallet_id = $wallet_id;
        $this->history_name = $history_name;
        $this->history_category = $history_category;
        $this->create_time = $create_time;
    }

}