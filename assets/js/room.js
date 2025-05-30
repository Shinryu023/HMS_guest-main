const addRoomTypeBtn = document.querySelector('.add-room-type-btn');
const addRoomTypeModal = document.getElementById('modal-add-room-type');
const addRoomTypeCancelBtn = document.getElementById('add-room-type-cancel-btn');

function openAddRoomTypeModal() {
    addRoomTypeModal.classList.add('active');
}

addRoomTypeBtn.onclick = openAddRoomTypeModal;
addRoomTypeCancelBtn.onclick = () => addRoomTypeModal.classList.remove('active');
addRoomTypeModal.onclick = e => { if (e.target === addRoomTypeModal) { addRoomTypeModal.classList.remove('active'); } };

const addRoomInput = document.getElementById('add-room-input');
const addRoomBtn = document.getElementById('add-room-btn');
const roomList = document.getElementById('room-list');
let rooms = [];

function renderRooms() {
    roomList.innerHTML = '';
    rooms.forEach((room, index) => {
        const roomItem = document.createElement('li');
        roomItem.className = 'room-item';
        roomItem.innerHTML = `
            <span>${room}</span>
            <button class="delete-room-btn" data-index="${index}">Delete</button>
        `;
        roomList.appendChild(roomItem);
    });
}

addRoomBtn.onclick = () => {
    const roomName = addRoomInput.value.trim();
    if (roomName) {
        rooms.push(roomName);
        addRoomInput.value = '';
        renderRooms();
    }
}
