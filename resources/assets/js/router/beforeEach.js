import store from '../vuex'
import localforage from 'localforage'

const beforeEach = ((to, from, next) => {
    store.dispatch('auth/checkTokenExists').then(() => {
        // // if you are going to login page and you are already logged in then go to home page
        if (to.meta.guest) {
            next({ name: 'dashboard' })
            return
        }
        // store.dispatch('auth/checkLockScreen').then(() => {
        //     //take the user to the lock screen if the screenlock state is not null
        //     console.log("Locked");
        //     localforage.setItem('intended', to.name)
        //     next({ name: 'lockscreen' })
        //     return
        // }).catch(() => {})
        // localforage.getItem('screenlock').then((state) => {
        //     if (state == null && to.name == 'lockscreen') {
        //         next({ name: 'dashboard' })
        //         return
        //     }
        // })
        // localforage.setItem('previous', from.name)
        // localforage.setItem('activePage', to.name)
        next()
    }).catch(() => {
        // if you are going to a page that needs authentication and you dont have a token then redirect to login
        if (to.meta.needsAuth) {
            localforage.setItem('intended', to.name)
            next({ name: 'login' })
            return
        }
        next()
    })
})

export default beforeEach