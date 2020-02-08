import { Users, Profile } from '../components'

export default [
    {
        path: '/users',
        component: Users,
        name: 'users',
        meta: {
            needsAuth: true
        }
    },
    {
        path: '/user-profile',
        component: Profile,
        name: 'user-profile',
        meta: {
            needsAuth: true
        }
    }
]