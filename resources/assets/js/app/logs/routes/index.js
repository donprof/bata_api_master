import { Logs } from '../components'

export default [
    {
        path: '/logs',
        component: Logs,
        name: 'logs',
        meta: {
            needsAuth: true,
        }
    }
]