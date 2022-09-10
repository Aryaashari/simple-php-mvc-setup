const usernameForm = document.getElementById("usernameForm");
const passwordForm = document.getElementById("passwordForm");
const btnLogin = document.getElementById("btnLogin");
const forgotPasswordBtn = document.getElementById("forgotPasswordBtn");
let isError = true


const usernameFormValidation = (usernameForm) => {

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
    
}

const passwordFormValidation = (passwordForm) => {
    if (forgotPasswordBtn.nextSibling != null) {
        forgotPasswordBtn.nextSibling.remove()
    }

    isError =  true

    if (passwordForm.value.length == "" || passwordForm.value.length == null) {
        passwordForm.classList.add('is-invalid');
        forgotPasswordBtn.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Password is required!</div>`);
    } else {
        passwordForm.classList.remove('is-invalid');
        isError = false
    }

}

usernameForm.addEventListener('keyup', () => {
    usernameFormValidation(usernameForm);
})

passwordForm.addEventListener('keyup', () => {
    passwordFormValidation(passwordForm);
})

btnLogin.addEventListener('mouseover', () => {
    if (!isError) {
        btnLogin.setAttribute('type', 'submit');
    }
});

btnLogin.addEventListener('click', () => {
    usernameFormValidation(usernameForm);
    passwordFormValidation(passwordForm);
})