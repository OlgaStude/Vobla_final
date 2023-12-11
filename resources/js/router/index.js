import { createWebHistory, createRouter } from "vue-router"

import Home from '../pages/Home.vue'
import Login from '../pages/Login.vue'
import Registration from '../pages/Registration.vue'
import userPage from '../pages/userPage.vue'
import Admin from '../pages/Admin.vue'

export const routes = [
    {
        name: 'Home',
        path: '/',
        component: Home
    },
    {
        name: 'Login',
        path: '/login',
        component: Login
    },
    {
        name: 'Registration',
        path: '/registration',
        component: Registration
    },
    {
        name: 'userPage',
        path: '/user/:id',
        component: userPage
    },
    {
        name: 'Admin',
        path: '/admin',
        component: Admin
    },
]


const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})

export default router;