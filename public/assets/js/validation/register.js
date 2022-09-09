const nameForm = document.getElementById('nameForm');
const emailForm = document.getElementById('emailForm');
const usernameForm = document.getElementById('usernameForm');
const passwordForm = document.getElementById('passwordForm');
const confirmPasswordForm = document.getElementById('confirmPasswordForm');
const pinForm = document.getElementById('pinForm');
const btnNext = document.getElementById('btnNext');
const btnBack = document.getElementById('btnBack');
const registerBtn = document.getElementById('registerBtn');

let profileSectionIsError = true;
let pinSectionIsError = true;

function nameFormValidation(form) {
    if (form.nextSibling != null) {
        form.nextSibling.remove();
    }

    profileSectionIsError = true;
    if (form.value === '' || form.value === null) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Name is required!</div>`);
    } else if(form.value.length < 3) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 3 characters!</div>`);
    } else if(form.value.length > 30) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Max 30 characters!</div>`);
    } else if(!form.value.match(/^[a-zA-Z\s]*$/)) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Name must be alphabet or space!</div>`);
    } else {
        form.classList.remove('is-invalid');
        form.classList.add('is-valid');
        profileSectionIsError = false;
    }
}

nameForm.addEventListener('keyup', function () { 
    
    nameFormValidation(nameForm);

 });




function emailFormValidation(form) {
    if (form.nextSibling != null) {
        form.nextSibling.remove();
    }
    profileSectionIsError = true;
    if (form.value === '' || form.value === null) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Email is required!</div>`);
    } else if (!form.value.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Email must be tpye of email!</div>`);
    } else {
        form.classList.remove('is-invalid');
        form.classList.add('is-valid');
        profileSectionIsError = false;
    }
}

emailForm.addEventListener('keyup', function () { 
    emailFormValidation(emailForm);
});



function usernameFormValidation(form) {
    if (form.nextSibling != null) {
        form.nextSibling.remove();
    }

    profileSectionIsError = true;

    if (form.value === '' || form.value === null) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Username is required!</div>`);
    } else if(!form.value.match(/^[a-zA-Z0-9_]*$/)) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Please enter a valid username(a-z, A-Z, _)!</div>`);
    } else if(form.value.length < 3) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 3 character!</div>`);
    } else if(form.value.length > 10) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Max 10 character!</div>`);
    } else {
        form.classList.remove('is-invalid');
        form.classList.add('is-valid');
        profileSectionIsError = false;
    }
}

usernameForm.addEventListener('keyup', function () { 
    usernameFormValidation(usernameForm);
    
});



function passwordFormValidation(form) {
    if (form.nextSibling != null) {
        form.nextSibling.remove();
    }

    profileSectionIsError = true;

    if (form.value === '' || form.value === null) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Password is required!</div>`);
    } else if(form.value.length < 8) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 8 character!</div>`);
    } else {
        form.classList.remove('is-invalid');
        form.classList.add('is-valid');
        profileSectionIsError = false;
    }
}

passwordForm.addEventListener('keyup', function () { 
    passwordFormValidation(passwordForm);
    
});



function confirmPasswordFormValidation(form) {
    if (form.nextSibling != null) {
        form.nextSibling.remove();
    }

    profileSectionIsError = true;

    if (form.value === '' || form.value === null) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Confirm Password is required!</div>`);
    } else if(form.value.length < 8) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Min 8 character!</div>`);
    } else if(form.value !== passwordForm.value) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Confirm Password is not same with password!</div>`);
    } else {
        form.classList.remove('is-invalid');
        form.classList.add('is-valid');
        profileSectionIsError = false;
    }
}

confirmPasswordForm.addEventListener('keyup', function () { 
    confirmPasswordFormValidation(confirmPasswordForm);
    
});


function pinFormValidation(form) {
    if (form.nextSibling != null) {
        form.nextSibling.remove();
    }

    pinSectionIsError = true;

    if (form.value === '' || form.value === null) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">PIN is required!</div>`);
        btnBack.removeAttribute('onclick');
        registerBtn.setAttribute('type', 'button');
    } else if(!form.value.match(/^[0-9]*$/)) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">PIN is must be integer!</div>`);
        btnBack.removeAttribute('onclick');
        registerBtn.setAttribute('type', 'button');
    } else if(form.value.length != 6) {
        form.classList.add('is-invalid');
        form.insertAdjacentHTML("afterend", `<div class="invalid-feedback">PIN must be 6 characters!</div>`);
        btnBack.removeAttribute('onclick');
        registerBtn.setAttribute('type', 'button');
    } else {
        form.classList.remove('is-invalid');
        form.classList.add('is-valid');
        pinSectionIsError = false;
    }
}

pinForm.addEventListener('keyup', function () { 
    pinFormValidation(pinForm);
});


btnNext.addEventListener('mouseover', function() {
    if (!profileSectionIsError) {
        btnNext.setAttribute('onclick', 'pinSectionAction()');
    } else {
        btnNext.removeAttribute('onclick');
    }
});

btnNext.addEventListener('click', function() {
    nameFormValidation(nameForm);
    emailFormValidation(emailForm);
    usernameFormValidation(usernameForm);
    passwordFormValidation(passwordForm);
    confirmPasswordFormValidation(confirmPasswordForm);
});

btnBack.addEventListener('mouseover', function() {
    if (!pinSectionIsError) {
        btnBack.setAttribute('onclick', 'profileSectionAction()');
    }
});

btnBack.addEventListener('click', function() {
    pinFormValidation(pinForm);
});

registerBtn.addEventListener('mouseover', function() {
    if (!pinSectionIsError) {
        registerBtn.setAttribute('type', 'submit');
    }
});

registerBtn.addEventListener('click', function() {
    pinFormValidation(pinForm);
});