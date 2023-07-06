<?php

namespace Ewallet\Repository;

use Ewallet\Config\Database;
use Ewallet\Domain\History;

class HistoryRepository {

    private \PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }


    public function findAll() : array {

        try {

            $stmt = $this->db->query("SELECT id, origin_account, dest_account, nominal, history_name, history_category, history_type, create_time FROM histories");

            $histories = [];
            while ($history = $stmt->fetch()) {
                $histories[] = new History($history["id"], $history["origin_account"], $history["dest_account"], $history["nominal"], $history["history_name"], $history["history_category"], $history["history_type"], $history["create_time"]);
            }

            return $histories;
        } catch (\Exception $e) {
            throw $e;
        }

    }

    public function findById(int $id) : ?History {
        try {

            $stmt = $this->db->prepare("SELECT id, origin_account, dest_account, nominal, history_name, history_category, history_type, create_time FROM histories WHERE id=?");
            $stmt->execute([$id]);

            if ($history = $stmt->fetch()) {
                return new History($history["id"], $history["origin_account"], $history["origin_account"], $history["nominal"], $history["history_name"], $history["history_category"], $history["history_type"], $history["create_time"]);
            }

            return null;

        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function findByAccountNumber(int $accountNumber) : array {
        try {

            $stmt = $this->db->prepare("SELECT id, origin_account, dest_account, nominal, history_name, history_category, history_type, create_time FROM histories WHERE origin_account=?");
            $stmt->execute([$accountNumber]);

            $histories = [];
            while ($history = $stmt->fetch()) {
                $histories[] = new History($history["id"], $history["origin_account"], $history["dest_account"], $history["nominal"], $history["history_name"], $history["history_category"], $history["history_type"], $history["create_time"]);
            }

            return $histories;

        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function create(History $history) : History {

        try {
            $dateNow = date("Y-m-d H:i:s", time());
            $stmt = $this->db->prepare("INSERT INTO histories(origin_account, dest_account, nominal, history_name, history_category, history_type, create_time) VALUES(?,?,?,?,?,?,?)");
            $stmt->execute([$history->origin_account, $history->dest_account, $history->nominal, $history->history_name, $history->history_category, $history->history_type, $dateNow]);

            $id = $this->db->lastInsertId();
            $history->id = $id;

            return $history;

        } catch (\Exception $e) {
            throw $e;
        }

    }

}