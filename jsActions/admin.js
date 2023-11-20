// Function to open the modal
function openModal(productId) {
    document.getElementById("deleteModal_" + productId).style.display = "block";
}

// Function to close the modal
function closeModal(productId) {
    document.getElementById("deleteModal_" + productId).style.display = "none";
}

// Function to confirm delete after user clicks "Yes" in the modal
async function confirmDelete(productId) {
    // Close the modal
    closeModal(productId);

    // Call your deleteProduct function here
    await deleteProduct(productId);
}

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

function validateSizeInput(value) {
    // Regular expression to match numbers or letters S, M, L, X (case-insensitive)
    const pattern = /^[0-9SMLX]+$/i;
    return pattern.test(value);
}

async function insertSize(productId, type) {
    try {
        let url = "serverActions/insertSize.php"

        let sizeInput = document.getElementById("sizeInput" + productId);
        let size = sizeInput.value.trim();

        if (validateSizeInput(size) && size.length > 0) {
            size = encodeURIComponent(size);
        } else {
            return alert("Zła wartość rozmiaru!");
        }

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "productId=" + encodeURIComponent(productId) + "&size=" + size + "&type=" + encodeURIComponent(type),
        });
        console.log(response)

        if (!response.ok) {
            throw new Error("Error inserting size of the product: " + response.status);
        }

        let sizeId = await response.text();
        console.log(sizeId)

        // Create a new change-product-item element
        const newChangeProductItem = document.createElement('div');
        newChangeProductItem.classList.add('change-product-item');
        newChangeProductItem.id = "size-item-" + sizeId
        newChangeProductItem.textContent = size;

        // Create the trash icon
        const trashIcon = document.createElement('img');
        trashIcon.src = 'images/trash_icon.png';
        trashIcon.alt = 'Trash Icon';
        trashIcon.width = 22;

        // Add the click event to delete the size
        trashIcon.addEventListener('click', function() {
            deleteSize(sizeId);
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

function validatePriceInput(value) {
    // Regular expression to match numbers or letters S, M, L, X (case-insensitive)
    const pattern = /^[\d.]+$/i;
    return pattern.test(value);
}

async function updatePrice(productId) {
    try {
        let url = "serverActions/updatePrice.php"

        let priceInput = document.getElementById("priceInput" + productId);
        let price = priceInput.value.trim();

        if (validatePriceInput(price) && price.length>0) {
            price = encodeURIComponent(price);
        } else {
            return alert("Zła wartość ceny!");
        }

        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "productId=" + encodeURIComponent(productId) + "&price=" + price,
        });
        console.log(response)

        if (!response.ok) {
            throw new Error("Error changing price of the product: " + response.status);
        }

        document.getElementById("priceInput" + productId).value = ''
        let priceLabel = document.getElementById("price-label" + productId);
        priceLabel.textContent = "Cena: " + price + "zł";

    } catch (error) {
        console.error(error);
    }
}

function searchOrder(type){
    const searchInput = document.getElementById('searchOrderInput-' + type);
    const ordersList = document.querySelector('.orders-admin-list');

    const searchTerm = searchInput.value.trim().toLowerCase();

    // Loop through each product div and hide/show based on the search term
    Array.from(ordersList.getElementsByClassName('order-admin')).forEach(order => {
        let text;
        if(type === 'date') text = order.dataset.orderDate.toLowerCase();
        else if(type === 'email') text = order.dataset.email.toLowerCase();

        if (text.includes(searchTerm)) {
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
