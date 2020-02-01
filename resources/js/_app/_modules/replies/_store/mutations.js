import {insertOrUpdatePagination} from '@/store/shared/mutations.js'

export default {
	insertOrUpdatePagination,
	setActiveThread(state, reply){
		state.activeThread = reply
	}
}