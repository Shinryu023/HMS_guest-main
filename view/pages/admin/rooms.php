<link rel="stylesheet" href="../assets/css/rooms.css">

<div class="main-header">
    <p>Rooms</p>
    <button class="add-room-type-btn">Add Room Type</button>
</div>
<div class="main-content">
    <div class="room-list outlined">
        <?php include '../view/pages/admin/boxes.php'; ?>
    </div>
    <div class="room-preview outlined">
    </div>
</div>

<!-- Add Modal -->
<div class="add-room-type-modal" id="modal-add-room-type">
  <form class="add-room-type-form" id="add-room-type-form" autocomplete="off" onsubmit="return false;">
    <div class="modal-header">
        <p>Add New Room</p>
    </div>
    <div class="modal-body">
        <input class="input" type="text" id="input-room-type-name" placeholder="Room Type" required />
        <div class="input-row">
            <input class="input" type="number" id="input-room-type-price" placeholder="Room Size" required />
            <input class="input" type="number" id="input-room-type-price" placeholder="Occupancy" required />
        </div>
        <div class="input-row">
            <input class="input" type="text" id="input-room-type-price" placeholder="Bed Type" required />
            <input class="input" type="number" id="input-room-type-price" placeholder="Price" required />
        </div>

        <div class="add-room-container">
            <div class="add-container">
                <input class="input" type="number" id="add-room-input" placeholder="Room Number" required />
                <button id="add-room-btn" type="button">Add</button>
            </div>
            <div class="room-list">

            </div>
        </div>

        <textarea class="long-input input" id="input-room-type-price" placeholder="Description" required></textarea>
    </div>
    <div class="modal-footer">
        <button id="add-room-type-submit-btn" class="submit-btn" type="submit">Add</button>
        <button id="add-room-type-cancel-btn" class="cancel-btn" type="button">Cancel</button>
    </div>
  </form>
</div>

<script src="../assets/js/room.js"></script>


