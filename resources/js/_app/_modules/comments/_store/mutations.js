import {insertOrUpdatePagination} from '@/store/shared/mutations.js'

export default {
	insertOrUpdatePagination,
	setFilter(state, pl){
		state.filters = pl
	}
}