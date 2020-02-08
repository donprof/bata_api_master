import { isEmpty } from 'lodash'
export const setHttpToken = (token) => {
    if (isEmpty(token)) {
        window.axios.defaults.headers.common['Authorization'] = null
        // Echo.connector.pusher.config.auth.headers['Authorization'] = null
    }
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
	// Echo.connector.pusher.config.auth.headers['Authorization'] = 'Bearer ' + token;
}