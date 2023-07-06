<?php

namespace Ewallet\Model\Session;

class CreateSessionRequest {

    public string $username;
    public string $ipAddress, $userAgent;

    public function __construct(string $username, string $ipAddress, string $userAgent)
    {
        $this->username = $username;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }
}