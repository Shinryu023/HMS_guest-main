// service.js - Handles all service management logic for services.php

document.addEventListener('DOMContentLoaded', function() {
    // --- Simple Service Management ---
    const addBtn = document.querySelector('.add-btn');
    const addModal = document.getElementById('modal-service-add');
    const editModal = document.getElementById('modal-service-edit');
    const deleteModal = document.getElementById('modal-service-delete');
    const addForm = document.getElementById('form-service-add');
    const editForm = document.getElementById('form-service-edit');
    const deleteForm = document.getElementById('form-service-delete');
    const addCancelBtn = document.getElementById('btn-service-cancel');
    const editCancelBtn = document.getElementById('btn-service-edit-cancel');
    const deleteCancelBtn = document.getElementById('btn-service-delete-cancel');
    const serviceListDiv = document.querySelector('.service-list .list');
    const serviceSearch = document.querySelector('.service-search');
    let deleteServiceId = null;

    addBtn.onclick = () => addModal.classList.add('active');
    addCancelBtn.onclick = () => { addModal.classList.remove('active'); resetAddForm(); };
    addModal.onclick = e => { if (e.target === addModal) { addModal.classList.remove('active'); resetAddForm(); } };
    editCancelBtn.onclick = () => { editModal.classList.remove('active'); resetEditForm(); };
    editModal.onclick = e => { if (e.target === editModal) { editModal.classList.remove('active'); resetEditForm(); } };
    deleteCancelBtn.onclick = () => { deleteModal.classList.remove('active'); deleteServiceId = null; };
    deleteModal.onclick = e => { if (e.target === deleteModal) { deleteModal.classList.remove('active'); deleteServiceId = null; } };

    function resetAddForm() {
        addForm.reset();
    }
    function resetEditForm() {
        editForm.reset();
    }

    function renderServiceList(services) {
        let html = '';
        if (!services || services.length === 0) {
            html = '<div style="padding:10px;color:#888;">No services found.</div>';
        } else {
            html = services.map(s => `
                <div class="service-row" data-id="${s.id}">
                    <span class="service-name">${s.name}</span>
                    <span class="service-price">₱${parseFloat(s.price).toFixed(2)}</span>
                    <button class="edit-btn" title="Edit"><img src="../../resources/icons/edit_icon.png" alt="Edit"></button>
                    <button class="delete-btn" title="Delete"><img src="../../resources/icons/delete_icon.png" alt="Delete"></button>
                </div>
            `).join('');
        }
        serviceListDiv.innerHTML = html;
    }

    function fetchServices(query = '') {
        let url = '../controller/ServiceController.php?action=list';
        fetch(url)
            .then(r => r.json())
            .then((data) => {
                let services = data.services || [];
                if (query) {
                    const q = query.toLowerCase();
                    services = services.filter(s => {
                        if (s.name && s.name.toLowerCase().startsWith(q)) return true;
                        if (s.price) {
                            const priceStr = s.price.toString();
                            return priceStr.startsWith(q);
                        }
                        return false;
                    });
                }
                renderServiceList(services);
            });
    }

    fetchServices();

    addForm.onsubmit = function(e) {
        e.preventDefault();
        const name = document.getElementById('input-service-name').value.trim();
        const price = document.getElementById('input-service-price').value.trim();
        if (!name || !price) return;
        fetch('../controller/ServiceController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=add&name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}`
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                fetchServices();
                addModal.classList.remove('active');
                resetAddForm();
            } else {
                alert(data.error || 'Failed to add service.');
            }
        });
    };

    editForm.onsubmit = function(e) {
        e.preventDefault();
        const id = document.getElementById('input-service-id').value;
        const name = document.getElementById('input-service-edit-name').value.trim();
        const price = document.getElementById('input-service-edit-price').value.trim();
        if (!id || !name || !price) return;
        fetch('../controller/ServiceController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=edit&id=${encodeURIComponent(id)}&name=${encodeURIComponent(name)}&price=${encodeURIComponent(price)}`
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                fetchServices();
                editModal.classList.remove('active');
                resetEditForm();
            } else {
                alert(data.error || 'Failed to update service.');
            }
        });
    };

    serviceListDiv.onclick = function(e) {
        const row = e.target.closest('.service-row');
        if (!row) return;
        const id = row.getAttribute('data-id');
        const editBtn = e.target.closest('.edit-btn');
        const deleteBtn = e.target.closest('.delete-btn');
        if (editBtn) {
            // Populate edit modal
            document.getElementById('input-service-id').value = id;
            document.getElementById('input-service-edit-name').value = row.querySelector('.service-name').textContent;
            document.getElementById('input-service-edit-price').value = row.querySelector('.service-price').textContent.replace('₱','');
            editModal.classList.add('active');
        } else if (deleteBtn) {
            // Show delete modal
            document.getElementById('input-service-delete-id').value = id;
            document.getElementById('delete-service-question').textContent = 'Are you sure you want to delete "' + row.querySelector('.service-name').textContent + '"?';
            deleteModal.classList.add('active');
        }
    };

    deleteForm.onsubmit = function(e) {
        e.preventDefault();
        const id = document.getElementById('input-service-delete-id').value;
        if (!id) return;
        fetch('../controller/ServiceController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete&id=${encodeURIComponent(id)}`
        })
        .then(r => r.json())
        .then((data) => {
            if (data.success) {
                fetchServices();
                deleteModal.classList.remove('active');
                deleteServiceId = null;
            } else {
                alert(data.error || 'Failed to delete service.');
            }
        });
    };

    serviceSearch.oninput = function() {
        fetchServices(this.value);
    };
});
