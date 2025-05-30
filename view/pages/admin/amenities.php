<link rel="stylesheet" href="../assets/css/amenities.css">
<div class="main-header">
    <p>Amenities</p>
    <button class="add-btn">Add Category</button>
</div>
<div class="main-content">
    <div class="amenities">

    </div>
</div>

<!-- Add Category Modal -->
<div class="amenity-modal" id="amenity-modal">
  <form class="amenity-modal-form" id="add-amenity-form" autocomplete="off" onsubmit="return false;">
    <div class="amenity-modal-header">
        <p>Add New Category</p>
    </div>
    <div class="amenity-modal-body">
        <input type="text" class="amenity-category-input input" id="modal-category-name" placeholder="Category Name" required />
        <div class="amenity-modal-amenity-list-container">
            <div class="amenity-modal-amenity-list-header">
                <p>Amenities</p>
            </div>
            <div class="amenity-modal-add-amenity-container">
                <input type="text" class="amenity-amenity-input input" id="modal-amenity-name" placeholder="Amenity Name" />
                <button type="button" class="amenity-add-amenity-btn">Add Amenity</button>
            </div>
            <div class="amenity-modal-amenity-list">
                <!-- Amenities will be dynamically added here -->
            </div>
        </div>
    </div>
    <div class="amenity-modal-footer">
        <button id="modal-submit-amenity" class="amenity-modal-submit-btn" type="submit">Add</button>
        <button id="modal-cancel-amenity" class="amenity-modal-cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<!-- Edit Category Modal -->
<div class="amenity-modal" id="edit-amenity-modal">
  <form class="amenity-modal-form" id="edit-amenity-form" autocomplete="off" onsubmit="return false;">
    <div class="amenity-modal-header">
        <p>Edit Category</p>
    </div>
    <div class="amenity-modal-body">
        <input type="text" class="amenity-category-input input" id="edit-modal-category-name" placeholder="Category Name" required />
        <div class="amenity-modal-amenity-list-container">
            <div class="amenity-modal-amenity-list-header">
                <p>Amenities</p>
            </div>
            <div class="amenity-modal-add-amenity-container">
                <input type="text" class="amenity-amenity-input input" id="edit-modal-amenity-name" placeholder="Amenity Name" />
                <button type="button" class="edit-amenity-add-amenity-btn">Add Amenity</button>
            </div>
            <div class="edit-amenity-modal-amenity-list">
                <!-- Amenities will be dynamically added here -->
            </div>
        </div>
    </div>
    <div class="amenity-modal-footer">
        <button id="edit-modal-submit-amenity" class="amenity-modal-submit-btn" type="submit">Save</button>
        <button id="edit-modal-cancel-amenity" class="amenity-modal-cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<!-- Delete Category Modal -->
<div class="amenity-modal" id="delete-category-modal">
  <form class="amenity-modal-form" id="delete-category-form" autocomplete="off" onsubmit="return false;">
    <div class="amenity-modal-header">
        <p>Delete Category</p>
    </div>
    <div class="amenity-modal-body">
        <p id="delete-category-question" style="margin:0 0 10px 0; text-align:center;">Are you sure you want to delete this category?</p>
    </div>
    <div class="amenity-modal-footer">
        <button id="confirm-delete-category" class="amenity-modal-submit-btn" type="submit" style="background:#ff5429;">Delete</button>
        <button id="cancel-delete-category" class="amenity-modal-cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>


<script src="../../assets/js/amenity.js"></script>
</body>
</html>