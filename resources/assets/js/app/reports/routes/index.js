import { Reports } from '../components'

export default [
    {
        path: '/reports',
        component: Reports,
        name: 'reports',
        meta: {
            needsAuth: true,
        }
    }
]