<?php
class DatabaseConnection {
    private $host = 'localhost';
    private $db_name = 'hotel_db'; // Change to your actual DB name
    private $username = 'root'; // Change if needed
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection Error: ' . $e->getMessage());
        }
        return $this->conn;
    }
}
