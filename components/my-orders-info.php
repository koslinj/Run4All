<div class="my-orders">
    <?php if(!empty($orders)): ?>
    <h3>Zamówienia</h3>
    <div class="my-orders-container">
        <?php foreach ($orders as $order): ?>
            <div class="order-container">
                <div class="order-general green-bg">
                    <div>
                        <p class="field-type">Data:</p>
                        <p class="field-value"><?= date("Y-m-d", strtotime($order["date"])); ?></p>
                    </div>
                    <div>
                        <p class="field-type">Wartość:</p>
                        <p class="field-value"><?= $order["value"]; ?></p>
                    </div>
                    <div>
                        <p class="field-type">Status:</p>
                        <p class="field-value"><?= $order["status"]; ?></p>
                    </div>
                </div>
                <button id="hide-order-btn-<?= $order['orderId'] ?>"
                        onclick="toggleDetails(<?= $order['orderId'] ?>)">Zobacz szczegóły
                </button>
                <div style="display: none;" id="hidden-order-<?= $order['orderId'] ?>">
                    <h4>Dane Kontaktowe</h4>
                    <div class="order-general">
                        <div>
                            <p class="field-type">Adres:</p>
                            <p class="field-value"><?= $order["town"] ?>
                                , <?= $order["street"] ?> <?= $order["number"] ?>
                            </p>
                        </div>
                        <div>
                            <p class="field-type">Telefon:</p>
                            <p class="field-value"><?= $order["phone"]; ?></p>
                        </div>
                        <div>
                            <p class="field-type">Email:</p>
                            <p class="field-value"><?= $order["email"]; ?></p>
                        </div>
                    </div>
                    <h4>Płatność i Dostawa</h4>
                    <div class="order-general">
                        <div>
                            <p class="field-type">Płatność:</p>
                            <p class="field-value"><?= $order["payment"]; ?></p>
                        </div>
                        <div>
                            <p class="field-type">Dostawca:</p>
                            <p class="field-value"><?= $order["deliverer"]; ?></p>
                        </div>
                    </div>
                    <h4>Produkty</h4>
                    <?php
                    $details = getDetailsByOrderId($order["orderId"]);
                    foreach ($details as $detail): ?>
                        <div class="order-general">
                            <div>
                                <p class="field-type">Nazwa:</p>
                                <p class="field-value"><?= $detail["productName"]; ?></p>
                            </div>
                            <div>
                                <p class="field-type">Ilość:</p>
                                <p class="field-value"><?= $detail["quantity"]; ?></p>
                            </div>
                            <div>
                                <p class="field-type">Rozmiar:</p>
                                <p class="field-value"><?= $detail["size"]; ?></p>
                            </div>
                            <div>
                                <p class="field-type">Cena:</p>
                                <p class="field-value"><?= $detail["price"]; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <h3>Nie masz jeszcze żadnych zamówień !</h3>
    <?php endif; ?>
</div>
