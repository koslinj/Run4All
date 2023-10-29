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
