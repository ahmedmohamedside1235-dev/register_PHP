let icon = document.querySelector('.eye_pass'),
    inputPassword = document.querySelector('.password input');


function togglePassword(bool) {

    if (bool) {
        inputPassword.setAttribute('type', 'password');
        icon.classList.add('fa-eye-slash');
        icon.classList.remove('fa-eye');
        icon.setAttribute('onclick', 'togglePassword(false)');
        return;
    }

    inputPassword.setAttribute('type', 'text');
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
    icon.setAttribute('onclick', 'togglePassword(true)');
}