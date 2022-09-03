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

    public function create(User $user) : User {

        try {
            $dateNow = date("Y-m-d H:i:s", time());

            $user->create_time = $dateNow;
            $user->update_time = $dateNow;
            
            $stmt = $this->db->prepare('INSERT INTO users(name,email,username,password,profile_photo,email_verified,email_verified_time,create_time, update_time) VALUES (?,?,?,?,?,?,?,?,?)');
            $stmt->execute([$user->name, $user->email, $user->username, $user->password, $user->profile_photo, $user->email_verified, $user->email_verified_time, $user->create_time, $user->update_time]);
    
            $user->id = $this->db->lastInsertId();
    
            return $user;
        } catch(\Exception $e) {
            throw $e;
        }

    }

}