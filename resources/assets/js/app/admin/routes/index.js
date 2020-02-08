import { Admin } from '../components'

export default [
    {
        path: '/admin',
        component: Admin,
        name: 'admin',
        meta: {
            needsAuth: true,
        }
    }
]