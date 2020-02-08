export const fetchStock = ({ commit }, { payload, context }) => {
    return axios.get('/api/auth/stock?page=' + payload.page).then((response) => {
        commit('setProducts', response.data.data)
        commit('setProductsPage', payload.page)
        commit('setMeta', response.data)
    })
}

export const searchItems = ({ commit }, { payload, context }) => {
    return axios.get('/api/auth/stock/'+payload.search, payload).then((response) => {
        commit('setProducts', response.data.data)
        commit('setMeta', response.data)
    })
}

export const createVariation = ({commit }, { payload, context }) => {
    return axios.post('/api/productvariation', payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const selectedProduct = ({ commit }, payload) => {
    commit('selectedProduct', payload)
}


export const updatProduct = ({ commit }, { payload, context }) => {
    return axios.put('/api/products/'+payload.id, payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const updateProductStock = ({ commit }, { payload, context }) => {
    return axios.put('/api/auth/stock/'+payload.product_variation_id, payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const deleteVariation = ({ commit }, { payload, context }) => {
    return axios.delete('/api/productvariation/'+payload.id).then((response) => {
        commit('removeProduct', payload.id)
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const deleteProduct = ({ commit }, { payload, context }) => {
    return axios.delete('/api/products/'+payload.id).then((response) => {
        commit('removeProduct', payload.id)
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}












export const fetchLeave = ({ commit }) => {
    return axios.get('/api/dashleave').then((response) => {
        commit('setLeaveCount', response.data)
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
