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