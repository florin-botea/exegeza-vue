import getters from './getters'
import actions from './actions'
import mutations from './mutations'

export default {
	namespaced: true,
	state: {
		current_page: 0,
		unread_notifications: {
			last_check: 0,
			count: 0
		},
		last_load: 0,
	},
	getters,
	actions,
	mutations
}