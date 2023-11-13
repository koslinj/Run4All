<nav class="navbar">
    <div class="first-nav">
        <a href="../../run4all/index.php">
            <img class="main-logo" src="../images/navbar/RUN4ALL.png" alt="Shop Logo" width="230px">
        </a>
        <div class="nav-icons">
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] === 'user'): ?>
                    <a href="../../run4all/account.php">
                        <div class="account">
                            <img src="../images/navbar/account_icon.png" alt="Account Icon" width="30px">
                            Moje Konto
                        </div>
                    </a>
                    <a href="../../run4all/cart.php">
                        <div class="cart">
                            <img src="../images/navbar/cart_icon.png" alt="Cart Icon" width="30px">
                            Koszyk
                        </div>
                    </a>
                <?php else: ?>
                    <a href="../../run4all/account.php">
                        <div class="account">
                            <img src="../images/admin_icon.png" alt="Admin Icon" width="40px">
                            Panel
                        </div>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="../../run4all/account.php">
                    <div class="account">
                        <img src="../images/navbar/account_icon.png" alt="Account Icon" width="30px">
                        Moje Konto
                    </div>
                </a>
                <a href="../../run4all/cart.php">
                    <div class="cart">
                        <img src="../images/navbar/cart_icon.png" alt="Cart Icon" width="30px">
                        Koszyk
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="second-nav">
        <a href="../../run4all/shoes.php">
            <div class="nav-category">
                Buty
            </div>
        </a>
        <a href="../../run4all/clothes.php">
            <div class="nav-category">
                Ubrania
            </div>
        </a>
        <a href="">
            <div class="nav-category">
                Akcesoria
            </div>
        </a>
        <a href="">
            <div class="nav-category">
                Wyprzedaż
            </div>
        </a>
    </div>
</nav>