<?php

namespace Ewallet\Model\Session;

class CreateSessionResponse {

    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}