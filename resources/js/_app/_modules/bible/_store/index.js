import getters from './getters'
import mutations from './mutations'

export default {
	namespaced: true,
	state: {
		version: {
			id: 0,
			index: 0,
			name: 'none'
		},
		book: {
			id: 0,
			index: 0,
			name: 'none'
		},
		chapter: {
			id: 0,
			index: 0,
			name: 'none'
		},
		verses: [],
		selectedGlobalId: 0
	},
	getters,
	mutations,
}