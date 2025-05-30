<?php
// ServiceModel.php - Handles all database operations for hotel services
class ServiceModel {
    private $db;
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    public function addService($name, $price) {
        if ($price < 0) return 'Price cannot be negative.';
        $stmt = $this->db->prepare("INSERT INTO services (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
        return true;
    }
    public function allServices() {
        return $this->db->query("SELECT * FROM services ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function serviceExists($name, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM services WHERE name = ?";
        $params = [$name];
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    public function updateService($id, $name, $price) {
        if ($price < 0) return 'Price cannot be negative.';
        $stmt = $this->db->prepare("UPDATE services SET name=?, price=? WHERE id=?");
        $stmt->execute([$name, $price, $id]);
        return true;
    }
    public function deleteService($id) {
        $stmt = $this->db->prepare("DELETE FROM services WHERE id=?");
        return $stmt->execute([$id]);
    }
}
