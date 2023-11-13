<?php
include_once('utils/functions.php');
session_start();

$currentPage = 'RUN 4 ALL | Strona Główna';
include_once('utils/template.php');
include_once('components/navbar.php');

$sliders = getAllSliders()
?>
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
                    <?php for($i = 0; $i<3; $i++): ?>
                        <div class="product">
                            <a href="product.php?productName=<?= urlencode($sliders[$i]['productName']) ?>">
                                <img src="<?= $sliders[$i]['path'] ?>" alt="Product <?= $sliders[$i]['productId'] ?>">
                                <div class="link-from-slider"><?= $sliders[$i]['productName'] ?></div>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="product-slide">
                    <?php for($i = 3; $i<6; $i++): ?>
                        <div class="product">
                            <a href="product.php?productName=<?= urlencode($sliders[$i]['productName']) ?>">
                                <img src="<?= $sliders[$i]['path'] ?>" alt="Product <?= $sliders[$i]['productId'] ?>">
                                <div class="link-from-slider"><?= $sliders[$i]['productName'] ?></div>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
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
