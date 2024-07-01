function validateAdminForm() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        alert("Las contraseñas no coinciden.");
        return false;
    }
    return true;
}
