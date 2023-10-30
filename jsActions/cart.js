async function addToCart(productId) {
    try {
        const response = await fetch("serverActions/addToCart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded", // Set the appropriate content type
            },
            body: "product_id=" + productId, // Send the data
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

async function changeQuantity(productId, price, type) {
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
            body: "product_id=" + productId, // Send the data
        });

        if (!response.ok) {
            throw new Error("Error adding the product to the cart: " + response.status);
        }

        const quantityElement = document.getElementById("quantity_" + productId);
        const fullElement = document.getElementById("full_" + productId);

        let currentQuantity = parseInt(quantityElement.innerText, 10);
        if (type === 'decrement'){
            currentQuantity--;
        }
        else if(type === 'increment'){
            currentQuantity++;
        }
        if(currentQuantity==0){
            quantityElement.parentElement.remove();
        }
        quantityElement.innerText = currentQuantity;

        fullElement.innerText = `${(currentQuantity * price).toLocaleString('en-US')} zł`;
    } catch (error) {
        console.error(error);
    }
}
