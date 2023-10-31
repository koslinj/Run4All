async function addToCart(productId) {
    try {
        let sizeSelect = document.getElementById("size");
        let chosenSize = sizeSelect.value;
        const response = await fetch("serverActions/addToCart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "product_id=" + productId + "&size=" + chosenSize, // Send the data
        });

        if (!response.ok) {
            throw new Error("Error adding the product to the cart: " + response.status);
        }

        const data = await response.text();
        console.log(data)
    } catch (error) {
        console.error(error);
    }
}

async function changeQuantity(productId, price, size, type) {
    try {
        let url = "serverActions/removeFromCart.php"
        if(type === 'increment'){
            url = "serverActions/addToCart.php"
        }
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "product_id=" + productId + "&size=" + size, // Send the data
        });

        if (!response.ok) {
            throw new Error("Error adding the product to the cart: " + response.status);
        }

        const quantityElement = document.getElementById("quantity_" + productId + size);
        const fullElement = document.getElementById("full_" + productId + size);

        let currentQuantity = parseInt(quantityElement.innerText, 10);
        if (type === 'decrement'){
            currentQuantity--;
        }
        else if(type === 'increment'){
            currentQuantity++;
        }
        if(currentQuantity===0){
            quantityElement.parentElement.parentElement.remove();
        }
        quantityElement.innerText = currentQuantity;

        fullElement.innerText = `${(currentQuantity * price).toLocaleString('en-US')} zł`;
    } catch (error) {
        console.error(error);
    }
}
