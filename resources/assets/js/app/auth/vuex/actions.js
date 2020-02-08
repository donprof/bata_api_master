import { setHttpToken } from '../../../helpers'
import { isEmpty } from 'lodash'
import Bus from '../../../bus'
import localforage from 'localforage'

export const login = ({ dispatch, commit }, { payload, context }) => {
    return axios.post('/api/admin/login', payload).then((response) => {
        commit('setUserData', response.data.user)
        commit('setAuthenticated', true)
        dispatch('setToken', response.data.token).then(() => {})
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const resetpassword = ({commit }, { payload, context }) => {
    return axios.post('/api/auth/passwordreset', payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const setToken = ({ commit, dispatch }, token) => {
    if (isEmpty(token)) {
        return dispatch('checkTokenExists').then((token) => {
            setHttpToken(token)
        })
    }
    commit('setToken', token)
    setHttpToken(token)
}

export const checkTokenExists = ({ commit, dispatch }, token) => {
    return localforage.getItem('authtoken').then((token) => {
        if (isEmpty(token)) {
            return Promise.reject('NO_STORAGE_TOKEN');
        }
        return Promise.resolve(token)
    })
}

export const logout = ({ dispatch }, { payload }) => {
    return axios.post('/api/auth/logout', payload).then((response) => {
        dispatch('clearAuth')
    })
}

export const clearAuth = ({ commit }, token) => {
    commit('setAuthenticated', false)
    commit('setUserData', null)
    commit('setToken', null)
    setHttpToken(null)
}


export const fetchUser = ({ dispatch, commit }) => {
    return axios.get('/api/admin/me').then((response) => {
        // localforage.setItem('screenlock', response.data.data.screenlock)
        // localforage.setItem('uid', response.data.data.id)
        // localforage.getItem('intended').then((pageTo) => {
        //     if (pageTo == 'lockscreen') {
        //         localforage.setItem('intended', 'home')
        //     }
        // })
        commit('setUserData', response.data.data)
        // console.log(response.data.data.id)
        commit('setAuthenticated', true)

        // Echo.private('App.User.'+response.data.data.id)
        // .listen('UserEvent',(data) => {
        //     Bus.$emit('new-update', data)
        // })
        // dispatch('fetchGroundedCount')
        // dispatch('fetchOverdueTasks')
        // dispatch('fetchExpiredLicence')
        // dispatch('fetchMessageCount')
        // dispatch('fetchChatUser')
        // dispatch('dueBudges')
        // dispatch('fetchDueServices')
        // dispatch('todayBookings')
    })
}