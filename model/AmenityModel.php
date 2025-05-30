<?php
// AmenityModel.php - Handles all database operations for amenity categories only (for now)
class AmenityModel {
    private $db;
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
    // Add a new amenity category
    public function addCategory($name, $amenities = []) {
        $stmt = $this->db->prepare("INSERT INTO amenity_category (category_name) VALUES (?)");
        $stmt->execute([$name]);

        // Get the ID of the recently added category
        $categoryId = $this->db->lastInsertId();

        // Add amenities to the newly created category
        if (!empty($amenities)) {
            $this->addAmenities($categoryId, $amenities);
        }

        return true;
    }
    // Check if a category already exists
    public function categoryExists($name) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM amenity_category WHERE category_name = ?");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() > 0;
    }
    // Get all amenity categories
    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM amenity_category ORDER BY category_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Delete a category by ID
    public function deleteCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM amenity_category WHERE category_id = ?");
        return $stmt->execute([$id]);
    }
    // Add a new amenity to a category
    public function addAmenity($categoryId, $amenityName) {
        $stmt = $this->db->prepare("INSERT INTO amenities (category_id, amenity_name) VALUES (?, ?)");
        $stmt->execute([$categoryId, $amenityName]);
        return true;
    }
    // Add multiple amenities to a category
    public function addAmenities($categoryId, $amenities) {
        $stmt = $this->db->prepare("INSERT INTO amenities (category_id, amenity_name) VALUES (?, ?)");
        foreach ($amenities as $amenityName) {
            $stmt->execute([$categoryId, $amenityName]);
        }
        return true;
    }
    // Get all amenities for a specific category
    public function getAmenitiesByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM amenities WHERE category_id = ? ORDER BY amenity_name ASC");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get all categories with their associated amenities
    public function getAllCategoriesWithAmenities() {
        $categories = $this->getAllCategories();
        foreach ($categories as &$category) {
            $category['amenities'] = $this->getAmenitiesByCategory($category['category_id']);
        }
        return $categories;
    }
    // Expose the categories-with-amenities method for the controller
    public function allWithAmenities() {
        return $this->getAllCategoriesWithAmenities();
    }
    // Update a category's name and amenities
    public function updateCategory($categoryId, $name, $amenities = []) {
        // Update category name
        $stmt = $this->db->prepare("UPDATE amenity_category SET category_name = ? WHERE category_id = ?");
        $stmt->execute([$name, $categoryId]);
        // Remove old amenities
        $stmt = $this->db->prepare("DELETE FROM amenities WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        // Add new amenities
        if (!empty($amenities)) {
            $this->addAmenities($categoryId, $amenities);
        }
        return true;
    }
}
