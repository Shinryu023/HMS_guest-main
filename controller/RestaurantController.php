<?php

include_once __DIR__ . '/../database/DatabaseConnection.php';
include_once __DIR__ . '/../model/RestaurantModel.php';

class RestaurantController {
    private $model;
    public function __construct() {
        $db = (new DatabaseConnection())->connect();
        $this->model = new RestaurantModel($db);
    }

    public function add($categories = []) {
        return $this->model->addCategories($categories);
    }

    public function getAllCategories() {
        return $this->model->getAllCategories();
    }

    public function addMenu($menu) {
        return $this->model->addMenu($menu);
    }

    public function getAllMenu() {
        return $this->model->getAllMenu();
    }

    public function getMenuByCategory($categoryId) {
        return $this->model->getMenuByCategory($categoryId);
    }

    public function deleteMenu($menu_id) {
        return $this->model->deleteMenu($menu_id);
    }

    public function editMenu($menu) {
        return $this->model->editMenu($menu);
    }
}

$controller = new RestaurantController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $categories = [];
    if (isset($_POST['categories'])) {
        $categories = json_decode($_POST['categories'], true);
    } else {
        // Try JSON body
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        if (isset($data['categories'])) {
            $categories = $data['categories'];
        }
    }
    if ($action === 'saveCategories') {
        $result = $controller->add($categories);
        if ($result !== true) {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
        echo json_encode(['success' => true]); exit;
    }
    if ($action === 'addMenu') {
        $menu = $_POST;
        // Handle file upload if present
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../resources/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = uniqid('menu_') . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $menu['image'] = 'resources/images/' . $filename;
            } else {
                $menu['image'] = null;
            }
        } else {
            $menu['image'] = null;
        }
        // Make category_id optional
        if (!isset($menu['category_id']) || $menu['category_id'] === '') {
            $menu['category_id'] = null;
        }
        $result = $controller->addMenu($menu);
        if ($result === true) {
            echo json_encode(['success' => true]); exit;
        } else {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
    }
    if ($action === 'deleteMenu') {
        $menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : 0;
        if ($menu_id > 0) {
            $result = $controller->deleteMenu($menu_id);
            if ($result === true) {
                echo json_encode(['success' => true]); exit;
            } else {
                echo json_encode(['success' => false, 'error' => $result ?: 'Failed to delete menu.']); exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid menu ID.']); exit;
        }
    }
    if ($action === 'editMenu') {
        $menu = $_POST;
        // Handle file upload if present
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../resources/images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = uniqid('menu_') . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $menu['image'] = 'resources/images/' . $filename;
            } else {
                $menu['image'] = null;
            }
        } else if (isset($_POST['image']) && $_POST['image'] !== '') {
            // No new file uploaded, but old image path is present in POST
            $menu['image'] = $_POST['image'];
        } else {
            // No new file and no old image path, set to null
            $menu['image'] = null;
        }
        // Make category_id optional
        if (!isset($menu['category_id']) || $menu['category_id'] === '') {
            $menu['category_id'] = null;
        }
        $result = $controller->editMenu($menu);
        if ($result === true) {
            echo json_encode(['success' => true]); exit;
        } else {
            echo json_encode(['success' => false, 'error' => $result]); exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'list') {
        $categories = $controller->getAllCategories();
        echo json_encode(['success' => true, 'categories' => $categories]); exit;
    }
    if ($_GET['action'] === 'getMenu') {
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
        if ($category_id === 'all' || $category_id === null || $category_id === '') {
            $menu = $controller->getAllMenu();
        } else {
            $menu = $controller->getMenuByCategory($category_id);
        }
        echo json_encode(['success' => true, 'menu' => $menu]); exit;
    }
}

?>