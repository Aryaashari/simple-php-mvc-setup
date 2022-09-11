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


    public function create(int $userId, string $ipAddress, string $userAgent) : Session {
        try {
            $dateNow = date("Y-m-d H:i:s", time());
            $expire = date("Y-m-d H:i:s", time()+300);
            $id = (int)microtime();
            $stmt = $this->db->prepare("INSERT INTO sessions(id,user_id, ip_address, user_agent, last_activated_time, expire_time, create_time) VALUES(?,?,?,?,?,?,?)");
            $stmt->execute([$id,$userId, $ipAddress, $userAgent, $dateNow,$expire,$dateNow]);

            return new Session($id, $userId, $ipAddress, $userAgent, $dateNow, $expire, $dateNow);
        } catch(\Exception $e) {
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