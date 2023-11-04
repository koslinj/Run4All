function checkDeliverers() {
    var radios = document.getElementsByName("deliverers");
    var checked = false;

    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            checked = true;
            break;
        }
    }

    if (!checked) {
        alert("Wybierz dostawcę!");
        return false; // Prevent form submission
    }

    // Form is valid, allow submission
    return true;
}
