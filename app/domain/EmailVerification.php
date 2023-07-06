<?php 

namespace Ewallet\Domain;

class EmailVerification {

    public ?int $id;
    public ?string $username, $token, $email_type, $expire_time, $create_time;
    public ?bool $is_used;

    public function __construct(?int $id, ?string $username, ?string $token, ?string $email_type, ?string $expire_time, ?string $create_time, ?bool $is_used) {
        $this->id = $id;
        $this->username = $username;
        $this->token = $token;
        $this->expire_time = $expire_time;
        $this->create_time = $create_time;
        $this->is_used = $is_used;
    }

}