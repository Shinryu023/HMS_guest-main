<?php
// AmenityController.php - Handles AJAX requests for amenity categories only
include_once __DIR__ . '/../database/DatabaseConnection.php';
include_once __DIR__ . '/../model/AmenityModel.php';

class AmenityController {
    private $model;
    public function __construct() {
        $db = (new DatabaseConnection())->connect();
        $this->model = new AmenityModel($db);
    }
    public function add($name, $amenities = []) {
        return $this->model->addCategory($name, $amenities);
    }
    public function exists($name) { return $this->model->categoryExists($name); }
    public function all() {
        return $this->model->getAllCategories();
    }
    public function allWithAmenities() {
        return $this->model->allWithAmenities();
    }
    public function delete($id) {
        return $this->model->deleteCategory($id);
    }
    public function edit($id, $name, $amenities = []) {
        return $this->model->updateCategory($id, $name, $amenities);
    }
}

$controller = new AmenityController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $amenities = json_decode($_POST['amenities'] ?? '[]', true); // Decode amenities array

        if ($name === '') {
            echo json_encode(['success' => false, 'error' => 'Category name cannot be empty.']); exit;
        }
        if ($controller->exists($name)) {
            echo json_encode(['success' => false, 'error' => 'Category already exists.']); exit;
        }
        $result = $controller->add($name, $amenities); // Pass amenities to the add method
        if ($result !== true) {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
        echo json_encode(['success' => true]); exit;
    }
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            $result = $controller->delete($id);
            if ($result !== true) {
                echo json_encode(['success' => false, 'error' => $result]); exit;
            }
            echo json_encode(['success' => true, 'categories' => $controller->all()]); exit;
        }
        echo json_encode(['success' => false, 'error' => 'Invalid category ID.']); exit;
    }
    if (
        $action === 'edit'
    ) {
        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $amenities = json_decode($_POST['amenities'] ?? '[]', true);
        if ($id <= 0 || $name === '') {
            echo json_encode(['success' => false, 'error' => 'Invalid category or name.']); exit;
        }
        // Check for duplicate name (excluding current category)
        $categories = $controller->all();
        foreach ($categories as $cat) {
            if ($cat['category_id'] != $id && strtolower($cat['category_name']) === strtolower($name)) {
                echo json_encode(['success' => false, 'error' => 'Category name already exists.']); exit;
            }
        }
        $result = $controller->edit($id, $name, $amenities);
        if ($result !== true) {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
        echo json_encode(['success' => true]); exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
    $categories = $controller->allWithAmenities();
    echo json_encode(['success' => true, 'categories' => $categories]); exit;
}