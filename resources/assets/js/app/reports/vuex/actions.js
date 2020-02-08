export const getSelectReport = ({ commit }, { payload, context }) => {
    return axios({
        method:'post',
        url:'/api/admin/'+payload.data.apislug+payload.data.reporttype,
        responseType:'arraybuffer',
        data: payload.data
    }).then(function(response) {
        let blob = new Blob([response.data], { type: 'application/'+payload.data.reporttype } )
        let link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = payload.data.reportnum+' '+payload.data.reporttitle+'.'+payload.data.reporttype
        link.click()
    }).catch((error) => {
        context.errors = error.response.data.errors
    });
}


export const fetchOfers = ({ commit }) => {
    return axios.get('/api/admin/ordersreports').then((response) => {
        commit('setOffers', response.data)
    })
}

export const createOffer = ({commit }, { payload, context }) => {
    return axios.post('/api/adverts', payload).then((response) => {
        context.newdata = response.data.data
    }).catch((error) => {
        context.errors = error.response.data.errors
    })
}

export const selectedVariation = ({ commit }, payload) => {
    commit('selectedvariation', payload)
}


export const updatOfers = ({ commit }, { payload, context }) => {
    return axios.put('/api/adverts/'+payload.id, payload).then((response) => {
    }).catch((error) => {
        context.errors = error.response.data.errors
   })
}

export const fetchVariationTypesList = ({ commit }) => {
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
