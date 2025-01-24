import {FormValidator} from "./validation/FormValidation.js";
import {ToastManager} from "./ToastManager.js";
document.querySelector(".login-form").addEventListener("submit", (e) => {
    e.preventDefault();
    const formValues = {}
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        formValues[input.name] = input.value;
    })

    if (!FormValidator.isValidEmail(formValues.email) || !FormValidator.isValidInputs(formValues)) {
        return
    }


    fetch("/api/login", {
        method: "POST",
        body: JSON.stringify(formValues),
    })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                window.location.href = '/'
            }
            else {
                new ToastManager().showToast('Niepoprawne hasło lub email',ToastManager.ERROR)
            }
        })
})