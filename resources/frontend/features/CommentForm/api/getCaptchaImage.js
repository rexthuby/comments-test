import {backendApiUrl} from "../../../shared/consts/config";
import axios from 'axios'
export const getCaptchaImage = async () => {
    return axios({
            url: '/captcha',
            method: 'get',
            baseURL: backendApiUrl,
        }
    )
}
