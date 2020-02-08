import moment from 'moment'

export const setOrdersChart = (state, data) => {
	state.ordersChart = data
}

export const setTotalusers = (state, data) => {
	state.usercount = data
}

export const setVehicleJobcardCounter = (state, data) => {
	state.vehicleJobcardCounter = data
}

export const setServicetypesCount = (state, data) => {
	state.servicescount = data
}

export const setWeekSales = (state, data) => {
	state.weeksales = data
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

export const setSelectedService = (state, data) => {
	state.jobcards = data
}

export const setFuelChart = (state, data) => {
	state.fuelchart = data
}