<?php

namespace Ewallet\Domain;

class Session {

    public ?int $id;
    public ?string $username;
    public ?string $ip_address, $user_agent, $last_activated_at, $expire_time, $create_time;

    public function __construct(?int $id = null, ?string $username = null, ?string $ip_address = null, ?string $user_agent = null, ?string $last_activated_at = null, ?string $expire_time = null, ?string $create_time = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->ip_address = $ip_address;
        $this->user_agent = $user_agent;
        $this->last_activated_at = $last_activated_at;
        $this->expire_time = $expire_time;
        $this->create_time = $create_time;
    }

}