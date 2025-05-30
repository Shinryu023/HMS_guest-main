<?php

class RestaurantModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function addCategories($categories = []) {
        // Get current categories from DB
        $stmt = $this->db->query("SELECT category_id, category_name FROM menu_category");
        $existing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $existingNames = array_map(function($cat) { return $cat['category_name']; }, $existing);

        // Delete categories that are not in the new list
        foreach ($existing as $cat) {
            if (!in_array($cat['category_name'], $categories)) {
                $del = $this->db->prepare("DELETE FROM menu_category WHERE category_id = ?");
                $del->execute([$cat['category_id']]);
            }
        }

        // Add new categories that don't exist
        foreach ($categories as $catName) {
            if (!in_array($catName, $existingNames)) {
                $ins = $this->db->prepare("INSERT INTO menu_category (category_name) VALUES (?)");
                $ins->execute([$catName]);
            }
        }
        return true;
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM menu_category ORDER BY category_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isMenuNameDuplicate($name) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM menu WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }

    public function addMenu($menu) {
        // Ensure keys exist and are nullable
        $category_id = isset($menu['category_id']) && $menu['category_id'] !== '' ? $menu['category_id'] : null;
        $image = isset($menu['image']) && $menu['image'] !== '' ? $menu['image'] : null;
        $name = $menu['name'];
        $price = $menu['price'];
        $status = $menu['status'];
        if ($this->isMenuNameDuplicate($name)) {
            return 'Menu already added.';
        }
        $stmt = $this->db->prepare("INSERT INTO menu (category_id, name, price, image, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $category_id,
            $name,
            $price,
            $image,
            $status
        ]);
    }

    public function getAllMenu() {
        $stmt = $this->db->query("SELECT m.*, c.category_name FROM menu m LEFT JOIN menu_category c ON m.category_id = c.category_id ORDER BY m.menu_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMenuByCategory($category_id = null) {
        if ($category_id === null || $category_id === '' || $category_id === 'all') {
            return $this->getAllMenu();
        }
        $stmt = $this->db->prepare("SELECT m.*, c.category_name FROM menu m LEFT JOIN menu_category c ON m.category_id = c.category_id WHERE m.category_id = ? ORDER BY m.menu_id DESC");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMenu($menu_id) {
        $stmt = $this->db->prepare('DELETE FROM menu WHERE menu_id = ?');
        if ($stmt->execute([$menu_id])) {
            return true;
        } else {
            return $stmt->errorInfo()[2] ?? false;
        }
    }

    public function editMenu($menu) {
        $menu_id = $menu['menu_id'];
        $name = $menu['name'];
        $price = $menu['price'];
        $status = $menu['status'];
        $category_id = isset($menu['category_id']) && $menu['category_id'] !== '' ? $menu['category_id'] : null;
        $image = isset($menu['image']) && $menu['image'] !== '' ? $menu['image'] : null;
        // Prevent duplicate name (except for this menu)
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM menu WHERE name = ? AND menu_id != ?");
        $stmt->execute([$name, $menu_id]);
        if ($stmt->fetchColumn() > 0) {
            return 'Menu already exists.';
        }
        // Build update query
        $sql = "UPDATE menu SET name = ?, price = ?, status = ?, category_id = ?";
        $params = [$name, $price, $status, $category_id];
        if ($image !== null) {
            $sql .= ", image = ?";
            $params[] = $image;
        }
        $sql .= " WHERE menu_id = ?";
        $params[] = $menu_id;
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($params)) {
            return true;
        } else {
            return $stmt->errorInfo()[2] ?? false;
        }
    }
}

?>