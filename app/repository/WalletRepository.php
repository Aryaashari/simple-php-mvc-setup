<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;
use Ewallet\Domain\Wallet;

class WalletRepository {


    private \PDO $db;


    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    public function create(Wallet $wallet) : Wallet {

        try {

            $dateNow = date('Y-m-d H:i:s', time());
            $wallet->create_time = $dateNow;
            $wallet->update_time = $dateNow;

            $stmt = $this->db->prepare('INSERT INTO wallets(user_id, balance, pin, create_time, update_time) VALUES(?,?,?,?,?)');
            $stmt->execute([$wallet->user_id, $wallet->balance, $wallet->pin, $wallet->create_time, $wallet->update_time]);

            $wallet->id = $this->db->lastInsertId();
            return $wallet;

        } catch(\Exception $e) {
            throw $e;
        }

    }


    public function deleteAll() : void {
        try {
            $this->db->query("DELETE FROM wallets");
            return;
        } catch(\Exception $e) {
            throw $e;
        }
    }


}