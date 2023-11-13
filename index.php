<?php
include_once('utils/functions.php');
session_start();

$currentPage = 'RUN 4 ALL | Strona Główna';
include_once('utils/template.php');
include_once('components/navbar.php');
?>
<style>
    .main-slider {
        width: 100%;
        overflow: hidden;
        position: relative;
        height: 400px;
    }

    .main-slider img {
        position: absolute;
    }
</style>
<main class="index">
    <div class="main-slider">
        <img src="images/background.jpg" style="object-fit: cover" alt="Main Image 1" height="400px" width="100%">
        <img src="images/background2.jpg" style="object-fit: cover" alt="Main Image 2" height="400px" width="100%">
        <img src="images/background3.webp" style="object-fit: cover" alt="Main Image 3" height="400px" width="100%">
    </div>
    <h1>Najlepszy sklep sportowy dla biegaczy</h1>
    <p>Chcesz zacząć przygodę z bieganiem?<br>
        A może jesteś zawodowym sportowcem?<br>
        Znajdziesz tutaj wszystko czego potrzebujesz aby rozwijać swoją pasję!
    </p>
    <h2>Buty</h2>
    <div class="product-slider">
        <div class="slider-container">
            <div class="slider">
                <div class="product-slide">
                    <div class="product">
                        <img src="images/products/shoes/asics_gel_pulse_13.webp" alt="Product 1">
                    </div>
                    <div class="product">
                        <img src="images/products/shoes/nike_pegasus_trail_4.webp" alt="Product 2">
                    </div>
                    <div class="product">
                        <img src="images/products/shoes/nike_pegasus_38.webp" alt="Product 3">
                    </div>
                </div>
                <div class="product-slide">
                    <div class="product">
                        <img src="images/products/shoes/asics_novablast_3.webp" alt="Product 4">
                    </div>
                    <div class="product">
                        <img src="images/products/shoes/adidas_galaxy_6.avif" alt="Product 5">
                    </div>
                    <div class="product">
                        <img src="images/products/shoes/adidas_duramo_speed.webp" alt="Product 6">
                    </div>
                </div>
                <!-- Add more product slides as needed -->
            </div>
        </div>
        <button onclick="prevSlide()" class="prev-button">
            <img src="images/left_arrow_icon.png" alt="Left Arrow Icon">
        </button>
        <button onclick="nextSlide()" class="next-button">
            <img src="images/right_arrow_icon.png" alt="Right Arrow Icon">
        </button>
        <a href="../run4all/shoes.php">Zobacz więcej butów</a>
    </div>
    <script src="jsActions/slider.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var interval = 4000; // 5 seconds
            var currentIndex = 0;

            var images = document.querySelectorAll(".main-slider img");
            var totalImages = images.length;

            // Set initial position
            images.forEach(function (image, index) {
                image.style.left = index * 100 + "%";
            });

            // Start the image slider
            setInterval(function () {
                // Move to the next image or loop back to the first one
                currentIndex = (currentIndex + 1) % totalImages;

                // Animate the slider
                images.forEach(function (image, index) {
                    var newPosition = (index - currentIndex) * 100 + "%";
                    image.style.transition = "left 1s";
                    image.style.left = newPosition;
                });
            }, interval);
        });
    </script>
</main>
<?php
include_once('components/footer.php');
?>
