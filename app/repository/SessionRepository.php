<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;
use Ewallet\Domain\Session;

class SessionRepository {

    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    public function findById(int $id) : ?Session {
        try {
            $stmt = $this->db->prepare("SELECT id,user_id, ip_address, user_agent, last_activated_time, expire_time, create_time FROM sessions WHERE id=?");
            $stmt->execute([$id]);
            if ($session = $stmt->fetch()) {
                return new Session($session["id"], $session["user_id"], $session["ip_address"], $session["user_agent"], $session["last_activated_time"], $session["expire_time"], $session["create_time"]);
            }
            return null;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function create(int $userId, string $ipAddress, string $userAgent) : Session {
        try {
            $dateNow = date("Y-m-d H:i:s", time());
            $expire = date("Y-m-d H:i:s", time()+120);
            $id = rand(100,9999) + time();
            $stmt = $this->db->prepare("INSERT INTO sessions(id,user_id, ip_address, user_agent, last_activated_time, expire_time, create_time) VALUES(?,?,?,?,?,?,?)");
            $stmt->execute([$id,$userId, $ipAddress, $userAgent, $dateNow,$expire,$dateNow]);

            return new Session($id, $userId, $ipAddress, $userAgent, $dateNow, $expire, $dateNow);
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function update(Session $session) : Session {
        try {
            $stmt = $this->db->prepare("UPDATE sessions SET last_activated_time = ?, expire_time = ? WHERE id=?");
            $stmt->execute([$session->last_activated_time, $session->expire_time, $session->id]);
            return $session;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function delete(int $sessionId) : void {
        try {
            $stmt = $this->db->prepare("DELETE FROM sessions WHERE id=?");
            $stmt->execute([$sessionId]);
            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function deleteAll() : void {
        try {
            $stmt = $this->db->query('DELETE FROM sessions');
        } catch(\Exception $e) {
            throw $e;
        }
    }

}