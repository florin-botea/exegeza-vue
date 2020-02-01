export default {
	unread_notifications(state, getters){
		if ( state.unread_notifications.last_check > state.last_load ){
			return state.unread_notifications.count
		}
		return getters.query().where('read_at', null).count()
	}
}