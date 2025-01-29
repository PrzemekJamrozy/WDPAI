import {ToastManager} from "./ToastManager.js";

function setUserProfile(userData){
    document.querySelector('.user__profile-avatar').src = userData.avatar
    document.querySelector('.user__profile-name').innerHTML = `<strong>Imię:</strong> ${userData.name}`
    document.querySelector('.user__profile-surname').innerHTML = `<strong>Nazwisko:</strong> ${userData.surname}`
    document.querySelector('.user__profile-email').innerHTML = `<strong>Email:</strong> ${userData.email}`
    document.querySelector('.user__profile-sex').innerHTML = `<strong>Płeć:</strong> ${userData.sex === 'MALE' ? "Mężczyzna" : "Kobieta"}`
}

fetch('/api/user')
.then(res => res.json())
.then(res => {
    setUserProfile(res.data)
})

document.querySelector('.delete-account').addEventListener('click', function (e){
    e.preventDefault()

    fetch('/api/user/delete',{
        method:"POST"
    }).then(res => res.json())
        .then(res => {
            if(!res.success){
                new ToastManager().showToast('Wystąpił błąd podczas usuwania konta', ToastManager.ERROR)
                return
            }
            new ToastManager().showToast('Udało się usunąć konto. Wylogowanie nastąpi za 2 sekundy', ToastManager.SUCCESS)
            setTimeout(()=>{
                window.location.href = '/';
            }, 2000)
        })
})