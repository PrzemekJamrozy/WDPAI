import {ToastManager} from "./ToastManager.js";

let currentOnboardingStep = 1;
const finalOnboardingStep = 5;

// UTILS
/**
 *
 * @param {number} step
 */
function provideStepTranslation(step) {
    switch (step) {
        case 1:
            return 'one'
        case 2:
            return 'two'
        case 3:
            return 'three'
        case 4:
            return 'four'
        case 5:
            return 'five'
    }
}

/**
 *
 * @param {number} step
 * @return {boolean}
 */
function isStepDone(step) {
    switch (step) {
        case 1:
            const isFileUploaded = document.querySelector('.onboarding-input-img').files.length > 0
            if (isFileUploaded) {
                return true
            } else {
                new ToastManager().showToast('Zdjęcie jest wymagane', ToastManager.ERROR)
                return false
            }
        case 2:
            const isBioFilled = document.querySelector('.onboarding-textarea').value.length > 0
            if (isBioFilled) {
                return true
            } else {
                new ToastManager().showToast('Pole jest wymagane', ToastManager.ERROR)
                return false
            }
        case 3:
            const isFbLinkFilled = document.querySelector('.onboarding-fb-link').value.length > 0
            if (isFbLinkFilled) {
                return true
            } else {
                new ToastManager().showToast('Pole jest wymagane', ToastManager.ERROR)
                return false
            }
        case 4:
            const isIgLinkFilled = document.querySelector('.onboarding-ig-link').value.length > 0
            if (isIgLinkFilled) {
                return true
            } else {
                new ToastManager().showToast('Pole jest wymagane', ToastManager.ERROR)
                return false
            }
        case 5:
            return true
    }
}

/**
 *
 * @param {HTMLDivElement} toShow
 * @param {HTMLDivElement} toHide
 */
function swapView(toShow, toHide) {
    toShow.classList.remove('removed')
    toHide.classList.add('removed')
}


//STEP ONE
document.querySelector('.onboarding-input-img').addEventListener('change', function (e) {
    const file = e.target.files[0]
    const reader = new FileReader()
    reader.onload = (event) => {
        document.querySelector('.onboarding-img-preview').src = event.target.result
        document.querySelector('.onboarding-img-preview').classList.remove('removed')
    }
    reader.readAsDataURL(file)
})

//COMMON
document.querySelector('.onboarding-back-btn').addEventListener('click', function () {
    const currentStepElement = document.querySelector(`.onboarding-step-${provideStepTranslation(currentOnboardingStep)}`)
    const previousStepElement = document.querySelector(`.onboarding-step-${provideStepTranslation(currentOnboardingStep - 1)}`)

    swapView(previousStepElement, currentStepElement)

    currentOnboardingStep -= 1

    if (currentOnboardingStep === 1) {
        this.classList.add('removed')
    }

    if (currentOnboardingStep < finalOnboardingStep) {
        document.querySelector('.onboarding-finish-btn').classList.add('removed')
        document.querySelector('.onboarding-next-btn').classList.remove('removed')
    }

})

document.querySelector('.onboarding-next-btn').addEventListener('click', function () {
    // If step was not done correctly disallow to go to next step
    if (!isStepDone(currentOnboardingStep)) {
        return
    }

    const currentStepElement = document.querySelector(`.onboarding-step-${provideStepTranslation(currentOnboardingStep)}`)
    const nextStepElement = document.querySelector(`.onboarding-step-${provideStepTranslation(currentOnboardingStep + 1)}`)


    swapView(nextStepElement, currentStepElement)

    currentOnboardingStep += 1

    document.querySelector('.onboarding-back-btn').classList.remove('removed')

    if (currentOnboardingStep === finalOnboardingStep) {
        document.querySelector('.onboarding-finish-btn').classList.remove('removed')
        this.classList.add('removed')
    }
})

document.querySelector('.onboarding-form').addEventListener('submit', function (e) {
    e.preventDefault()
    const formValues = new FormData()
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        formValues.append(input.name, input.value)
    })
    const fileInput = document.querySelector('.onboarding-input-img')
    formValues.append(fileInput.name, fileInput.files[0])
    const textareaInput = document.querySelector('.onboarding-textarea')
    formValues.append(textareaInput.name, textareaInput.value)
    const selectInput = document.querySelector('.onboarding-sex')
    formValues.append(selectInput.name, selectInput.value)

    fetch('/api/user/onboarding', {
        method: "POST",
        body: formValues
    })
        .then((res) => res.json())
        .then((res) => {
            document.location.reload()
        })
})