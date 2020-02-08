import { Welcome } from '../components'

export default [
    {
        path: '/',
        component: Welcome,
        meta: {
            needsAuth: true
        }
    }
]
