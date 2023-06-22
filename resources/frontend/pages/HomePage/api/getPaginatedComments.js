import axios from 'axios';
import {backendApiUrl} from "@/shared/consts/config.js";

export const getPaginatedComments = async (page, sort) => {
    const params = {}
    if (page) {
        params.page = page
    }
    if (sort) {
        params.sort = sort
    }
    return axios({
        url: '/comment',
        method: 'get',
        baseURL: backendApiUrl,
        headers: {'Content-Type': 'application/json'},
        params: params,
    })

}
