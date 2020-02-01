export default {
	setUIState(state, {prop, value}){
		state.ui[prop] = value
	},
	setAuth(state, pl){
		state.auth = pl
	},
	setBibleData(state, pl){
		state.bibleData = pl
	},
	saveForm(state, {form_id, bool}){
		if (bool){
			state.savedForms[form_id] = true
			return
		}
		delete state.savedForms[form_id]
	},
	setRoute(state, pl){
		state.route = pl
	}
}