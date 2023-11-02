function toggleForm(id) {
    const editForm = document.getElementById("edit-form-" + id);

    editForm.style.display = editForm.style.display === "none" ? "flex" : "none";
}