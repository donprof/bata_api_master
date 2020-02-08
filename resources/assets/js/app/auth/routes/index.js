import { Lockscreen, Login, Resetpassword } from '../components'

export default [
    {
        path: '/lockscreen',
        component: Lockscreen,
        name: 'lockscreen',
        meta: {
            needsAuth: true
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            guest: true,
            needsAuth: false
        }
    },
    {
        path: '/resetpassword',
        component: Resetpassword,
        name: 'resetpassword',
        meta: {
            guest: true,
            needsAuth: false
        }
    }
]