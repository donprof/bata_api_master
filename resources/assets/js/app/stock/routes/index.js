import { Stock } from '../components'

export default [
    {
        path: '/stock',
        component: Stock,
        name: 'stock',
        meta: {
            needsAuth: true,
        }
    }
]