export const fetchCostcenters = ({ commit }) => {
    return axios.get('/api/costcenters').then((response) => {
        commit('setCenters', response.data.data)
    })
}

export const selectedCenter = ({ commit }, payload) => {
    commit('setSelectCenter', payload)
}

export const updatCenter = ({ commit }, { payload, context }) => {
    return axios.put('/api/costcenter/' + payload.companyCode + '/update', payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const createcenter = ({commit }, { payload, context }) => {
    return axios.post('/api/center/create', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const fetchCenterList = ({ commit }) => {
    return axios.get('/api/centerlist').then((response) => {
        commit('setCenterList', response.data.data)
    })
}