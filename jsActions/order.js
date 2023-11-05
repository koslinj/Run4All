function checkDelivererAndPayment() {
    let deliverers = document.getElementsByName("deliverer");
    let payments = document.getElementsByName("payment");
    let checked;

    checked = false
    for (let i = 0; i < deliverers.length; i++) {
        if (deliverers[i].checked) {
            checked = true;
            break;
        }
    }

    if (!checked) {
        alert("Wybierz dostawcę!");
        return false; // Prevent form submission
    }

    checked = false
    for (let i = 0; i < payments.length; i++) {
        if (payments[i].checked) {
            checked = true;
            break;
        }
    }

    if (!checked) {
        alert("Wybierz sposób płatności!");
        return false; // Prevent form submission
    }

    // Form is valid, allow submission
    return true;
}
