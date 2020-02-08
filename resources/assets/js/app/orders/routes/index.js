import { Orders } from '../components'

export default [
    {
        path: '/orders',
        component: Orders,
        name: 'orders',
        meta: {
            needsAuth: true,
        }
    }
]