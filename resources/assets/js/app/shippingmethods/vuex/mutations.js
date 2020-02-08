import moment from 'moment'
export const setShippingmethods = (state, data) => {
	state.shippingmethods = data
}

export const selectedvariation = (state, data) => {
	state.variation = data
}

export const setVariationList = (state, data) => {
	state.variationlist = data
}






export const changefuelmonth = (state, data) => {
	state.fuelmonth = moment(data)
}

export const changebookmonth = (state, data) => {
	state.bookingmonth = moment(data)
}

export const setMechanicsJob = (state, data) => {
	state.mechanicsjob = data
}

export const setBookingChart = (state, data) => {
	state.bookingChart = data
}

export const setSelectedService = (state, data) => {
	state.jobcards = data
}

export const setFuelChart = (state, data) => {
	state.fuelchart = data
}