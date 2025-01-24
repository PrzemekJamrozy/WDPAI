import {ToastManager} from "./ToastManager.js";

let users = []

function setUserProfile(userData) {
    if(userData === undefined){
        document.querySelector('.user-image').src = 'uploads/placeholder.png'
        document.querySelector('.username').innerText = "To wszystko"
        document.querySelector('.bio').innerText = "Na ten moment nie ma więcej osób których moglibyśmy Ci pokazać :("
        return
    }
    document.querySelector('.user-image').src = userData.avatar
    document.querySelector('.username').innerText = `${userData.name} ${userData.surname}`
    document.querySelector('.bio').innerText = userData.userProfile.userBio

}

fetch('/api/match/get-potential-matches')
    .then(res => res.json())
    .then((res) => {
        users = res.data
        setUserProfile(users[0])
    })


document.querySelector('.reject-button').addEventListener('click', function () {
    users.shift()
    setUserProfile(users[0])
})

document.querySelector('.accept-button').addEventListener('click', function () {
    const user = users[0]
    if(user === undefined){
        return
    }

    fetch('/api/match/accept-match',{
        method:"POST",
        body: JSON.stringify({userId: user.id})
    }).then(res => res.json())
        .then(res => {
            if(res.success){
                users.shift()
                setUserProfile(users[0])
            }else{
                new ToastManager().showToast('Wystąpił błąd przy dawaniu polubienia', ToastManager.ERROR)
            }
        })
})