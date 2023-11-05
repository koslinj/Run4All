function toggleForm(id) {
    const editForm = document.getElementById("edit-form-" + id);

    editForm.style.display = editForm.style.display === "none" ? "flex" : "none";
}

function toggleNewAddressForm(){
    const newAddressForm = document.getElementById("new-address-form");
    const newAddressIcon = document.getElementById("new-address-btn-icon");

    newAddressIcon.src = newAddressForm.style.display === "none" ? "images/back_icon.png" : "images/plus_icon.png"
    newAddressForm.style.display = newAddressForm.style.display === "none" ? "flex" : "none";
}
