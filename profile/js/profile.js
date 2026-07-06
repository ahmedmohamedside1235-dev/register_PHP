let popup = document.querySelector('.popup'),
    box = document.querySelector('.popup .box'),
    html = document.querySelector('html'),
    bool = Boolean(new URLSearchParams(window.location.search).get('update')) ?? false,
    update = new URLSearchParams(window.location.search).get('bool') ?? "noUpdate";

    console.log(update);
    
console.log();


popup.addEventListener('click', function (e) {
    closePopup();
});

box.addEventListener('click', function (e) {
    e.stopPropagation();
});

if (bool) {
    openPopup('profile');
}

if (update === "updated") {
    showAlert()
}

function showAlert() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        iconColor: '#4ade80',
        title: 'Profile updated successfully',
        backgroundColor : "#0000",
        showConfirmButton: false,
        background: '#2c2c2a',
        color: '#fff',
        timer: 3000,
        timerProgressBar: true
    });
    let url = new URL(window.location);
    console.log(url, document.title );
    url.searchParams.delete('bool');
    window.history.replaceState({}, document.title, url.pathname + url.search);
}
function openPopup(popupName) {
    const popup = document.querySelector(`.popup[data-name="${popupName}"]`);
    if (popup) {
        popup.classList.add('active');
        html.classList.add('hide-scroll');
    }
    setTimeout(() => {
        popup.classList.add('show');
    }, 100);
}

function closePopup() {
    const popup = document.querySelector('.popup.active');
    if (popup) {
        popup.classList.remove('show');
    }

    setTimeout(() => {
        popup.classList.remove('active');
        html.classList.remove('hide-scroll');
    }, 500);
}