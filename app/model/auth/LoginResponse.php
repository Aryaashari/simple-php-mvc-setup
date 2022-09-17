<?php

namespace Ewallet\Model\Auth;

class LoginResponse {

    public string $jwt;

    public function __construct(string $jwt)
    {
        $this->jwt = $jwt;
    }

}