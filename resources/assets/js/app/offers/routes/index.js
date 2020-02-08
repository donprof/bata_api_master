import { Offers } from '../components'

export default [
    {
        path: '/offers',
        component: Offers,
        name: 'offers',
        meta: {
            needsAuth: true,
        }
    }
]