import { Shippingmethods } from '../components'

export default [
    {
        path: '/shippingmethods',
        component: Shippingmethods,
        name: 'shippingmethods',
        meta: {
            needsAuth: true,
        }
    }
]