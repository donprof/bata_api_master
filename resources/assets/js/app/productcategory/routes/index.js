import { Productcategory } from '../components'

export default [
    {
        path: '/product-category',
        component: Productcategory,
        name: 'product-category',
        meta: {
            needsAuth: true,
        }
    }
]