import moment from 'moment'
export const setOrders = (state, data) => {
	state.orders = data
}

export const selectedProduct = (state, data) => {
	state.product = data
}

export const selectedShipping = (state, data) => {
	state.shipping = data
}

export const removeProduct = (state, data) => {
	state.products = state.products.filter((issue) => {
		return issue.variations.id !== data
	})
}











export const setLeaveCount = (state, data) => {
	state.leavecount = data
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