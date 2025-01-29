document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');

    hamburger.addEventListener('click', function () {
        mobileMenu.classList.toggle('active');
    });

    const adminPanelIcon = document.querySelector('.admin-panel')
    const adminPanelMobile = document.querySelector('.admin-panel-mobile')

    fetch('/api/user')
        .then(res => res.json())
        .then(res => {
            const {permissions} = res.data
            const requiredPerm = permissions.filter((value) => value.permissionName === "PERMISSION_ADMIN")

            if(requiredPerm.length === 0){
                adminPanelIcon.remove()
                adminPanelMobile.remove()
            }
        })
});

function logout(){
    fetch('/api/logout',{method:"POST"})
        .then(res => res.json())
        .then(res =>{
            window.location.href = '/'
        })
}
document.querySelector('.logout').addEventListener('click', function (){
   logout()
})

document.querySelector('.logout-mobile').addEventListener('click', function (){
    logout()
})