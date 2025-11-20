<?php
require_once __DIR__ . '/../config/database.php';

class Database {
    private $conn;
    private $config;

    public function __construct() {
        $this->config = (new DatabaseConfig())->getConfig();
        $this->connect();
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['db_name']};charset={$this->config['charset']}";
            $this->conn = new PDO($dsn, $this->config['username'], $this->config['password']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>