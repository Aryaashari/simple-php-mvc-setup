<?php

namespace Ewallet\Model\Session;

class CreateSessionRequest {

    public int $userId;
    public string $ipAddress, $userAgent;

    public function __construct(int $userId, string $ipAddress, string $userAgent)
    {
        $this->userId = $userId;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }
}