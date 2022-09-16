<?php
namespace PapayaWithSugar;

use PDO;

class DatabaseConnectionFactory {
    private static $dbConnection;

    private function __construct(){}

    public static function getDbConnection() {
        if(is_null(self::$dbConnection)) {
            $config = include('../config/database.config.php');
            self::$dbConnection = new PDO(
                'mysql:host='. $config['host'] . ';dbname=' . $config['database'],
                $config['user'], $config['password']);
        }
        return self::$dbConnection;
    }
}