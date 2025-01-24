const template = `
<li class="list-item">
    <img src="{{image_url}}" alt="Profile Image" class="profile-image">
    <div class="profile-info">
        <h3 class="name">{{user_name}}</h3>
        <div class="social-links">
            <a href="{{user_ig}}" target="_blank" class="social-link ig-link">Instagram</a>
            <a href="{{user_fb}}" target="_blank" class="social-link fb-link">Facebook</a>
        </div>
    </div>
</li>
`

/**
 *
 * @param userData
 * @return {string}
 */
function replaceTemplate(userData) {
    let templateCopy = template
    templateCopy = templateCopy.replace('{{image_url}}', userData.avatar)
    templateCopy = templateCopy.replace('{{user_name}}', `${userData.name} ${userData.surname}`)
    templateCopy = templateCopy.replace('{{user_fb}}', userData.userProfile.facebookLink)
    templateCopy = templateCopy.replace('{{user_ig}}', userData.userProfile.instagramLink)

    return templateCopy
}

/**
 *
 * @param {array} users
 */
function insertMatchesOnSite(users) {

    const list = document.querySelector('.matches-list')

    users.forEach(user => {
        const replacedTemplate = replaceTemplate(user)
        list.insertAdjacentHTML('beforeend', replacedTemplate)
    })

}

fetch('/api/match/get-matches')
    .then(res => res.json())
    .then(res => {
        insertMatchesOnSite(res.data)
    })