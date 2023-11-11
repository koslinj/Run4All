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
