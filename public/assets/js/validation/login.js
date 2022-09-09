const usernameForm = document.getElementById("usernameForm");
const passwordForm = document.getElementById("passwordForm");
const btnLogin = document.getElementById("btnLogin");
let isError = true

usernameForm.addEventListener('keyup', () => {

    if (usernameForm.nextSibling != null) {
        usernameForm.nextSibling.remove()
    }

    isError = true

     if (usernameForm.value.length == "" || usernameForm.value.length == null) {
        usernameForm.classList.add('is-invalid');
        usernameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Username is required!</div>`);
      } else {
         usernameForm.classList.remove('is-invalid');
         isError = false
     }

});

passwordForm.addEventListener('keyup', () => {

    if (passwordForm.nextSibling.nextSibling != null) {
        passwordForm.nextSibling.nextSibling.remove()
    }

    isError =  false

     if (passwordForm.value.length == "" || passwordForm.value.length == null) {
        passwordForm.classList.add('is-invalid');
        passwordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Password is required!</div>`);
      } else {
         passwordForm.classList.remove('is-invalid');
         isError = false
     }

});