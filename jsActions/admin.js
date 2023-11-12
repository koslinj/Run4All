async function deleteProduct(productId) {
    try {
        let url = "serverActions/deleteProduct.php"

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "productId=" + productId, // Send the data
        });

        console.log(response)

        if (!response.ok) {
            throw new Error("Error deleting the product: " + response.status);
        }

        const product = document.getElementById("product_" + productId);
        product.remove();

    } catch (error) {
        console.error(error);
    }
}

function searchProduct(){
    const searchInput = document.getElementById('searchInput');
    const productList = document.querySelector('.product-admin-list');

    const searchTerm = searchInput.value.trim().toLowerCase();

    // Loop through each product div and hide/show based on the search term
    Array.from(productList.getElementsByClassName('product-admin')).forEach(product => {
        const productName = product.dataset.productName.toLowerCase();

        if (productName.includes(searchTerm)) {
            product.style.display = 'flex';
        } else {
            product.style.display = 'none';
        }
    });
}

function toggleProductForm(id) {
    const editForm = document.getElementById("edit-form-product" + id);

    editForm.style.display = editForm.style.display === "none" ? "flex" : "none";
}

function updateSizes() {
    var categorySelect = document.getElementById("typeSelect");
    var sizesContainer = document.getElementById("sizesContainer");

    // Get the selected category value
    var selectedCategory = categorySelect.value;

    // Clear existing checkboxes
    sizesContainer.innerHTML = "";

    // Add checkboxes based on the selected category
    if (selectedCategory === "buty") {
        addCheckboxesForButy();
    } else {
        addCheckboxesForUbraniaAkcesoria();
    }
}

updateSizes()


function addCheckboxesForButy() {
    var sizesContainer = document.getElementById("sizesContainer");

    // Add checkboxes for buty
    var sizesForButy = ["36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46"];
    for (var i = 0; i < sizesForButy.length; i++) {
        var checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.name = "size[]";
        checkbox.value = sizesForButy[i];

        var label = document.createElement("label");
        label.appendChild(checkbox);
        label.appendChild(document.createTextNode(sizesForButy[i]));

        sizesContainer.appendChild(label);
    }
}

function addCheckboxesForUbraniaAkcesoria() {
    var sizesContainer = document.getElementById("sizesContainer");

    // Add checkboxes for ubrania and akcesoria
    var sizesForUbraniaAkcesoria = ["S", "M", "L", "XL"];
    for (var i = 0; i < sizesForUbraniaAkcesoria.length; i++) {
        var checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.name = "size[]";
        checkbox.value = sizesForUbraniaAkcesoria[i];

        var label = document.createElement("label");
        label.appendChild(checkbox);
        label.appendChild(document.createTextNode(sizesForUbraniaAkcesoria[i]));

        sizesContainer.appendChild(label);
    }
}

function updateCategories() {
    var typeSelect = document.getElementById("typeSelect");
    var categorySelect = document.getElementById("categorySelect");

    // Get the selected type value
    var selectedType = typeSelect.value;

    // Clear existing options
    categorySelect.innerHTML = "";

    // Fetch categories based on the selected type
    fetchCategories(selectedType);
}

updateCategories()

function fetchCategories(type) {
    // Make an AJAX request to fetch categories based on the selected type
    // Replace this with your actual AJAX request implementation
    // Here is a simplified example using fetch API
    fetch('serverActions/fetch_categories.php?type=' + type)
        .then(response => response.json())
        .then(categories => {
            // Update the category select dropdown with the fetched categories
            var categorySelect = document.getElementById("categorySelect");
            categories.forEach(category => {
                var option = document.createElement("option");
                option.value = category.categoryId;
                option.text = category.category;
                categorySelect.add(option);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));
}

async function deleteSize(sizeId) {
    try {
        let url = "serverActions/deleteSize.php"

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "sizeId=" + sizeId, // Send the data
        });

        console.log(response)

        if (!response.ok) {
            throw new Error("Error deleting the product: " + response.status);
        }

        const item = document.getElementById("size-item-" + sizeId);
        item.remove();

    } catch (error) {
        console.error(error);
    }
}

async function insertSize(productId, type) {
    try {
        let url = "serverActions/insertSize.php"

        let size = document.getElementById("sizeInput" + productId).value;

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "productId=" + productId + "&size=" + size + "&type=" + type, // Send the data
        });
        console.log(response)

        if (!response.ok) {
            throw new Error("Error deleting the product: " + response.status);
        }

        let sizeId = await response.text();
        console.log(sizeId)

        // Create a new change-product-item element
        const newChangeProductItem = document.createElement('div');
        newChangeProductItem.classList.add('change-product-item');
        newChangeProductItem.id = "size-item-" + sizeId // TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
        newChangeProductItem.textContent = size;

        // Create the trash icon
        const trashIcon = document.createElement('img');
        trashIcon.src = 'images/trash_icon.png';
        trashIcon.alt = 'Trash Icon';
        trashIcon.width = 22;

        // Add the click event to delete the size
        trashIcon.addEventListener('click', function() {
            deleteSize(sizeId); // TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
        });

        // Append the trash icon to the new element
        newChangeProductItem.appendChild(trashIcon);

        // Append the new element to the change-product-list
        const changeProductList = document.querySelector(`#edit-form-product${productId} .change-product-list`);
        changeProductList.appendChild(newChangeProductItem);

        document.getElementById("sizeInput" + productId).value = ''

    } catch (error) {
        console.error(error);
    }
}

function searchOrder(){
    const searchInput = document.getElementById('searchOrderInput');
    const ordersList = document.querySelector('.orders-admin-list');

    const searchTerm = searchInput.value.trim().toLowerCase();

    // Loop through each product div and hide/show based on the search term
    Array.from(ordersList.getElementsByClassName('order-admin')).forEach(order => {
        const date = order.dataset.orderDate.toLowerCase();

        if (date.includes(searchTerm)) {
            order.style.display = 'flex';
        } else {
            order.style.display = 'none';
        }
    });
}

async function updateStatus(id) {
    let statusSelect = document.getElementById("statusSelect" + id);
    let selectedStatus = statusSelect.value;

    try {
        let url = "serverActions/updateStatus.php"

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "status=" + selectedStatus + "&orderId=" + id, // Send the data
        });

        console.log(response)

        if (!response.ok) {
            throw new Error("Error deleting the product: " + response.status);
        }

    } catch (error) {
        console.error(error);
    }
}
