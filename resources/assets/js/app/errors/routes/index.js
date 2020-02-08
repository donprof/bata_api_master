import { NotFound } from '../components'

export default [
    {
        path: '*',
        component: NotFound,
        meta: {
            needsAuth: true
        }
    }
]
