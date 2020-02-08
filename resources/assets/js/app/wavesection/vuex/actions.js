export const fetchOfers = ({ commit }) => {
    return axios.get('/api/wavesection').then((response) => {
        commit('setOffers', response.data)
    })
}

export const createOffer = ({commit }, { payload, context }) => {
    return axios.post('/api/wavesection', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const selectedVariation = ({ commit }, payload) => {
    commit('selectedvariation', payload)
}


export const updatOfers = ({ commit }, { payload, context }) => {
    return axios.put('/api/wavesection/'+payload.id, payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}