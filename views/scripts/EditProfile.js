import {FormValidator} from "./validation/FormValidation.js";
import {ToastManager} from "./ToastManager.js";

function isValidForm(formValues){
    if(!FormValidator.isValidEmail(formValues.email)) {
        new ToastManager().showToast('Podany email jest nieporawny', ToastManager.ERROR)
        return false;
    }

    if(!FormValidator.isValidInputs([formValues.fbLink,formValues.igLink,formValues.email,formValues.bio,formValues.password])){
        new ToastManager().showToast('Wszystkie pola przy edycji muszą zostać wypełnione', ToastManager.ERROR)
        return false
    }

    if(formValues.avatar === undefined){
        new ToastManager().showToast('Nie podano zdjęcia', ToastManager.ERROR)
        return false;
    }
    return true
}

document.querySelector('.edit-profile-form').addEventListener('submit', function (e){
    e.preventDefault()

    const formValues = {}

    const inputs = document.querySelectorAll("input:not([type=file])")
    inputs.forEach((input) =>{
        formValues[input.name] = input.value
    })
    const select = document.querySelector('select')
    formValues[select.name] = select.value

    const bio = document.querySelector('textarea')
    formValues[bio.name] = bio.value

    const fileInput = document.querySelector('.edit-profile-avatar')
    formValues[fileInput.name] =  fileInput.files[0]

    if(!isValidForm(formValues)){
        return;
    }

    const formData = new FormData()

    Object.entries(formValues).forEach(([key, value]) => {
        formData.append(key,value)
    })

    fetch('/api/user/edit',{
        method: "POST",
        body: formData
    }).then(res => res.json())
        .then(res => {
            if(!res.success){
                new ToastManager().showToast('Nie udało się zaktualizować użytkownika', ToastManager.ERROR)
                return;
            }
            new ToastManager().showToast('Udało się zaktualizować użytkownika', ToastManager.SUCCESS)
        })
})

document.addEventListener('DOMContentLoaded', function (){
    fetch('/api/user')
        .then(res => res.json())
        .then(res => {
            document.querySelector('input[name=fbLink]').value = res.data.userProfile.facebookLink
            document.querySelector('input[name=igLink]').value = res.data.userProfile.instagramLink
            document.querySelector('input[name=email]').value = res.data.email
            document.querySelector('textarea[name=bio]').value = res.data.userProfile.userBio
            document.querySelector('select').value = res.data.userProfile.preferredSex
        })
})