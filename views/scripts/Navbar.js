document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');

    hamburger.addEventListener('click', function () {
        mobileMenu.classList.toggle('active');
    });
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