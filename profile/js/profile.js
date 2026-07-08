let popups = document.querySelectorAll('.popup'),
    boxs = document.querySelectorAll('.popup .box'),
    html = document.querySelector('html'),
    popupName = new URLSearchParams(window.location.search).get('update') ?? false,
    bool = new URLSearchParams(window.location.search).get('bool') ?? "noUpdate";

console.log(popupName, bool);

popups.forEach(popup => {
    popup.addEventListener('click', function (e) {
        closePopup();
    });
});

boxs.forEach(box => {
    box.addEventListener('click', function (e) {
        e.stopPropagation();
    });
});


if (popupName) {
    openPopup(`${popupName}`);
    let url = new URL(window.location);
    url.searchParams.delete('update');
    window.history.replaceState({}, document.title, url.pathname + url.search);
}

if (bool === "updated") {
    showAlert();
}

function showAlert() {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        iconColor: '#4ade80',
        title: 'Profile updated successfully',
        backgroundColor: "#0000",
        showConfirmButton: false,
        background: '#2c2c2a',
        color: '#fff',
        timer: 3000,
        timerProgressBar: true
    });
    let url = new URL(window.location);
    console.log(url, document.title);
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