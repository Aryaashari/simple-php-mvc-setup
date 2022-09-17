<?php

namespace Ewallet\Model\Auth;

class LoginRequest {

    public string $username, $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

}