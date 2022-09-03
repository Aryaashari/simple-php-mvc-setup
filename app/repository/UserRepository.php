<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;
use Ewallet\Domain\User;

class UserRepository {

    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // public function create(User $user) : User {

    // }

}