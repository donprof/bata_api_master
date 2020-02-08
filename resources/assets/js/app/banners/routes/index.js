import { Banners } from '../components'

export default [
    {
        path: '/banners',
        component: Banners,
        name: 'banners',
        meta: {
            needsAuth: true,
        }
    }
]