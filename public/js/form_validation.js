function validateForm() {
    const platform = document.forms["gameForm"]["platform_id"].value;
    if (platform === "") {
        alert("Please select a platform.");
        return false;
    }
    return true;
}
