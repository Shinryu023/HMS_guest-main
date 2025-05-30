<link rel="stylesheet" href="../assets/css/restaurant.css">
<link rel="stylesheet" href="../view/components/menu_card.css">

<div class="main-header">
    <p>Restaurant</p>
    <button class="add-menu-btn">Add Menu</button>
</div>
<div class="main-content">
    <div class="header">
        <div class="categories">
            <!-- Categories will be dynamically added here -->
        </div>
        <button class="edit-cat-btn">Edit Categories</button>
    </div>
    <div class="menu-list" id="menu-list">
        <!-- Menu cards will be dynamically inserted here -->
    </div>
</div>

<!-- Add Category Modal -->
<div class="menu-cat-modal" id="menu-cat-modal">
  <form class="menu-cat-modal-form" id="menu-cat-amenity-form" autocomplete="off" onsubmit="return false;">
    <div class="menu-cat-modal-header">
        <p>Categories</p>
    </div>
    <div class="menu-cat-modal-body">
        <input type="text" class="menu-cat-input input" id="menu-cat-name" placeholder="Category Name" />
        <button type="button" class="menu-cat-add-btn">Add Category</button>
    </div>
    <div class="menu-cat-modal-category-list">
        <!-- Categories will be dynamically added here -->
    </div>
    <div class="menu-cat-modal-footer">
        <button id="modal-submit-edit-cat" class="menu-cat-modal-submit-btn" type="submit">Save</button>
        <button id="modal-cancel-edit-cat" class="menu-cat-modal-cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<!-- Add Menu Modal -->
<div class="add-menu-modal" id="add-menu-modal">
    <form class="add-menu-modal-form" id="add-menu-modal-form" autocomplete="off" onsubmit="return false;">
        <div class="add-menu-modal-header">
            <p>Add Menu</p>
        </div>
        <div class="add-menu-modal-body">
            <input type="text" class="add-menu-input input" id="menu-name" placeholder="Menu Name" />
            <input type="number" class="add-menu-input input" id="menu-price" placeholder="Price" step="0.01" min="0" inputmode="decimal" />
            <select class="add-menu-select input" id="menu-category">
                <!-- Categories will be dynamically added here -->
            </select>
            <div class="add-menu-file-row">
                <button type="button" class="add-menu-file-btn" onclick="document.getElementById('menu-image').click();return false;">Choose File</button>
                <input type="file" class="add-menu-file-input" id="menu-image" accept="image/*" style="display:inline-block;" />
            </div>
            <div class="add-menu-status-row">
                <label class="add-menu-status-label">Status</label>
                <div class="add-menu-status-checkboxes">
                    <label><input type="checkbox" id="status-available" name="menu-status" value="available" checked onchange="if(this.checked) document.getElementById('status-unavailable').checked=false;"> Available</label>
                    <label><input type="checkbox" id="status-unavailable" name="menu-status" value="not available" onchange="if(this.checked) document.getElementById('status-available').checked=false;"> Unavailable</label>
                </div>
            </div>
        </div>
        <div class="add-menu-modal-footer">
            <button id="modal-submit-add-menu" class="add-menu-modal-submit-btn" type="submit">Add Menu</button>
            <button id="modal-cancel-add-menu" class="add-menu-modal-cancel-btn" type="button">Cancel</button>
        </div>

    </form>
</div>

<div class="menu-delete-modal" id="delete-menu-modal">
  <form class="menu-delete-modal-form" id="delete-menu-form" autocomplete="off" onsubmit="return false;">
    <div class="menu-delete-modal-header">
        <p>Delete Menu</p>
    </div>
    <div class="menu-delete-modal-body">
        <p id="delete-menu-question" style="margin:0 0 10px 0; text-align:center;">Are you sure you want to delete this menu item?</p>
    </div>
    <div class="menu-delete-modal-footer">
        <button id="confirm-delete-menu" class="menu-delete-modal-submit-btn" type="submit" style="background:#ff5429;">Delete</button>
        <button id="cancel-delete-menu" class="menu-delete-modal-cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<!-- Edit Menu Modal -->
<div class="edit-menu-modal" id="edit-menu-modal">
    <form class="edit-menu-modal-form" id="edit-menu-modal-form" autocomplete="off" onsubmit="return false;">
        <div class="edit-menu-modal-header">
            <p>Edit Menu</p>
        </div>
        <div class="edit-menu-modal-body">
            <input type="hidden" id="edit-menu-id" />
            <input type="text" class="edit-menu-input input" id="edit-menu-name" placeholder="Menu Name" />
            <input type="number" class="edit-menu-input input" id="edit-menu-price" placeholder="Price" step="0.01" min="0" inputmode="decimal" />
            <select class="edit-menu-select input" id="edit-menu-category">
                <!-- Categories will be dynamically added here -->
            </select>
            <div class="edit-menu-file-row">
                <button type="button" class="edit-menu-file-btn" onclick="document.getElementById('edit-menu-image').click();return false;">Choose File</button>
                <input type="file" class="edit-menu-file-input" id="edit-menu-image" accept="image/*" style="display:inline-block;" />
            </div>
            <div class="edit-menu-status-row">
                <label class="edit-menu-status-label">Status</label>
                <div class="edit-menu-status-checkboxes">
                    <label><input type="checkbox" id="edit-status-available" name="edit-menu-status" value="available" checked onchange="if(this.checked) document.getElementById('edit-status-unavailable').checked=false;"> Available</label>
                    <label><input type="checkbox" id="edit-status-unavailable" name="edit-menu-status" value="not available" onchange="if(this.checked) document.getElementById('edit-status-available').checked=false;"> Unavailable</label>
                </div>
            </div>
        </div>
        <div class="edit-menu-modal-footer">
            <button id="modal-submit-edit-menu" class="edit-menu-modal-submit-btn" type="submit">Save</button>
            <button id="modal-cancel-edit-menu" class="edit-menu-modal-cancel-btn" type="button">Cancel</button>
        </div>
    </form>
</div>

<script src="../../assets/js/restaurant.js"></script>
</body>
</html>