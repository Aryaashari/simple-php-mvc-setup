const nameForm = document.getElementById('nameForm');
const emailForm = document.getElementById('emailForm');
const usernameForm = document.getElementById('usernameForm');
const passwordForm = document.getElementById('passwordForm');
const confirmPasswordForm = document.getElementById('confirmPasswordForm');
const pinForm = document.getElementById('pinForm');

nameForm.addEventListener('blur', function () { 
    if (nameForm.nextSibling != null) {
        nameForm.nextSibling.remove();
    }

    if (nameForm.value === '' || nameForm.value === null) {
        nameForm.classList.add('is-invalid');
        nameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Name is required!</div>`);
    } else if(nameForm.value.length < 3) {
        nameForm.classList.add('is-invalid');
        nameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 3 characters!</div>`);
    } else if(nameForm.value.length > 30) {
        nameForm.classList.add('is-invalid');
        nameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Max 30 characters!</div>`);
    } else if(!nameForm.value.match(/^[a-zA-Z\s]*$/)) {
        nameForm.classList.add('is-invalid');
        nameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Name must be alphabet or space!</div>`);
    } else {
        nameForm.classList.remove('is-invalid');
        nameForm.classList.add('is-valid');
    }


 });


emailForm.addEventListener('keyup', function () { 
    if (emailForm.nextSibling != null) {
        emailForm.nextSibling.remove();
    }

    if (emailForm.value === '' || emailForm.value === null) {
        emailForm.classList.add('is-invalid');
        emailForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Email is required!</div>`);
    } else if (!emailForm.value.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
        emailForm.classList.add('is-invalid');
        emailForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Email must be tpye of email!</div>`);
    } else {
        emailForm.classList.remove('is-invalid');
        emailForm.classList.add('is-valid');
    }

});


usernameForm.addEventListener('keyup', function () { 
    if (usernameForm.nextSibling != null) {
        usernameForm.nextSibling.remove();
    }

    if (usernameForm.value === '' || usernameForm.value === null) {
        usernameForm.classList.add('is-invalid');
        usernameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Username is required!</div>`);
    } else if(!usernameForm.value.match(/^[a-zA-Z0-9_]*$/)) {
        usernameForm.classList.add('is-invalid');
        usernameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Please enter a valid username(a-z, A-Z, _)!</div>`);
    } else if(usernameForm.value.length < 3) {
        usernameForm.classList.add('is-invalid');
        usernameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 3 character!</div>`);
    } else if(usernameForm.value.length > 10) {
        usernameForm.classList.add('is-invalid');
        usernameForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Max 10 character!</div>`);
    } else {
        usernameForm.classList.remove('is-invalid');
        usernameForm.classList.add('is-valid');
    }
});

passwordForm.addEventListener('keyup', function () { 
    if (passwordForm.nextSibling != null) {
        passwordForm.nextSibling.remove();
    }

    if (passwordForm.value === '' || passwordForm.value === null) {
        passwordForm.classList.add('is-invalid');
        passwordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Password is required!</div>`);
    } else if(passwordForm.value.length < 8) {
        passwordForm.classList.add('is-invalid');
        passwordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 8 character!</div>`);
    } else {
        passwordForm.classList.remove('is-invalid');
        passwordForm.classList.add('is-valid');
    }
});


confirmPasswordForm.addEventListener('keyup', function () { 
    if (confirmPasswordForm.nextSibling != null) {
        confirmPasswordForm.nextSibling.remove();
    }

    if (confirmPasswordForm.value === '' || confirmPasswordForm.value === null) {
        confirmPasswordForm.classList.add('is-invalid');
        confirmPasswordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Confirm Password is required!</div>`);
    } else if(confirmPasswordForm.value !== passwordForm.value) {
        confirmPasswordForm.classList.add('is-invalid');
        confirmPasswordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Confirm Password is not same with password!</div>`);
    } else if(passwordForm.value.length < 8) {
        confirmPasswordForm.classList.add('is-invalid');
        confirmPasswordForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 8 character!</div>`);
    } else {
        confirmPasswordForm.classList.remove('is-invalid');
        confirmPasswordForm.classList.add('is-valid');
    }
});

pinForm.addEventListener('keyup', function () { 
    if (pinForm.value === '' || pinForm.value === null) {
        if (pinForm.nextSibling != null) {
            pinForm.nextSibling.remove();
        }
        pinForm.classList.add('is-invalid');
        pinForm.insertAdjacentHTML("afterend", `<div class="invalid-feedback">PIN is required!</div>`);
    } else {
        if (pinForm.nextSibling != null) {
            pinForm.nextSibling.remove();
        }
    }
});