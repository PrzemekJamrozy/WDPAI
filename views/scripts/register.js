import {FormValidator} from "./validation/FormValidation.js";
import {ToastManager} from "./ToastManager.js";

/**
 * @typedef {Object} Inputs
 * @property {string} email
 * @property {string} name
 * @property {string} surname
 * @property {string} email
 * @property {string} password
 * @property {string} passwordAgain
 * @property {string} sex
 */


/**
 *
 * @param {Inputs} formValues
 * @return boolean
 */
function isValidForm(formValues){
    if(!FormValidator.isValidEmail(formValues.email)) {
        new ToastManager().showToast('Podany email jest nieporawny', ToastManager.ERROR)
        return false;
    }

    if(!FormValidator.isValidPassword(formValues.password, formValues.passwordAgain)) {
        new ToastManager().showToast('Hasła nie są identyczne', ToastManager.ERROR)
        return false;
    }

    return true
}

document.querySelector('.register-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const formValues = {}
    const inputs = document.querySelectorAll('.register-form input');
    const sex = document.querySelector('.register-form select');
    inputs.forEach((input) => {
        formValues[input.name] = input.value;
    })

    formValues[sex.name] = sex.value

    if(!isValidForm(formValues)){
        return;
    }


    fetch("/api/register", {
        method: "POST",
        body: JSON.stringify(formValues),
    }).then(response => response.json())
        .then(json => {
            if (json.success) {
                window.location.href = '/login'
            }else{
                new ToastManager().showToast(json.data.message, ToastManager.ERROR)
            }
        })
})