import debounce from 'lodash/debounce'

export default {
	loadNotifications({state, commit, dispatch})
	{
		let now = new Date().getTime()
		if ( now - state.last_load < 15000){ // 15 secunde throttle la load notifications
			return
		}
		return axios.get('/notifications?page='+(state.current_page+1))
			.then( (res) => {
				dispatch('insertOrUpdate', {data:res.data.data})
				commit('onSuccessFetch')
			}).catch( e => {
				VueBus.$emit('error-occured', e)
			})
	},
	saveReadState: debounce(function({getters,dispatch}, notification)
	{
		let notif = getters.find(notification.id)
		return axios.post('/notifications/'+notif.id, {
			_method:'PATCH',
			data: notif
		}).then( res => {
			dispatch('insertOrUpdate', {data: res.data})
		}).catch( e => {
			VueBus.$emit('error-occured', e)
		})
	}, 1000),
	
	markAllAsRead({getters,dispatch})
	{
		if (getters.unread_notifications === 0){
			return
		}
		axios.post('/notifications', {_method:'PATCH'})
			.then( res => {
				let now = new Date()
				dispatch('update', {
					where: (notif) => notif.read_at === null,
					data: { read_at: now }
				})
			}).catch( e => {
				VueBus.$emit('error-occured', e)
			})
	},
	
	checkForNotifications({state, commit})
	{
		if (state.last_load && (state.last_load - state.last_check < 10000)){ //daca am incarcat de curand, nu mai cauta
			return
		}
		axios.get('/notifications/check-for-new').then( (res) => {
			commit('onSuccessCheck', res.data.unread_notifications_count)
		})
	},
	
	toggleReadState({dispatch}, notification)
	{
		dispatch('update', {
			where: notification.id,
			data: {
				read_at: notification.read_at ? null : new Date()
			}
		})
	},
	
	deleteNotification({dispatch}, notification)
	{
		axios.post('/notifications/'+notification.id, {_method:'DELETE'})
			.then( res => {
				dispatch('delete', notification.id)
			}).catch( e => {
				VueBus.$emit('error-occured', e)
			})
	}
}