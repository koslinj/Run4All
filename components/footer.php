<footer class="footer">
    <div class="top">
        <div class="item">
            <img src="../images/footer/delivery_icon.png" alt="Delivery Truck Icon" height="24">
            Darmowa dostawa powyżej 300 zł
        </div>
        <div class="item">
            <img src="../images/footer/repeat_icon.png" alt="Repeat Icon" height="24">
            30 dni na zwrot
        </div>
        <div class="item">
            <img src="../images/footer/money_icon.png" alt="Money Icon" height="24">
            Różne metody płatności
        </div>
        <div class="item">
            <img src="../images/footer/secure_icon.png" alt="Secure Icon" height="24">
            Bezpieczne zakupy
        </div>
    </div>
    <div class="down">
        <div class="info-section">
            <h3>Pomoc</h3>
            <ul>
                <li>Zwrot i wymiana</li>
                <li>Dostawa</li>
                <li>Płatności</li>
                <li>Reklamacje</li>
                <li>Wycofane produkty</li>
                <li>Regulamin</li>
                <li>Informacje prawne</li>
                <li>Program Ochrony Kupujących</li>
            </ul>
        </div>
        <div class="info-section">
            <h3>Usługi</h3>
            <ul>
                <li>Zakupy na raty</li>
                <li>Leasing</li>
                <li>Karty podarunkowe</li>
                <li>Program lojalnościowy</li>
                <li>Oferta dla firm</li>
                <li>Marketplace</li>
            </ul>
        </div>
        <div class="info-section">
            <h3>O nas</h3>
            <ul>
                <li>Kariera</li>
                <li>O Run4All</li>
                <li>Kim jesteśmy</li>
                <li>Jak to robimy</li>
                <li>Dane osobowe</li>
                <li>Biuro prasowe</li>
                <li>Afiliacja</li>
            </ul>
        </div>
        <div class="info-section">
            <h3>Kupuj bezpiecznie</h3>
            <ul>
                <?php
                $payments = getAllPayments();
                foreach ($payments as $payment): ?>
                    <li>
                        <?= $payment["payment"] ?>
                        <img src="<?= $payment["path"] ?>" alt="<?= $payment["payment"] ?> Logo" width="36px">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="info-section">
            <h3>Dostarczamy</h3>
            <ul>
                <?php
                $deliverers = getAllDeliverers();
                foreach ($deliverers as $deliverer): ?>
                    <li>
                        <?= $deliverer["deliverer"] ?>
                        <img src="<?= $deliverer["path"] ?>" alt="<?= $deliverer["deliverer"] ?> Logo" width="50px">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</footer>
