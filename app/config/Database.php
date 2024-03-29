<?php

namespace Ewallet\Config;

class Database {

    private static ?\PDO $db = null;

    private static function getConfig(string $dbType, string $env) : array {

        $config = [
            "mysql" => [
                "test" => [
                    "type" => "mysql",
                    "host" => "localhost",
                    "port" => "3306",
                    "dbname" => "e_wallet_test",
                    "username" => "root",
                    "password" => ""
                ],
                "production" => [
                    "type" => "mysql",
                    "host" => "localhost",
                    "port" => "3306",
                    "dbname" => "e_wallet",
                    "username" => "root",
                    "password" => ""
                ]
            ]
        ];

        return $config[$dbType][$env];

    } 

    public static function getConnection(string $dbType = "mysql", string $env = "test") : \PDO {

        // Cek tipe database
        if ($dbType == "mysql") {
            // Cek apakah variabel $db null atau bukan objek pdo mysql
            if (self::$db == null) {
                $config = self::getConfig($dbType, $env);
                $dsn = "{$config['type']}:host={$config['host']}:{$config['port']};dbname={$config['dbname']}";
                $username = $config["username"];
                $password = $config["password"];
                self::$db = new \PDO($dsn, $username, $password);
            }
        }

        return self::$db;

    }

    public static function startTransaction() : void {
        self::$db->beginTransaction();
    }

    public static function commitTransaction() : void {
        self::$db->commit();
    }

    public static function rollbackTransaction() : void {
        self::$db->rollBack();
    }

}

