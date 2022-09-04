<?php

namespace Ewallet\Model\Auth;

class RegisterRequest {


    public ?string $name, $email, $username, $password, $confirmPassword;
    public ?string $pin;


    public function __construct(?string $name, ?string $email, ?string $username, ?string $password, ?string $confirmPassword, ?string $pin,)
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
        $this->pin = $pin;
    }


}