<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;
use Ewallet\Domain\EmailVerification;

class EmailVerificationRepository {


    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    public function findByUsername(string $username, string $type) : array {
        try {
            $stmt = $this->db->prepare('SELECT id,username,token, email_type, is_used, expire_time, create_time FROM email_verifications WHERE username=? AND email_type=? AND is_used=false');
            $stmt->execute([$username, $type]);

            $emails = [];
            while ($data = $stmt->fetch()) {
                $data = new EmailVerification($data["id"], $data["username"], $data["token"], $data["email_type"], $data["expire_time"], $data["create_time"], $data["is_used"]);
                $emails[] = $data;
            }

            return $emails;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function findByToken(string $token,  $type) : ?EmailVerification {
        try {
            $stmt = $this->db->prepare('SELECT id,username,token, email_type, is_used, expire_time, create_time FROM email_verifications WHERE token=? AND email_type=? AND is_used=false');
            $stmt->execute([$token, $type]);

            if ($data = $stmt->fetch()) {
                return new EmailVerification($data["id"], $data["username"], $data["token"], $data["email_type"], $data["expire_time"], $data["create_time"], $data["is_used"]);
            }

            return null;
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function deleteByUsername(string $username) :void {
        try {
            $stmt = $this->db->prepare("DELETE FROM email_verifications WHERE username=?");
            $stmt->execute([$username]);
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function create(string $username, string $type) :string {

        try {

            $token = time() . $username;
            $token = password_hash($token, PASSWORD_BCRYPT);

            $dateNow = date('Y-m-d H:i:s', time());
            $expire = date('Y-m-d H:i:s', time() + (60*60));
            $stmt = $this->db->prepare('INSERT INTO email_verifications(username,token,email_type,is_used,expire_time,create_time) VALUES (?,?,?,?,?,?)');
            $stmt->execute([$username, $token, $type, false, $expire, $dateNow]);

            return $token;

        } catch(\Exception $e) {
            throw $e;
        }

    }

    public function update(string $token) : void {
        try {

            $stmt = $this->db->prepare("UPDATE email_verifications SET is_used=true WHERE token=?");
            $stmt->execute([$token]);

        } catch (\Exception $e) {
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