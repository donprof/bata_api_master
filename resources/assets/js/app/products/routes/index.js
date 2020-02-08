import { Products } from '../components'

export default [
    {
        path: '/products',
        component: Products,
        name: 'products',
        meta: {
            needsAuth: true,
        }
    }
]