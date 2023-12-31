function toggleForm(id) {
    const editForm = document.getElementById("edit-form-" + id);

    editForm.style.display = editForm.style.display === "none" ? "flex" : "none";
}

function toggleContactForm(id, type) {
    const editForm = document.getElementById("edit-form-" + type + id);

    editForm.style.display = editForm.style.display === "none" ? "flex" : "none";
}

function toggleNewAddressForm(){
    const newAddressForm = document.getElementById("new-address-form");
    const newAddressIcon = document.getElementById("new-address-btn-icon");

    newAddressIcon.src = newAddressForm.style.display === "none" ? "images/back_icon.png" : "images/plus_icon.png"
    newAddressForm.style.display = newAddressForm.style.display === "none" ? "flex" : "none";
}

function toggleNewContactForm(type){
    const newContactForm = document.getElementById("new-" + type + "-form");
    const newContactIcon = document.getElementById("new-" + type + "-btn-icon");

    newContactIcon.src = newContactForm.style.display === "none" ? "images/back_icon.png" : "images/plus_icon.png"
    newContactForm.style.display = newContactForm.style.display === "none" ? "flex" : "none";
}

function toggleDetails(id) {
    const details = document.getElementById("hidden-order-" + id);
    const btn = document.getElementById("hide-order-btn-" + id);

    btn.innerText = details.style.display === "none" ? "Ukryj szczegóły" : "Zobacz szczegóły";
    details.style.display = details.style.display === "none" ? "block" : "none";
}
