// amenity.js - Handles amenity add modal open/close logic and amenity list for amenities.php
document.addEventListener('DOMContentLoaded', function() {
    // Modal open/close logic
    const amenityAddBtn = document.querySelector('.add-btn');
    const amenityModal = document.getElementById('amenity-modal');
    const amenityAddCancelBtn = document.getElementById('modal-cancel-amenity');


    if (amenityAddBtn && amenityModal && amenityAddCancelBtn) {
        function resetAmenityModalFields() {
            document.getElementById('modal-category-name').value = '';
            document.getElementById('modal-amenity-name').value = '';
        }
        amenityAddBtn.addEventListener('click', function(e) {
            e.preventDefault();
            amenityModal.classList.add('active');
        });
        amenityAddCancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            amenities = [];
            renderAmenityList();
            resetAmenityModalFields();
            amenityModal.classList.remove('active');
        });
        amenityModal.addEventListener('mousedown', function(e) {
            if (e.target === amenityModal) {
                amenities = [];
                renderAmenityList();
                resetAmenityModalFields();
                amenityModal.classList.remove('active');
            }
        });
    }

    // Amenity add/delete logic
    const amenityInput = document.getElementById('modal-amenity-name');
    const addAmenityBtn = document.querySelector('.amenity-add-amenity-btn');
    const amenityListDiv = document.querySelector('.amenity-modal-amenity-list');
    let amenities = [];

    function renderAmenityList() {
        amenityListDiv.innerHTML = amenities.map(function(name, idx) {
            return '<div class="amenity-modal-amenity-item" data-idx="' + idx + '">' +
                '<span>' + name + '</span>' +
                '<button type="button" class="delete-btn amenity-modal-delete-amenity-btn" title="Delete"><img src="../../resources/icons/delete_icon.png" alt="Delete"></button>' +
                '</div>';
        }).join('');
    }

    // Notification element for add modal
    var notificationDiv = document.createElement('div');
    notificationDiv.className = 'amenity-notification';
    notificationDiv.textContent = '';
    var amenityModalForm = document.querySelector('.amenity-modal-form');
    if (amenityModalForm) {
        amenityModalForm.insertBefore(notificationDiv, amenityModalForm.firstChild);
    } else {
        document.body.appendChild(notificationDiv);
    }
    // Notification element for edit modal
    var editNotificationDiv = document.createElement('div');
    editNotificationDiv.className = 'amenity-notification';
    editNotificationDiv.textContent = '';
    var editAmenityModalForm = document.querySelector('#edit-amenity-modal .amenity-modal-form');
    if (editAmenityModalForm) {
        editAmenityModalForm.insertBefore(editNotificationDiv, editAmenityModalForm.firstChild);
    } else {
        document.body.appendChild(editNotificationDiv);
    }

    function showNotification(msg, targetDiv) {
        var div = targetDiv || notificationDiv;
        div.textContent = msg;
        div.style.display = 'block';
        setTimeout(function() {
            div.style.display = 'none';
        }, 1800);
    }

    if (addAmenityBtn && amenityInput && amenityListDiv) {
        addAmenityBtn.onclick = function() {
            var name = amenityInput.value.trim();
            if (name) {
                var duplicate = amenities.some(function(existing) {
                    return existing.toLowerCase() === name.toLowerCase();
                });
                if (duplicate) {
                    showNotification('Amenity already added!', notificationDiv);
                    amenityInput.focus();
                    return;
                }
                amenities.push(name);
                renderAmenityList();
                amenityInput.value = '';
                amenityInput.focus();
            }
        };
        amenityListDiv.onclick = function(e) {
            var delBtn = e.target.closest('.amenity-modal-delete-amenity-btn');
            if (delBtn) {
                var itemDiv = delBtn.closest('.amenity-modal-amenity-item');
                var idx = parseInt(itemDiv.getAttribute('data-idx'), 10);
                amenities.splice(idx, 1);
                renderAmenityList();
            }
        };
    }

    // Category logic
    const categoryNameInput = document.getElementById('modal-category-name');
    const categoryListDiv = document.querySelector('.amenities');
    const addForm = document.getElementById('add-amenity-form');
    const addModal = document.getElementById('amenity-modal');
    const deleteCategoryModal = document.getElementById('delete-category-modal');
    const deleteCategoryForm = document.getElementById('delete-category-form');
    let deleteCategoryId = null;

    function renderCategoryList(categories) {
        let html = '';
        if (!categories || categories.length === 0) {
            html = '<div style="padding:10px;color:#888;">No categories found.</div>';
        } else {
            html = categories.map(cat => `
                <div class="category-container" data-id="${cat.category_id}">
                    <div class="header">
                        <p>${cat.category_name}</p>
                        <div class="buttons">
                            <button class="edit-btn" title="Edit"><img src="../../resources/icons/edit_icon.png" alt="Edit"></button>
                            <button class="delete-btn" title="Delete"><img src="../../resources/icons/delete_icon.png" alt="Delete"></button>
                        </div>
                    </div>
                    <div class="amenity-list">
                        ${cat.amenities && cat.amenities.length > 0 ? cat.amenities.map(amenity => `
                            <div class="amenity-item">
                                <span>${amenity.amenity_name}</span>
                            </div>
                        `).join('') : '<div style="padding:10px;color:#888;">No amenities found.</div>'}
                    </div>
                </div>
            `).join('');
        }
        categoryListDiv.innerHTML = html;
    }

    function fetchCategories() {
        fetch('../controller/AmenityController.php?action=list')
            .then(r => r.json())
            .then((data) => {
                let categories = data.categories || [];
                
                renderCategoryList(categories);
            });
    }

    fetchCategories();

    addForm.onsubmit = function(e) {
        e.preventDefault();
        const name = categoryNameInput.value.trim();
        if (!name) return;

        // Collect amenities from the amenity list
        const amenities = Array.from(amenityListDiv.querySelectorAll('.amenity-modal-amenity-item span'))
            .map(item => item.textContent.trim());

        fetch('../controller/AmenityController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=add&name=${encodeURIComponent(name)}&amenities=${encodeURIComponent(JSON.stringify(amenities))}`
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                fetchCategories();
                addModal.classList.remove('active');
                resetAddForm();
                amenities = [];
                renderAmenityList();
            } else {
                alert(data.error || 'Failed to add category.');
            }
        });
    };

    function resetAddForm() {
        categoryNameInput.value = '';
        amenityInput.value = '';
        amenities = [];
        renderAmenityList();
    }

    // Handle delete category logic
    categoryListDiv.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (deleteBtn) {
            const categoryContainer = deleteBtn.closest('.category-container');
            deleteCategoryId = categoryContainer.getAttribute('data-id');
            const categoryName = categoryContainer.querySelector('.header p').textContent;
            deleteCategoryModal.querySelector('#delete-category-question').innerHTML = `
                <p>Are you sure you want to delete the category "${categoryName}"?</p>
            `;
            deleteCategoryModal.classList.add('active');
        }
    });

    deleteCategoryForm.onsubmit = function(e) {
        e.preventDefault();
        if (!deleteCategoryId) return;
        fetch('../controller/AmenityController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete&id=${encodeURIComponent(deleteCategoryId)}`
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                fetchCategories();
                deleteCategoryModal.classList.remove('active');
                deleteCategoryId = null;
            } else {
                alert(data.error || 'Failed to delete category.');
            }
        });
    };

    deleteCategoryModal.addEventListener('mousedown', function(e) {
        if (e.target === deleteCategoryModal) {
            deleteCategoryModal.classList.remove('active');
            deleteCategoryId = null;
        }
    });

    // Handle cancel button for delete category modal
    const deleteCategoryCancelBtn = document.getElementById('cancel-delete-category');
    if (deleteCategoryCancelBtn) {
        deleteCategoryCancelBtn.addEventListener('click', function() {
            deleteCategoryModal.classList.remove('active');
            deleteCategoryId = null;
        });
    }

    let editAmenities = [];
    let editCategoryId = null;

    // Open edit modal and load data
    categoryListDiv.addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            const categoryContainer = editBtn.closest('.category-container');
            editCategoryId = categoryContainer.getAttribute('data-id');
            const name = categoryContainer.querySelector('.header p').textContent;
            document.getElementById('edit-modal-category-name').value = name;
            // Load amenities
            const amenitiesSpans = categoryContainer.querySelectorAll('.amenity-item span');
            editAmenities = Array.from(amenitiesSpans).map(span => span.textContent.trim());
            renderEditAmenityList();
            document.getElementById('edit-amenity-modal').classList.add('active');
        }
    });

    // Render amenities in edit modal
    function renderEditAmenityList() {
        const editAmenityListDiv = document.querySelector('.edit-amenity-modal-amenity-list');
        editAmenityListDiv.innerHTML = editAmenities.map(function(name, idx) {
            return '<div class="amenity-modal-amenity-item" data-idx="' + idx + '">' +
                '<span>' + name + '</span>' +
                '<button type="button" class="delete-btn edit-amenity-modal-delete-amenity-btn" title="Delete"><img src="../../resources/icons/delete_icon.png" alt="Delete"></button>' +
                '</div>';
        }).join('');
    }

    // Add amenity in edit modal
    const editAmenityInput = document.getElementById('edit-modal-amenity-name');
    const editAddAmenityBtn = document.querySelector('.edit-amenity-add-amenity-btn');
    const editAmenityListDiv = document.querySelector('.edit-amenity-modal-amenity-list');
    if (editAddAmenityBtn && editAmenityInput && editAmenityListDiv) {
        editAddAmenityBtn.onclick = function() {
            var name = editAmenityInput.value.trim();
            if (name) {
                var duplicate = editAmenities.some(function(existing) {
                    return existing.toLowerCase() === name.toLowerCase();
                });
                if (duplicate) {
                    showNotification('Amenity already added!', editNotificationDiv);
                    editAmenityInput.focus();
                    return;
                }
                editAmenities.push(name);
                renderEditAmenityList();
                editAmenityInput.value = '';
                editAmenityInput.focus();
            }
        };
        editAmenityListDiv.onclick = function(e) {
            var delBtn = e.target.closest('.edit-amenity-modal-delete-amenity-btn');
            if (delBtn) {
                var itemDiv = delBtn.closest('.amenity-modal-amenity-item');
                var idx = parseInt(itemDiv.getAttribute('data-idx'), 10);
                editAmenities.splice(idx, 1);
                renderEditAmenityList();
            }
        };
    }

    // Handle edit modal cancel
    const editModal = document.getElementById('edit-amenity-modal');
    const editCancelBtn = document.getElementById('edit-modal-cancel-amenity');
    if (editCancelBtn) {
        editCancelBtn.addEventListener('click', function() {
            editModal.classList.remove('active');
            editCategoryId = null;
            editAmenities = [];
            renderEditAmenityList();
            document.getElementById('edit-modal-amenity-name').value = ''; // Reset category name
        });
    }
    editModal.addEventListener('mousedown', function(e) {
        if (e.target === editModal) {
            editModal.classList.remove('active');
            editCategoryId = null;
            editAmenities = [];
            renderEditAmenityList();
            document.getElementById('edit-modal-amenity-name').value = ''; // Reset category name
        }
    });

    // Handle edit form submit
    const editForm = document.getElementById('edit-amenity-form');
    if (editForm) {
        editForm.onsubmit = function(e) {
            e.preventDefault();
            const name = document.getElementById('edit-modal-category-name').value.trim();
            if (!name) return;
            // Check for duplicates
            const lower = editAmenities.map(a => a.toLowerCase());
            if (new Set(lower).size !== lower.length) {
                showNotification('Duplicate amenities are not allowed.', editNotificationDiv);
                return;
            }
            fetch('../controller/AmenityController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=edit&id=${encodeURIComponent(editCategoryId)}&name=${encodeURIComponent(name)}&amenities=${encodeURIComponent(JSON.stringify(editAmenities))}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    fetchCategories();
                    editModal.classList.remove('active');
                    editCategoryId = null;
                    editAmenities = [];
                    renderEditAmenityList();
                    editAmenityInput.value = '';
                } else {
                    alert(data.error || 'Failed to update category.');
                }
            });
        };
    }
});
