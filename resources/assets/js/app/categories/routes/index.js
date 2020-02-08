import { Categories } from '../components'

export default [
    {
        path: '/categories',
        component: Categories,
        name: 'categories',
        meta: {
            needsAuth: true,
        }
    }
]