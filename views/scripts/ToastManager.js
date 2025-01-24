export class ToastManager{

    static ERROR = 'toast-error'
    static SUCCESS = 'toast-success'
    constructor() {
        this.toast = document.querySelector('.toast')
        this.toastText = document.querySelector('.toast-text')
        this.closeButton = document.querySelector('.toast-close')

        this.closeButton.addEventListener('click', ()=>{
            this.hideToast()
        })
    }

    /**
     *
     * @param {string} text
     * @param {string} style
     */
    showToast(text, style){
        this.toast.classList.add('visible')
        this.toastText.innerText = text
        this.toast.classList.remove(ToastManager.SUCCESS)
        this.toast.classList.remove(ToastManager.ERROR)
        this.toast.classList.add(style)
        this.toast.classList.remove('hidden')
        this.startToastCloseTimer()
    }

    hideToast(){
        this.toast.classList.add('hidden')
        this.toast.classList.remove('visible')
    }

    startToastCloseTimer(){
        setTimeout(() => {
            this.hideToast()
        }, 3000)
    }

}