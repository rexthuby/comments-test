import axios from "axios";
import {backendApiUrl} from "../../../shared/consts/config.js";

export const storeComment = async (commentData)=>{
    console.log(commentData)
    return axios({
            url: '/comment',
            method: 'post',
            baseURL: backendApiUrl,
            data: commentData,
            headers:{'Content-Type': 'multipart/form-data'}
        }
    )
}
