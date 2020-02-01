export default {
	paginationComments(state, getters) {
		if (!state.filters){
			return []
		}
		return getters.query()
			.with('deletion_requests')
			.where('target', state.filters.target)
			.orderBy('id', 'asc')
			.get()
	},
	activePagination(state) {
		return state.paginations[state.filters.target]
	}
}