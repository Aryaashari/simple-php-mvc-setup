<?php

namespace Ewallet\Domain;

class History {

    public ?int $id, $origin_account, $dest_account;
    public ?float $nominal;
    public ?string $history_name, $history_category, $history_type, $create_time;

    public function __construct(?int $id = null, ?int $origin_account = null, ?int $dest_account = null, ?float $nominal = null, ?string $history_name = null, ?string $history_type, ?string $history_category = null, ?string $create_time = null)
    {
        $this->id = $id;
        $this->origin_account = $origin_account;
        $this->dest_account = $dest_account;
        $this->nominal = $nominal;
        $this->history_name = $history_name;
        $this->history_type = $history_type;
        $this->history_category = $history_category;
        $this->create_time = $create_time;
    }

}