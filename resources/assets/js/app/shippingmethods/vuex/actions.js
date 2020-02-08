export const ShippingmethodData = ({ commit }) => {
    return axios.get('/api/shippingmethods').then((response) => {
        commit('setShippingmethods', response.data.data)
    })
}

export const createShippingMethods = ({commit }, { payload, context }) => {
    return axios.post('/api/shippingmethods', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const selectedVariation = ({ commit }, payload) => {
    commit('selectedvariation', payload)
}


export const updateShippingMethods = ({ commit }, { payload, context }) => {
    return axios.put('/api/shippingmethods/'+payload.id, payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const fetchVariationTypesList = ({ commit }) => {
    return axios.get('/api/shippingmethods').then((response) => {
        commit('setVariationList', response.data.data)
    })
}













export const fetchBookingChart = ({ commit }, { payload }) => {
    return axios.get('/api/bookingchart?year='+payload.year).then((response) => {
        commit('setBookingChart', response.data)
    })
}

export const fetchMechWorks = ({ commit }, { payload }) => {
    return axios.get('/api/jobsshow?month='+payload.month).then((response) => {
        commit('setMechanicsJob', response.data.data)
    })
}

export const changefuelmonth = ({ commit }, payload) => {
    commit('changefuelmonth', payload)
}

export const fetchSerciceCountData = ({ commit }) => {
    return axios.get('/api/jobcounter').then((response) => {
        commit('setServicetypesCount', response.data)
    })
}

export const fetchFuelChat = ({ commit }, { payload }) => {
    return axios.get('/api/fuelchart?year='+payload.year).then((response) => {
        commit('setFuelChart', response.data)
    })
}

export const setSelectedService = ({ commit }, payload) => {
    commit('setSelectedService', payload)
}
