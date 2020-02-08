import { Messages, Userslist, Chatlist } from '../components'

export default [
    {
        path: '/messages',
        component: Messages,
        meta: {
            needsAuth: true
        },
        children: [
            { path: '', name: 'messages', component: Chatlist, meta: { needsAuth: true } },
            { name: 'chatlist', path: 'chatlist', component: Chatlist, meta: { needsAuth: true }  },
            { name: 'userslist', path: 'userslist', component: Userslist, meta: { needsAuth: true }  },
        ]
    }
]