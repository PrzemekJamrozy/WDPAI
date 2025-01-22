/**
 * @typedef {Object} Inputs
 * @property {string} [key:string]
 */


export class FormValidator {
    /**
     *
     * @param {string} email
     */
    static isValidEmail(email) {
        return email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    }

    /**
     *
     * @param {Inputs} inputs
     */
    static isValidInputs(inputs){
        return Object.values(inputs).every((input) => input.length > 0);
    }

    /**
     *
     * @param {string} password
     * @param {string} passwordAgain
     */
    static isValidPassword(password, passwordAgain){
        return password === passwordAgain
    }
}
