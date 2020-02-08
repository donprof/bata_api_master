export const fetchCategories = ({ commit }) => {
    return axios.get('/api/categories').then((response) => {
        commit('setCategories', response.data.data)
    })
}

export const fetchChildrenCategoriesList = ({ commit }) => {
    return axios.get('/api/categorylist').then((response) => {
        commit('setCategorylist', response.data.data)
    })
}

export const createParentCategory = ({commit }, { payload, context }) => {
    return axios.post('/api/categories', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const newSubChildCategory = ({commit }, { payload, context }) => {
    return axios.post('/api/categories', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const selectedCategories = ({ commit }, payload) => {
    commit('selectedvariation', payload)
}

export const selectedChild = ({ commit }, payload) => {
    commit('selectedChild', payload)
}

export const selectedSubChild = ({ commit }, payload) => {
    commit('selectedSubChild', payload)
}

export const updatCategory = ({ commit }, { payload, context }) => {
    return axios.put('/api/categories/'+payload.id, payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const fetchCategoriesList = ({ commit }) => {
    return axios.get('/api/variationlist').then((response) => {
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
