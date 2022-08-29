<?php

namespace Ewallet\Domain;

class Session {

    public ?int $id, $user_id;
    public ?string $ip_address, $user_agent, $last_activated_time, $expire_time, $create_time;

    public function __construct(?int $id = null, ?int $user_id = null, ?string $ip_address = null, ?string $user_agent = null, ?string $last_activated_time = null, ?string $expire_time = null, ?string $create_time = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->ip_address = $ip_address;
        $this->user_agent = $user_agent;
        $this->last_activated_time = $last_activated_time;
        $this->expire_time = $expire_time;
        $this->create_time = $create_time;
    }

}