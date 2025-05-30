<!--
services.php
Simple UI for managing hotel services: list, add, edit, delete, and search.
-->

<link rel="stylesheet" href="../assets/css/service.css">
<div class="main-header">
    <p>Services</p>
    <div class="list"><button class="add-btn">Add Service</button></div>
</div>
<div class="main-content">
    <div class="service-schedule">
        <div class="header">
            <!-- HEADER CONTENT -->
        </div>
        <div class="schedule">
            <!-- SCHEDULE CONTENT -->
        </div>
    </div>
    <div class="service-list">
        <div class="header"><p>Service List</p></div>
        <input type="text" class="input service-search" placeholder="Search services..." />
        <div class="list">
          <!-- LIST OF SERVICES -->
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal" id="modal-service-add">
  <form class="form" id="form-service-add" autocomplete="off" onsubmit="return false;">
    <div class="modal-header">
        <p>Add New Service</p>
    </div>
    <div class="modal-body">
        <input class="input" type="text" id="input-service-name" placeholder="Service Name" required />
        <input class="input" type="number" id="input-service-price" placeholder="Service Price" required />
    </div>
    <div class="modal-footer">
        <button id="btn-service-submit" class="submit-btn" type="submit">Add</button>
        <button id="btn-service-cancel" class="cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<!-- Edit Modal -->
<div class="modal" id="modal-service-edit">
  <form class="form" id="form-service-edit" autocomplete="off" onsubmit="return false;">
    <div class="modal-header">
        <h3>Edit Service</h3>
    </div>
    <div class="modal-body">
        <input type="hidden" id="input-service-id" />
        <input class="input" type="text" id="input-service-edit-name" placeholder="Service Name" required />
        <input class="input" type="number" id="input-service-edit-price" placeholder="Service Price" required />
    </div>
    <div class="modal-footer">
      <button id="btn-service-edit-submit" class="submit-btn" type="submit">Save</button>
      <button id="btn-service-edit-cancel" class="cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="modal-service-delete">
  <form class="form" id="form-service-delete" autocomplete="off" onsubmit="return false;">
    <div class="modal-header">
        <p>Delete Service</p>
    </div>
    <div class="modal-body">
        <input type="hidden" id="input-service-delete-id" />
        <p id="delete-service-question" style="margin:0 0 10px 0; text-align:center;">Are you sure you want to delete this service?</p>
    </div>
    <div class="modal-footer">
        <button id="btn-service-delete-submit" class="submit-btn" type="submit" style="background:#ff5429;">Delete</button>
        <button id="btn-service-delete-cancel" class="cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>
<script src="../../assets/js/service.js"></script>
</body>
</html>