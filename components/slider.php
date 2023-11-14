<div class="product-slider">
    <div class="slider-container">
        <div class="slider slider<?= $num ?>">
            <div class="product-slide product-slide<?= $num ?>">
                <?php for($i = 0; $i<3; $i++): ?>
                    <div class="product">
                        <a href="product.php?productName=<?= urlencode($sliders[$i]['productName']) ?>">
                            <img src="<?= $sliders[$i]['path'] ?>" alt="Product <?= $sliders[$i]['productId'] ?>">
                            <div class="link-from-slider"><?= $sliders[$i]['productName'] ?></div>
                        </a>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="product-slide product-slide<?= $num ?>">
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
    <button onclick="slider<?= $num ?>.prevSlide()" class="prev-button">
        <img src="images/left_arrow_icon.png" alt="Left Arrow Icon">
    </button>
    <button onclick="slider<?= $num ?>.nextSlide()" class="next-button">
        <img src="images/right_arrow_icon.png" alt="Right Arrow Icon">
    </button>
    <?php if($num == 1): ?>
        <a href="../run4all/shoes.php">Zobacz więcej butów</a>
    <?php elseif ($num == 2): ?>
        <a href="../run4all/clothes.php">Zobacz więcej ubrań</a>
    <?php else: ?>
        <a href="../run4all/accessories.php">Zobacz więcej akcesoriów</a>
    <?php endif; ?>
</div>
