import moment from 'moment'
export const setProducts = (state, data) => {
	state.products = data
}

export const selectedProduct = (state, data) => {
	state.product = data
}


export const removeProduct = (state, data) => {
	state.products = state.products.filter((issue) => {
		return issue.variations.id !== data
	})
}

export const setProductsPage = (state, data) => {
	state.page = data
}

export const setMeta = (state, data) => {
	state.meta = data
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