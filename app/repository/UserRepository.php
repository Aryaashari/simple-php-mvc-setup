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

    public function findByEmail(string $email) : ?User {
        try {

            $stmt = $this->db->prepare('SELECT * FROM users WHERE email=?');
            $stmt->execute([$email]);

            if($user = $stmt->fetch()) {
                return new User($user["id"], $user["name"], $user["email"], $user["username"], $user["password"], $user["profile_photo"], $user["email_verified"], $user["email_verified_time"], $user["create_time"], $user["update_time"]);
            }

            return null;

        } catch(\Exception $e) {
            throw $e;
        }
        
    }

    public function findByUsername(string $username) : ?User {

        try {

            $stmt = $this->db->prepare('SELECT * FROM users WHERE username=?');
            $stmt->execute([$username]);
    
            if($user = $stmt->fetch()) {
                return new User($user["id"], $user["name"], $user["email"], $user["username"], $user["password"], $user["profile_photo"], $user["email_verified"], $user["email_verified_time"], $user["create_time"], $user["update_time"]);
            }
    
            return null;
        } catch(\Exception $e) {
            throw $e;
        }
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


    public function deleteAll() : void {
        try {
            $stmt = $this->db->query('DELETE FROM users');
        } catch(\Exception $e) {
            throw $e;
        }
    }

}