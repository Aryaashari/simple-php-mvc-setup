<?php

namespace Ewallet\Model\Auth;

class LogoutRequest {

    public string $sessionId;

    public function __construct(string $sesId)
    {
        $this->sessionId = $sesId;
    }

}