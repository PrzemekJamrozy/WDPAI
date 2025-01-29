import {ToastManager} from "./ToastManager.js";

let userList = []
const template = `
<div class="user-card">
        <img src="{{avatar_url}}" alt="Avatar">
        <div>
            <p><strong>Imię:</strong> {{user_name}}</p>
            <p><strong>Nazwisko:</strong> {{user_surname}}</p>
            <a href="/admin-edit-profile?user_id={{user_id}}" class="button">Edytuj</a>
            <span class="button admin-delete" data-user-id="{{user_id}}">Usuń</span>
        </div>
    </div>
`

/**
 *
 * @param userData
 * @return string
 */
function replaceTemplate(userData) {
    let templateCopy = template
    templateCopy = templateCopy.replace("{{avatar_url}}", userData.avatar)
    templateCopy = templateCopy.replace("{{user_name}}", userData.name)
    templateCopy = templateCopy.replace("{{user_surname}}", userData.surname)
    templateCopy = templateCopy.replaceAll("{{user_id}}", userData.id)

    return templateCopy
}

function createDeleteEventListener() {
    userList.forEach(user => {
        const deleteButton = document.querySelector(`.admin-delete[data-user-id='${user.id}']`)
        deleteButton.addEventListener('click', function () {
            fetch('/api/admin/delete-user', {
                method: "POST",
                body: JSON.stringify({userId: user.id})
            }).then(res => res.json())
                .then(res => {
                    if(!res.success){
                        new ToastManager().showToast('Wystąpił błąd w trakcie usuwania użytkownika', ToastManager.ERROR)
                        return
                    }
                    new ToastManager().showToast(`Usunięto użytkownika ${user.name} ${user.surname}`)
                    userList.splice(userList.indexOf(user) ,1)
                    injectUsers(userList)
                })
        })
    })
}


/**
 * @param {array} users
 */
function injectUsers(users) {
    const container = document.querySelector('.container')
    container.innerHTML = '<h1>Panel Administratora</h1>'
    users.forEach(user => {
        const userCard = replaceTemplate(user)
        container.insertAdjacentHTML('beforeend', userCard)
    })
    createDeleteEventListener()
}

fetch('/api/admin/users')
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            userList = res.data.users
            injectUsers(res.data.users)
        } else {
            new ToastManager().showToast('Wystąpił błąd przy pobieraniu użytkowników', ToastManager.ERROR)
        }
    })