/**
 *
 * @param {string} email
 */
function validateEmail(email) {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}


document.querySelector(".login-form").addEventListener("submit", (e) => {
    e.preventDefault();
    const formValues = {}
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        formValues[input.name] = input.value;
    })

    const isValidEmail = validateEmail(formValues.email);
    if (!isValidEmail) {
        return
    }

    fetch("/api/login", {
        method: "POST",
        body: JSON.stringify(formValues),
    })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                console.log("działa");
            }
            else {
                console.log(json.data.message);
            }
        })
})