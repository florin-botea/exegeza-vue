import DOMel from '@/utils/DOMel.js'

export default {
	// created(reply){
		// DOMel.reply(reply.id).bringIntoFocus()
	// },
	
	// beforeUpdate(reply){
		// return confirm('Sunteti sigur(a) ca doriti sa editati acest raspuns?')
	// },
	
	// updated(reply){
		// DOMel.reply(reply.id).bringIntoFocus()
	// },
	
	beforeDelete(tag){
		return confirm('Sunteti sigur(a) ca doriti sa stergeti acest tag?')
	},
	
	// deleted(reply){
		// alert('deleted')
	// }
}