export default {
	onSuccessFetch(state){
		state.current_page++
		state.last_load = new Date().getTime()
	},
	onSuccessCheck(state, count){
		state.unread_notifications.count = count
		state.unread_notifications.last_check = new Date().getTime()
	},
}