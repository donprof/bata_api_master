export const fetchUsers = ({ commit }) => {
    return axios.get('/api/auth/users').then((response) => {
        commit('setUsers', response.data)
    })
}

export const selectedUser = ({ commit }, payload) => {
    commit('setSelectedUser', payload)
}

export const updateUser = ({ dispatch }, { payload, context}) => {
    return axios.put('/api/users/' + payload.id + '/update', payload).then((response) => {
        context.newuserdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const updateProfile = ({ dispatch }, { payload, context}) => {
    return axios.put('/api/profile/' + payload.id + '/update', payload).then((response) => {
        context.newuserdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const changestatus = ({ dispatch }, { payload, context}) => {
    return axios.put('/api/changestate/' + payload.id + '/status', payload).then((response) => {
        context.updateuser = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const createuser = ({commit }, { payload, context }) => {
    return axios.post('/api/user/store', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const fetchUsersList = ({ commit }) => {
    return axios.get('/api/userslist').then((response) => {
        commit('setUsersList', response.data.data)
    })
}