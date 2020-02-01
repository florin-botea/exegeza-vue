import queryString from 'query-string'

export default {
	getPage({state,dispatch,commit}, {pagination,page})
	{
		if (state.paginations[pagination] && !page){
			return true
		}
		let query = {
			comment: pagination,
			page: page || 1,
		}
		return axios.get('/raspunsuri?'+queryString.stringify(query))
			.then( res => {
				commit('insertOrUpdatePagination', {
					data:res.data,
					id: pagination,
				})
				dispatch('insertOrUpdate', {data: res.data.data})
				return true
			}).catch( e => {
				return false
			})
	},
	
	addComment({state,dispatch}, comment){
		return axios.post('/comentarii', comment)
			.then( res => {
				dispatch('insertOrUpdate', {data: res.data})
				return res.data
			}).catch( e => {
				return false
			})
	},
	updateComment({state,dispatch}, comment){
		return dispatch('$update', {params:{id:comment.id}, data:comment})
		return axios.post('/comentarii/'+comment.id, {data:comment,_method:'PUT'})
			.then( res => {
				dispatch('insertOrUpdate', {data: res.data})
				return res.data
			}).catch( e => {
				return false
			})
	},
	deleteComment({state,dispatch}, comment){
		return axios.post('/comentarii/'+comment.id, {data:comment,_method:'DELETE'})
			.then( res => {
				dispatch('delete', {where: res.data.id})
				return res.data
			}).catch( e => {
				return false
			})
	},
}