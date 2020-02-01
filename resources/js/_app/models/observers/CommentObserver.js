import DOMel from '@/utils/DOMel.js'

export default {
	created(comment){
		DOMel.comment(comment.id).bringIntoFocus()
	},
	
	beforeUpdate(comment){
		return confirm('Sunteti sigur(a) ca doriti sa editati acest comentariu?')
	},
	
	updated(comment){
		DOMel.comment(comment.id).bringIntoFocus()
	},
	
	beforeDelete(comment){
		return confirm('Sunteti sigur(a) ca doriti sa stergeti acest comentariu?')
	},
	
	deleted(comment){
		alert('deleted')
	}
}