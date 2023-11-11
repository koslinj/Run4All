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