function validatePassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("password_confirmation").value;
    var errorElement = document.getElementById("passwordError");

    // Reset pesan error
    errorElement.style.display = "none";
    errorElement.textContent = "";  // Kosongkan pesan error sebelumnya

    // Cek panjang password
    if (password.length < 8) {
        errorElement.style.display = "block";
        errorElement.textContent = "Password must be at least 8 characters long.";
        return false; // Mencegah form submission
    }

    // Cek apakah password dan konfirmasi password cocok
    if (password !== confirmPassword) {
        errorElement.style.display = "block";
        errorElement.textContent = "Passwords do not match.";
        return false; // Mencegah form submission
    }

    return true; // Izinkan form submission jika valid
}