<section class="filtering">
    <div class="filter-type">
        <div class="filter-title" onclick="toggleContent(this)">
            Kategorie
            <div class="toggle">
                <img src="../images/down_arrow_icon.png" alt="Arrow Icon" width="30px">
            </div>
        </div>
        <div class="content">
            <a href="#" onclick="addQueryParam('category', 'Na asfalt'); return false;">
                Na asfalt
            </a>
            <a href="#" onclick="addQueryParam('category', 'Terenowe'); return false;">
                Terenowe
            </a>
            <a href="#" onclick="addQueryParam('category', 'Startowe'); return false;">
                Startowe
            </a>
            <a href="#" onclick="addQueryParam('category', 'Kolce do sprintu'); return false;">
                Kolce do sprintu
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
            <a href="#" onclick="addQueryParam('producer', 'Nike'); return false;">
                Nike
            </a>
            <a href="#" onclick="addQueryParam('producer', 'Asics'); return false;">
                Asics
            </a>
            <a href="#" onclick="addQueryParam('producer', 'Adidas'); return false;">
                Adidas
            </a>
            <a href="#" onclick="addQueryParam('producer', 'New Balance'); return false;">
                New Balance
            </a>
        </div>
    </div>
    <script src="../components/filtering.js"></script>
</section>