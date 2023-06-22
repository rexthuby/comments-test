import {createApp} from 'vue'
import App from '../ui/App.vue'
import '@/app/assets/app.css'
import {router} from "./router.js";
import VueEasyLightbox from 'vue-easy-lightbox'
import { createVfm } from 'vue-final-modal'
import 'vue-final-modal/style.css'

const vfm = createVfm()

createApp(App).use(router).use(VueEasyLightbox).use(vfm).mount("#app")
