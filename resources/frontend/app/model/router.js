import {createRouter, createWebHistory} from "vue-router";
import HomePage from "@/pages/HomePage/ui/HomePage.vue";
import Page404 from "@/pages/Page404/ui/Page404.vue";

const allRoutes = [
    {path: '/', component: HomePage, name: 'Home', props: route => ({ page: route.query.page, sort:route.query.sort })},
    {path: '/:pathMatch(.*)*', component: Page404, name: 'NotFound',},
]

const router = createRouter({
    history: createWebHistory(),
    routes: allRoutes,
    scrollBehavior(to, from, savedPosition) {
        return savedPosition || {top: 0};
    },
})

export {router}
