<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;

class EmailVerificationRepository {


    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    public function create(int $userId) :string {

        try {

            $token = time() . $userId;
            $token = password_hash($token, PASSWORD_BCRYPT);

            $stmt = $this->db->prepare('INSERT INTO email_verifications(user_id,token,create_time) VALUES (?,?,?)');
            $stmt->execute([$userId, $token, date('Y-m-d H:i:s', time())]);

            return $token;

        } catch(\Exception $e) {
            throw $e;
        }

    }


    public function deleteAll() : void {
        try {
            $this->db->query('DELETE FROM email_verifications');
        } catch(\Exception $e) {
            throw $e;
        }
    }


}