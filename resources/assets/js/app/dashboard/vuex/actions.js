export const fetchVehicleJobcardData = ({ commit }) => {
    return axios.get('/api/carscount').then((response) => {
        commit('setVehicleJobcardCounter', response.data)
    })
}

export const fetchWeekSales = ({ commit }) => {
    return axios.get('/api/admin/weeklysales').then((response) => {
        commit('setWeekSales', response.data.data)
    })
}

export const fetchTotalusers = ({ commit }) => {
    return axios.get('/api/admin/totalusers').then((response) => {
        commit('setTotalusers', response.data)
    })
}

export const fetchOrdersChart = ({ commit }, { payload }) => {
    console.log(payload.year)
    return axios.get('/api/auth/annualsales?year='+payload.year).then((response) => {
        commit('setOrdersChart', response.data)
    })
}

export const fetchMechWorks = ({ commit }, { payload }) => {
    return axios.get('/api/jobsshow?month='+payload.month).then((response) => {
        commit('setMechanicsJob', response.data.data)
    })
}

export const changebookmonth = ({ commit }, payload) => {
    commit('changebookmonth', payload)
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
