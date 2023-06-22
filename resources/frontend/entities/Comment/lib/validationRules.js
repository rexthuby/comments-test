import {email, helpers, maxLength, minLength, required, url} from "@vuelidate/validators";
import {supportedFileExtension} from "../consts/supportedFileExtension.js";
import mime2ext from "mime2ext";
import * as sanitizeHtml from 'sanitize-html';

const mimeTypeRule = (value) => {
    if (!value){
        return true
    }
    return supportedFileExtension.includes('.'+mime2ext(value.type))
}

const isTextValid = (value) => {
    return value === sanitizeHtml(value, {
        allowedTags: ['a', 'code', 'i', 'strong'],
        allowedAttributes: {
            'a': ['href', 'title']
        }
    })
};

export const usernameRule = {
    required,
    minLength: minLength(3),
    maxLength: maxLength(20)
};

export const urlRule = {
    url
}

export const captchaRule = {
    required,
}

export const emailRule = {
    required,
    email
}

export const textRule = {
    required,
    isTagCorrect: helpers.withMessage('Text not correct', isTextValid)
}

export const fileRule = {
    mimeTypeRule: helpers.withMessage('File must be: ' + supportedFileExtension.join(''), mimeTypeRule)
}
