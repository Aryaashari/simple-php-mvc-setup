<?php

namespace Ewallet\Domain;

class User {

    public ?int $id;
    public ?string $name, $email, $username, $password, $profile_photo;
    public ?bool $email_verified;
    public ?string $email_verified_time, $create_time, $update_time;
    
    public function __construct(?int $id = null, ?string $name = null, ?string $email = null, ?string $username = null, ?string $password = null, ?string $profile_photo = null, ?bool $email_verified = null, ?string $email_verified_time = null, ?string $create_time = null, ?string $update_time = null)
    {

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->profile_photo = $profile_photo;
        $this->email_verified = $email_verified;
        $this->email_verified_time = $email_verified_time;
        $this->create_time = $create_time;
        $this->update_time = $update_time;
        
    }

}