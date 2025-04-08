window.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('click', function (event) {
        const toggle = document.getElementById('profil-toggle');
        const label = document.querySelector('.profil-label');

        if (label = false) {
            toggle.checked = true;
        }
        else {
            toggle.checked = false;
        }
    });
});
