const usernameForm = document.getElementById("usernameForm");
const passwordForm = document.getElementById("passwordForm");


usernameForm.addEventListener('keyup', () => {

    if (usernameForm.nextSibling != null) {
        usernameForm.nextSibling.remove()
    }

     if (usernameForm.value.length == "" || usernameForm.value.length == null) {
        usernameForm.classList.add('is-invalid');
        usernameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Username is required!</div>`);
     } else {
        usernameForm.classList.remove('is-invalid');
     }

});

passwordForm.addEventListener('keyup', () => {

    if (passwordForm.nextSibling != null) {
        passwordForm.nextSibling.remove()
    }

     if (passwordForm.value.length == "" || passwordForm.value.length == null) {
        passwordForm.classList.add('is-invalid');
        passwordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Password is required!</div>`);
     } else {
        passwordForm.classList.remove('is-invalid');
     }

});