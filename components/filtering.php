<section class="filtering">
    <div class="filter-type">
        <div class="filter-title" onclick="toggleContent(this)">
            Kategorie
            <div class="toggle">
                <img src="../images/down_arrow_icon.png" alt="Arrow Icon" width="30px">
            </div>
        </div>
        <div class="content">
            <?php foreach ($categories as $category): ?>
                <a href="#" onclick="addQueryParam('category', '<?= $category["category"] ?>'); return false;">
                    <?= $category["category"] ?>
                </a>
            <?php endforeach; ?>
            <a class="clear-filtering" href="#" onclick="addQueryParam('category', 'clear'); return false;">
                Wyczyść
            </a>
        </div>
    </div>
    <div class="filter-type">
        <div class="filter-title" onclick="toggleContent(this)">
            Producenci
            <div class="toggle">
                <img src="../images/down_arrow_icon.png" alt="Arrow Icon" width="30px">
            </div>
        </div>
        <div class="content">
            <?php $producers = getAllProducers(); ?>
            <?php foreach ($producers as $producer): ?>
                <a href="#" onclick="addQueryParam('producer', '<?= $producer["producer"] ?>'); return false;">
                    <?= $producer["producer"] ?>
                </a>
            <?php endforeach; ?>
            <a class="clear-filtering" href="#" onclick="addQueryParam('producer', 'clear'); return false;">
                Wyczyść
            </a>
        </div>
    </div>
    <div class="filter-type">
        <div class="filter-title" onclick="toggleContent(this)">
            Rozmiary
            <div class="toggle">
                <img src="../images/down_arrow_icon.png" alt="Arrow Icon" width="30px">
            </div>
        </div>
        <div class="content">
            <?php foreach ($sizes as $size): ?>
                <a href="#" onclick="addQueryParam('size', '<?= $size["size"] ?>'); return false;">
                    <?= $size["size"] ?>
                </a>
            <?php endforeach; ?>
            <a class="clear-filtering" href="#" onclick="addQueryParam('size', 'clear'); return false;">
                Wyczyść
            </a>
        </div>
    </div>
    <script src="../jsActions/filtering.js"></script>
</section>