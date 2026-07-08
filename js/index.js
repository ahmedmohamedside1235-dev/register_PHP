function togglePassword(icon, bool) {
    let inputPassword = icon.previousElementSibling;
    if (bool) {
        inputPassword.setAttribute('type', 'password');
        icon.classList.add('fa-eye-slash');
        icon.classList.remove('fa-eye');
        icon.setAttribute('onclick', 'togglePassword(this,false)');
        return;
    }

    inputPassword.setAttribute('type', 'text');
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
    icon.setAttribute('onclick', 'togglePassword(this,true)');
}