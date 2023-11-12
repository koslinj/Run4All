function sortProducts(option) {
    var productsContainer = document.getElementById('products-container');
    var products = Array.from(productsContainer.getElementsByClassName('product-on-list'));

    products.sort(function(a, b) {
        var aPrice = parseFloat(a.querySelector('.product-price').textContent);
        var bPrice = parseFloat(b.querySelector('.product-price').textContent);

        var aName = a.querySelector('.product-name').textContent.toLowerCase();
        var bName = b.querySelector('.product-name').textContent.toLowerCase();

        if (option === 'priceLowToHigh') {
            return aPrice - bPrice;
        } else if (option === 'priceHighToLow') {
            return bPrice - aPrice;
        } else if (option === 'nameAZ') {
            return aName.localeCompare(bName);
        } else if (option === 'nameZA') {
            return bName.localeCompare(aName);
        }
    });

    products.forEach((product) => {
        productsContainer.appendChild(product);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Retrieve the last selected option from localStorage
    var lastSelectedOption = localStorage.getItem('selectedOption');

    // Set the selected option in the dropdown
    var selectDropdown = document.getElementById('sortDropdown');
    if (lastSelectedOption) {
        selectDropdown.value = lastSelectedOption;
        sortProducts(lastSelectedOption); // Apply initial sorting
    }

    // Add event listener for changes in the dropdown
    selectDropdown.addEventListener('change', function() {
        var selectedOption = selectDropdown.value;

        // Save the selected option to localStorage
        localStorage.setItem('selectedOption', selectedOption);

        // Call the sortProducts function with the selected option
        sortProducts(selectedOption);
    });
});