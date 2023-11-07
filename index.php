<?php
include_once('utils/functions.php');

$currentPage = 'RUN 4 ALL | Strona Główna';
include_once('utils/template.php');
include_once('components/navbar.php');
?>
<main class="index">
    <img src="images/background_small.jpg" alt="Runners On The Beach" width="100%">
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
</main>
<?php
include_once('components/footer.php');
?>
