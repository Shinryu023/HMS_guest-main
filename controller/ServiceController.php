<?php
// ServiceController.php - Handles AJAX requests for hotel services
include_once __DIR__ . '/../database/DatabaseConnection.php';
include_once __DIR__ . '/../model/ServiceModel.php';

class ServiceController {
    private $model;
    public function __construct() {
        $db = (new DatabaseConnection())->connect();
        $this->model = new ServiceModel($db);
    }
    public function add($name, $price) { return $this->model->addService($name, $price); }
    public function all() { return $this->model->allServices(); }
    public function exists($name, $excludeId = null) { return $this->model->serviceExists($name, $excludeId); }
    public function update($id, $name, $price) { return $this->model->updateService($id, $name, $price); }
    public function delete($id) { return $this->model->deleteService($id); }
}

$controller = new ServiceController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        if ($name === '' || $price === '' || !is_numeric($price)) {
            echo json_encode(['success' => false, 'error' => 'Invalid input.']); exit;
        }
        if ($controller->exists($name)) {
            echo json_encode(['success' => false, 'error' => 'Service already exists.']); exit;
        }
        $result = $controller->add($name, $price);
        if ($result !== true) {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
        if($price < 0) {
            echo json_encode(['success' => false, 'error' => 'Price cannot be negative.']); exit;
        }
        echo json_encode(['success' => true, 'services' => $controller->all()]); exit;
    }
    if ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        if ($id <= 0 || $name === '' || $price === '' || !is_numeric($price)) {
            echo json_encode(['success' => false, 'error' => 'Invalid input.']); exit;
        }
        if ($controller->exists($name, $id)) {
            echo json_encode(['success' => false, 'error' => 'Service already exists.']); exit;
        }
        $result = $controller->update($id, $name, $price);
        if ($result !== true) {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
        if($price < 0) {
            echo json_encode(['success' => false, 'error' => 'Price cannot be negative.']); exit;
        }
        echo json_encode(['success' => true, 'services' => $controller->all()]); exit;
    }
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) $controller->delete($id);
        echo json_encode(['success' => true, 'services' => $controller->all()]); exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
    echo json_encode(['success' => true, 'services' => $controller->all()]); exit;
}
