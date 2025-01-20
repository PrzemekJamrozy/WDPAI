function validateEmail(email) {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

document.querySelector('.form-register').addEventListener('submit', function (event) {
    event.preventDefault();
    const formValues = {}
    const inputs = document.querySelectorAll('.form-register input');
    const sex = document.querySelector('.form-register select');
    inputs.forEach((input) => {
        formValues[input.name] = input.value;
    })

    formValues[sex.name] = sex.value

    if(!validateEmail(formValues.email)) {
        return;
    }

    fetch("/api/register", {
        method: "POST",
        body: JSON.stringify(formValues),
    }).then(response => response.json())
        .then(json => {
            if (json.success) {
                console.log("register success");
            }else{
                console.log(json.data.message);
            }
        })
})