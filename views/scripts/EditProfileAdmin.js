import {FormValidator} from "./validation/FormValidation.js";
import {ToastManager} from "./ToastManager.js";

let allowedPerms = []
function isValidForm(formValues) {
    if (!FormValidator.isValidEmail(formValues.email)) {
        new ToastManager().showToast('Podany email jest nieporawny', ToastManager.ERROR)
        return false;
    }

    if (!FormValidator.isValidInputs([formValues.fbLink, formValues.igLink, formValues.email, formValues.bio, formValues.password, formValues.permissions])) {
        new ToastManager().showToast('Wszystkie pola przy edycji muszą zostać wypełnione', ToastManager.ERROR)
        return false
    }

    // if in permission input is permission not allowed in system disallow it
    if(!formValues.permissions.split(',').every((value) =>{
        return allowedPerms.map(el => el.permissionName).includes(value)
    })){
        new ToastManager().showToast('Podane uprawnienia nie są zgodne z systemowymi', ToastManager.ERROR)
        return false;
    }

    if (formValues.avatar === undefined) {
        new ToastManager().showToast('Nie podano zdjęcia', ToastManager.ERROR)
        return false;
    }
    return true
}

document.querySelector('.edit-profile-form').addEventListener('submit', function (e) {
    e.preventDefault()

    const userId = new URLSearchParams(window.location.search).get("user_id")

    if (userId === null) {
        new ToastManager().showToast('Nie można zaktualizować użytkownika bez jego id', ToastManager.ERROR)
        return
    }

    const formValues = {
        userId: userId
    }

    const inputs = document.querySelectorAll("input:not([type=file])")
    inputs.forEach((input) => {
        formValues[input.name] = input.value
    })
    const select = document.querySelector('select')
    formValues[select.name] = select.value

    const bio = document.querySelector('textarea')
    formValues[bio.name] = bio.value

    const fileInput = document.querySelector('.edit-profile-avatar')
    formValues[fileInput.name] = fileInput.files[0]


    if (!isValidForm(formValues)) {
        return;
    }
    //Map input text input to permission objects
    formValues.permissions = formValues.permissions.split(',').map((permName) => allowedPerms.find((perm) => perm.permissionName === permName).id)

    const formData = new FormData()

    Object.entries(formValues).forEach(([key, value]) => {
        if(key === "permissions"){
            formData.append(key,JSON.stringify(value))
            return;
        }
        formData.append(key, value)
    })

    console.log(formValues)

    fetch('/api/admin/update-user', {
        method: "POST",
        body: formData
    }).then(res => res.json())
        .then(res => {
            if (!res.success) {
                new ToastManager().showToast('Nie udało się zaktualizować użytkownika', ToastManager.ERROR)
                return;
            }
            new ToastManager().showToast('Udało się zaktualizować użytkownika', ToastManager.SUCCESS)
        })
})

document.addEventListener('DOMContentLoaded', function () {
    const userId = new URLSearchParams(window.location.search).get("user_id")

    if (userId === null) {
        new ToastManager().showToast('Nie można pobrać informacji o użytkowniku', ToastManager.ERROR)
        return
    }

    fetch('/api/admin/user?user_id=' + userId)
        .then(res => res.json())
        .then(res => {
            if (!res.success) {
                new ToastManager().showToast('Coś poszło nie tak przy pobieraniu użytkownika', ToastManager.ERROR)
                return
            }
            document.querySelector('input[name=fbLink]').value = res.data.userProfile.facebookLink
            document.querySelector('input[name=igLink]').value = res.data.userProfile.instagramLink
            document.querySelector('input[name=email]').value = res.data.email
            document.querySelector('textarea[name=bio]').value = res.data.userProfile.userBio
            document.querySelector('select').value = res.data.userProfile.preferredSex
            document.querySelector('input[name=permissions]').value = res.data.permissions.reduce((acc, val) => acc + val.permissionName + ',', '').slice(0,-1);
        })

    fetch('/api/admin/permissions')
        .then(res => res.json())
        .then(res => {
            allowedPerms = res.data
            document.querySelector('.allowed-perms').innerText += res.data.reduce((acc,val) => acc+ val.permissionName + ', ','').slice(0,-2)
        })
})