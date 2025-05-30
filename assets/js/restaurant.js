document.addEventListener('DOMContentLoaded', function() {
    const categoryEditBtn = document.querySelector('.edit-cat-btn');
    const editMenuCategoryModal = document.getElementById('menu-cat-modal');
    const cancelEditCategoryBtn = document.getElementById('modal-cancel-edit-cat');

    // When opening modal, use DB categories as initial state
    function openEditCategoryModal() {
        fetch('../../controller/RestaurantController.php?action=list')
            .then(r => r.json())
            .then(data => {
                resetEditMenuCatForm(data.categories || []);
                editMenuCategoryModal.classList.add('active');
            });
    }
    categoryEditBtn.onclick = openEditCategoryModal;
    cancelEditCategoryBtn.onclick = () => editMenuCategoryModal.classList.remove('active');
    editMenuCategoryModal.onclick = e => { if (e.target === editMenuCategoryModal) { editMenuCategoryModal.classList.remove('active'); } };

    const newCategoryInput = document.getElementById('menu-cat-name');
    const addNewCategorytBtn = document.querySelector('.menu-cat-add-btn');
    const menuCatModalCategoryList = document.querySelector('.menu-cat-modal-category-list');
    let menuCategories = [];

    function resetEditMenuCatForm(categoriesFromDb = []) {
        newCategoryInput.value = '';
        // Only use category names (strings) for local editing
        menuCategories = categoriesFromDb.map(cat => cat.category_name);
        renderCategoryList();
    }

    function renderCategoryList() {
        menuCatModalCategoryList.innerHTML = menuCategories.map(function(name, idx) {
            return `
                <div class="menu-cat-modal-category-item" data-idx="${idx}">
                    <span>${name}</span>
                    <button type="button" class="delete-btn menu-cat-modal-delete-cat-btn" title="Delete">
                        <img src="../../resources/icons/delete_icon.png" alt="Delete">
                    </button>
                </div>
            `;
        }).join('');
    }

    if (addNewCategorytBtn && newCategoryInput && menuCatModalCategoryList) {
        addNewCategorytBtn.onclick = function() {
            var name = newCategoryInput.value.trim();
            if (name) {
                var duplicate = menuCategories.some(function(existing) {
                    return existing.toLowerCase() === name.toLowerCase();
                });
                if (duplicate) {
                    showNotification('Category already added!', notificationDiv);
                    newCategoryInput.focus();
                    return;
                }
                menuCategories.push(name);
                renderCategoryList();
                newCategoryInput.value = '';
                newCategoryInput.focus();
            }
        };
        menuCatModalCategoryList.onclick = function(e) {
            var delBtn = e.target.closest('.menu-cat-modal-delete-cat-btn');
            if (delBtn) {
                var itemDiv = delBtn.closest('.menu-cat-modal-category-item');
                var idx = parseInt(itemDiv.getAttribute('data-idx'), 10);
                // If the deleted category is the current active one, reset to 'All'
                const deletedName = menuCategories[idx];
                // Check if the deleted category is the current active one by comparing names
                // Get the current active button's name
                let activeBtn = document.querySelector('.cat-btn.active-cat-btn');
                let activeName = activeBtn ? activeBtn.textContent.trim() : null;
                if (activeName === deletedName) {
                    currentCategoryId = null;
                    // After deletion, re-render category buttons with 'All' active
                    fetch('../../controller/RestaurantController.php?action=list')
                        .then(r => r.json())
                        .then(data => {
                            renderCategoryButtons(data.categories || []);
                        });
                }
                menuCategories.splice(idx, 1);
                renderCategoryList();
            }
        };
    }

    var notificationDiv = document.createElement('div');
    notificationDiv.className = 'menu-cat-notification';
    notificationDiv.textContent = '';
    notificationDiv.style.display = 'none'; // Ensure hidden by default

    var menuCatModalForm = document.querySelector('.menu-cat-modal-form');
    if (menuCatModalForm) {
        menuCatModalForm.insertBefore(notificationDiv, menuCatModalForm.firstChild);
    } else {
        document.body.appendChild(notificationDiv);
    }

    function showNotification(msg, targetDiv) {
        var div = targetDiv || notificationDiv;
        div.textContent = msg;
        div.style.display = 'block';
        setTimeout(function() {
            div.style.display = 'none';
        }, 1800);
    }

    const submitEditCategoryBtn  = document.getElementById('modal-submit-edit-cat');
    if (submitEditCategoryBtn) {
        submitEditCategoryBtn.onclick = function(e) {
            e.preventDefault();
            // Collect all category names currently in the modal list
            const categories = Array.from(menuCatModalCategoryList.querySelectorAll('.menu-cat-modal-category-item span'))
                .map(item => item.textContent.trim());
            fetch('../../controller/RestaurantController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=saveCategories&categories=${encodeURIComponent(JSON.stringify(categories))}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Categories saved!', notificationDiv);
                    // Refresh categories after saving
                    fetch('../../controller/RestaurantController.php?action=list')
                        .then(r => r.json())
                        .then(data => {
                            menuCategoriesList = data.categories || [];
                            window.menuCategoriesList = menuCategoriesList;
                            renderCategoryButtons(menuCategoriesList);
                        });
                    editMenuCategoryModal.classList.remove('active');
                } else {
                    showNotification(data.message || 'Failed to save categories.', notificationDiv);
                }
            })
            .catch(() => {
                showNotification('Error saving categories.', notificationDiv);
            });
        };
    }

    // --- CATEGORY BUTTONS ---
    const categoriesDivs = document.querySelectorAll('.categories');
    let currentCategoryId = null; // null means 'All'

    function renderCategoryButtons(categories) {
        if (!categoriesDivs.length) return;
        let html = '';
        // All button
        html += `<button class="all-btn${currentCategoryId === null ? ' active-cat-btn' : ''}" data-id="all">All</button>`;
        // Category buttons
        if (categories && categories.length > 0) {
            html += categories.map(cat => `<button class="cat-btn${currentCategoryId == cat.category_id ? ' active-cat-btn' : ''}" data-id="${cat.category_id}">${cat.category_name}</button>`).join('');
        }
        categoriesDivs.forEach(div => div.innerHTML = html);
    }

    // Handle category button click
    categoriesDivs.forEach(div => {
        div.addEventListener('click', function(e) {
            const btn = e.target.closest('.all-btn, .cat-btn');
            if (btn && btn.hasAttribute('data-id')) {
                const id = btn.getAttribute('data-id');
                currentCategoryId = (id === 'all') ? null : id;
                renderCategoryButtons(window.menuCategoriesList || []); // update active state
                fetchAndDisplayMenus(id);
            }
        });
    });

    // --- FETCH AND DISPLAY MENUS ON LOAD ---
    function fetchAndDisplayMenus(categoryId) {
        let url = '../../controller/RestaurantController.php?action=getMenu';
        if (categoryId && categoryId !== 'all') {
            url += `&category_id=${encodeURIComponent(categoryId)}`;
        }
        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data.success && data.menu) {
                    renderMenuCards(data.menu);
                } else {
                    renderMenuCards([]);
                }
            })
            .catch(() => {
                renderMenuCards([]);
            });
    }

    // On load, fetch categories and menus
    let menuCategoriesList = [];
    fetch('../../controller/RestaurantController.php?action=list')
        .then(r => r.json())
        .then(data => {
            menuCategoriesList = data.categories || [];
            window.menuCategoriesList = menuCategoriesList;
            renderCategoryButtons(menuCategoriesList);
        });
    fetchAndDisplayMenus();

    // ADD MENU MODAL OPEN/CLOSE
    const addMenuBtn = document.querySelector('.add-menu-btn');
    const addMenuModal = document.getElementById('add-menu-modal');
    const cancelAddMenuBtn = document.getElementById('modal-cancel-add-menu');

    addMenuBtn.onclick = () => addMenuModal.classList.add('active');
    cancelAddMenuBtn.onclick = () => addMenuModal.classList.remove('active');
    addMenuModal.onclick = e => { if (e.target === addMenuModal) { addMenuModal.classList.remove('active'); } };

    // --- LOAD CATEGORIES INTO ADD MENU DROPDOWN ---
    function loadMenuCategoryDropdown() {
        const menuCategorySelect = document.getElementById('menu-category');
        if (!menuCategorySelect) return;
        fetch('../../controller/RestaurantController.php?action=list')
            .then(r => r.json())
            .then(data => {
                let html = '<option value="">None</option>';
                if (data.categories && data.categories.length > 0) {
                    html += data.categories.map(cat => `<option value="${cat.category_id}">${cat.category_name}</option>`).join('');
                }
                menuCategorySelect.innerHTML = html;
            });
    }

    // Open Add Menu Modal: also load categories
    if (addMenuBtn && addMenuModal) {
        addMenuBtn.onclick = function() {
            addMenuModal.classList.add('active');
            loadMenuCategoryDropdown();
        };
    }

    // --- ADD MENU SUBMIT HANDLER ---
    const submitAddMenuBtn = document.getElementById('modal-submit-add-menu');
    const addMenuForm = document.getElementById('add-menu-modal-form');
    if (submitAddMenuBtn && addMenuForm) {
        submitAddMenuBtn.onclick = function(e) {
            e.preventDefault();
            const name = document.getElementById('menu-name').value.trim();
            const price = document.getElementById('menu-price').value;
            const category = document.getElementById('menu-category').value;
            const imageInput = document.getElementById('menu-image');
            const statusAvailable = document.getElementById('status-available').checked;
            const statusUnavailable = document.getElementById('status-unavailable').checked;
            let status = statusAvailable ? 'Available' : (statusUnavailable ? 'Unavailable' : 'Available');

            if (!name || price === '' || isNaN(price) || parseFloat(price) < 0) {
                alert('Please enter a valid name and non-negative price.');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'addMenu');
            formData.append('name', name);
            formData.append('price', price);
            formData.append('status', status);
            // Only append category_id if a real category is selected
            if (category && category !== '') {
                formData.append('category_id', category);
            }
            // Only append image if a file is selected and is an image
            if (imageInput && imageInput.files && imageInput.files.length > 0) {
                const file = imageInput.files[0];
                if (file.type.startsWith('image/')) {
                    formData.append('image', file);
                } else {
                    alert('Selected file is not an image.');
                    return;
                }
            }

            fetch('../../controller/RestaurantController.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    addMenuModal.classList.remove('active');
                    addMenuForm.reset();
                    fetchAndDisplayMenus(); // Refresh menu list immediately
                } else {
                    alert(data.error || 'Failed to add menu.');
                }
            })
            .catch(() => {
                alert('Error adding menu.');
            });
        };
    }

    // --- RENDER MENU CARDS ---
    function renderMenuCards(menuList) {
        const container = document.getElementById('menu-list');
        if (!container) return;
        if (!Array.isArray(menuList) || menuList.length === 0) {
            container.innerHTML = '<p style="padding:20px;">No menu items found.</p>';
            return;
        }
        let html = '';
        menuList.forEach(menu => {
            html += `
            <div class="menu-card" data-menu-id="${menu.menu_id}" data-category-id="${menu.category_id || ''}" data-image="${menu.image || ''}">
                <div class="menu-img outlined">
                    <img src="${menu.image ? '../../' + menu.image : '../../resources/icons/default_user_icon.png'}" alt="${menu.name}">
                </div>
                <div class="menu-body">
                    <p class="name">${menu.name}</p>
                    <p class="status ${menu.status === 'Available' ? 'available' : 'unavailable'}">${menu.status}</p>
                </div>
                <div class="last-row outlined">
                    <p class="price">₱${parseFloat(menu.price).toFixed(2)}</p>
                    <div class="buttons">
                        <button class="edit-btn" title="Edit"><img src="../../resources/icons/edit_icon.png" alt="Edit"></button>
                        <button class="delete-btn" title="Delete"><img src="../../resources/icons/delete_icon.png" alt="Delete"></button>
                    </div>
                </div>
            </div>
            `;
        });
        container.innerHTML = html;
    }

    // --- FETCH AND DISPLAY MENUS ON LOAD ---
    function fetchAndDisplayMenus(categoryId) {
        let url = '../../controller/RestaurantController.php?action=getMenu';
        if (categoryId && categoryId !== 'all') {
            url += `&category_id=${encodeURIComponent(categoryId)}`;
        }
        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data.success && data.menu) {
                    renderMenuCards(data.menu);
                } else {
                    renderMenuCards([]);
                }
            })
            .catch(() => {
                renderMenuCards([]);
            });
    }

    // Call on page load
    fetchAndDisplayMenus();

    // --- DELETE MENU MODAL LOGIC ---
    const deleteMenuModal = document.getElementById('delete-menu-modal');
    const deleteMenuForm = document.getElementById('delete-menu-form');
    const deleteMenuQuestion = document.getElementById('delete-menu-question');
    const confirmDeleteMenuBtn = document.getElementById('confirm-delete-menu');
    const cancelDeleteMenuBtn = document.getElementById('cancel-delete-menu');
    let deleteMenuId = null;

    // Open modal on delete button click
    const menuListDiv = document.getElementById('menu-list');
    if (menuListDiv && deleteMenuModal && deleteMenuForm) {
        menuListDiv.addEventListener('click', function(e) {
            const deleteBtn = e.target.closest('.delete-btn');
            if (deleteBtn) {
                const menuCard = deleteBtn.closest('.menu-card');
                if (!menuCard) return;
                // Find menu name and id (assume menu_id is available in dataset or as attribute)
                // If not, you may need to add data-menu-id to .menu-card in renderMenuCards
                let menuId = menuCard.getAttribute('data-menu-id');
                let menuName = menuCard.querySelector('.name')?.textContent || '';
                if (!menuId) {
                    // Try to find menuId from a hidden field or similar
                    // If not present, you must update renderMenuCards to add data-menu-id
                    alert('Menu ID not found.');
                    return;
                }
                deleteMenuId = menuId;
                deleteMenuQuestion.innerHTML = `Are you sure you want to delete the menu "<b>${menuName}</b>"?`;
                deleteMenuModal.classList.add('active');
            }
        });
        // Confirm delete
        deleteMenuForm.onsubmit = function(e) {
            e.preventDefault();
            if (!deleteMenuId) return;
            fetch('../../controller/RestaurantController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=deleteMenu&menu_id=${encodeURIComponent(deleteMenuId)}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    fetchAndDisplayMenus();
                    deleteMenuModal.classList.remove('active');
                    deleteMenuId = null;
                } else {
                    alert(data.error || 'Failed to delete menu.');
                }
            });
        };
        // Cancel delete
        cancelDeleteMenuBtn.onclick = function() {
            deleteMenuModal.classList.remove('active');
            deleteMenuId = null;
        };
        // Close modal on background click
        deleteMenuModal.addEventListener('mousedown', function(e) {
            if (e.target === deleteMenuModal) {
                deleteMenuModal.classList.remove('active');
                deleteMenuId = null;
            }
        });
    }

    // Update renderMenuCards to add data-menu-id to .menu-card
    const origRenderMenuCards = renderMenuCards;
    renderMenuCards = function(menuList) {
        const container = document.getElementById('menu-list');
        if (!container) return;
        if (!Array.isArray(menuList) || menuList.length === 0) {
            container.innerHTML = '<p style="padding:20px;">No menu items found.</p>';
            return;
        }
        let html = '';
        menuList.forEach(menu => {
            html += `
            <div class="menu-card" data-menu-id="${menu.menu_id}" data-category-id="${menu.category_id || ''}" data-image="${menu.image || ''}">
                <div class="menu-img outlined">
                    <img src="${menu.image ? '../../' + menu.image : '../../resources/icons/default_user_icon.png'}" alt="${menu.name}">
                </div>
                <div class="menu-body">
                    <p class="name">${menu.name}</p>
                    <p class="status ${menu.status === 'Available' ? 'available' : 'unavailable'}">${menu.status}</p>
                </div>
                <div class="last-row outlined">
                    <p class="price">₱${parseFloat(menu.price).toFixed(2)}</p>
                    <div class="buttons">
                        <button class="edit-btn" title="Edit"><img src="../../resources/icons/edit_icon.png" alt="Edit"></button>
                        <button class="delete-btn" title="Delete"><img src="../../resources/icons/delete_icon.png" alt="Delete"></button>
                    </div>
                </div>
            </div>
            `;
        });
        container.innerHTML = html;
    };

    // --- LOGIC FOR MENU TABS (ALL, CATEGORY TABS) ---
    const menuTabs = document.querySelectorAll('.menu-tab');
    let activeTab = 'all';

    function updateMenuTabDisplay() {
        const menuList = document.getElementById('menu-list');
        if (!menuList) return;
        const allMenus = menuList.querySelectorAll('.menu-card');
        allMenus.forEach(menu => {
            const menuCategories = menu.getAttribute('data-categories') || '';
            if (activeTab === 'all' || menuCategories.split(',').includes(activeTab)) {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        });
    }

    menuTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            menuTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeTab = this.getAttribute('data-category') || 'all';
            updateMenuTabDisplay();
        });
    });

    // Initial fetch and display
    fetchAndDisplayMenus();
    updateMenuTabDisplay();

    // --- EDIT MENU MODAL LOGIC ---
    const editMenuModal = document.getElementById('edit-menu-modal');
    const editMenuForm = document.getElementById('edit-menu-modal-form');
    const editMenuIdInput = document.getElementById('edit-menu-id');
    const editMenuNameInput = document.getElementById('edit-menu-name');
    const editMenuPriceInput = document.getElementById('edit-menu-price');
    const editMenuCategorySelect = document.getElementById('edit-menu-category');
    const editMenuImageInput = document.getElementById('edit-menu-image');
    const editStatusAvailable = document.getElementById('edit-status-available');
    const editStatusUnavailable = document.getElementById('edit-status-unavailable');
    const cancelEditMenuBtn = document.getElementById('modal-cancel-edit-menu');

    if (menuListDiv && editMenuModal && editMenuForm) {
        menuListDiv.addEventListener('click', function(e) {
            const editBtn = e.target.closest('.edit-btn');
            if (editBtn) {
                const menuCard = editBtn.closest('.menu-card');
                if (!menuCard) return;
                const menuId = menuCard.getAttribute('data-menu-id');
                const name = menuCard.querySelector('.name')?.textContent || '';
                const price = menuCard.querySelector('.price')?.textContent.replace('₱','') || '';
                const status = menuCard.querySelector('.status')?.textContent || 'Available';
                const categoryId = menuCard.getAttribute('data-category-id') || '';
                // Set values in modal
                editMenuIdInput.value = menuId;
                editMenuNameInput.value = name;
                editMenuPriceInput.value = price;
                // Load categories into dropdown and set selected
                fetch('../../controller/RestaurantController.php?action=list')
                    .then(r => r.json())
                    .then(data => {
                        let html = '<option value="">None</option>';
                        if (data.categories && data.categories.length > 0) {
                            html += data.categories.map(cat => `<option value="${cat.category_id}">${cat.category_name}</option>`).join('');
                        }
                        editMenuCategorySelect.innerHTML = html;
                        if (categoryId) {
                            editMenuCategorySelect.value = categoryId;
                        }
                    });
                // Set status
                if (status === 'Available') {
                    editStatusAvailable.checked = true;
                    editStatusUnavailable.checked = false;
                } else {
                    editStatusAvailable.checked = false;
                    editStatusUnavailable.checked = true;
                }
                // Reset image input (cannot prefill file input for security reasons)
                editMenuImageInput.value = '';
                editMenuModal.classList.add('active');
            }
        });
        // Cancel edit
        cancelEditMenuBtn.onclick = function() {
            editMenuModal.classList.remove('active');
            editMenuForm.reset();
        };
        // Close modal on background click
        editMenuModal.addEventListener('mousedown', function(e) {
            if (e.target === editMenuModal) {
                editMenuModal.classList.remove('active');
                editMenuForm.reset();
            }
        });
        // Submit edit
        editMenuForm.onsubmit = function(e) {
            e.preventDefault();
            const menuId = editMenuIdInput.value;
            const name = editMenuNameInput.value.trim();
            const price = editMenuPriceInput.value;
            const category = editMenuCategorySelect.value;
            const status = editStatusAvailable.checked ? 'Available' : (editStatusUnavailable.checked ? 'Unavailable' : 'Available');
            const imageInput = editMenuImageInput;
            if (!menuId || !name || price === '' || isNaN(price) || parseFloat(price) < 0) {
                alert('Please enter a valid name and non-negative price.');
                return;
            }
            // Prevent duplicate name (except for this menu)
            fetch('../../controller/RestaurantController.php?action=getMenu')
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.menu) {
                        const duplicate = data.menu.some(m => m.name.toLowerCase() === name.toLowerCase() && m.menu_id != menuId);
                        if (duplicate) {
                            alert('Menu name already exists!');
                            return;
                        }
                        // Prepare form data
                        const formData = new FormData();
                        formData.append('action', 'editMenu');
                        formData.append('menu_id', menuId);
                        formData.append('name', name);
                        formData.append('price', price);
                        formData.append('status', status);
                        if (category && category !== '') {
                            formData.append('category_id', category);
                        }
                        if (imageInput && imageInput.files && imageInput.files.length > 0) {
                            const file = imageInput.files[0];
                            if (file.type.startsWith('image/')) {
                                formData.append('image', file);
                            } else {
                                alert('Selected file is not an image.');
                                return;
                            }
                        }
                        fetch('../../controller/RestaurantController.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                editMenuModal.classList.remove('active');
                                editMenuForm.reset();
                                fetchAndDisplayMenus();
                            } else {
                                alert(data.error || 'Failed to update menu.');
                            }
                        })
                        .catch(() => {
                            alert('Error updating menu.');
                        });
                    }
                });
        };
    }

});