export const getMessage = ({ commit }, { payload, context }) => {
    return axios.get('/api/showmessage/'+payload.id).then((response) => {
        commit('setMessages', response.data.data)
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const messageClear = ({ commit }) => {
    commit('messageClear')
}

export const newMessage = ({commit }, { payload, context }) => {
    return axios.post('/api/message/create', payload).then((response) => {
        context.newResMsg = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}