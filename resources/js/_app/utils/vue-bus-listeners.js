/*
	aici voi inregistra toate actiunile secundare cauzate de actiuni principale
	evenimentele vor fi emise de window.VueBus
*/
import Vue from 'vue'

export default function(){
	VueBus.$on('reply-added', (reply) => {
		DOMel.reply(reply.id).bringIntoFocus()
	})
	
	VueBus.$on('comment-event', (comment) => {
		DOMel.comment(comment.id).bringIntoFocus()
	})

	VueBus.$on('reply-event', (reply) => {
		DOMel.reply(reply.id).bringIntoFocus()
	})
	
	VueBus.$on('tag-added', (comment) => {
		
	})
	
	VueBus.$on('error-occurred', (e) => {
		if (e.response.status == 403){
			Vue.notify({
				group: 'notifications',
				duration: 5000,
				type: 'bg-yellow-500',
				title: 'Error 403',
				text: 'Nu aveti suficiente drepturi pentru aceasta actiune.'
			})
			return
		}
		Vue.notify({
			group: 'notifications',
			duration: 5000,
			type: 'bg-red-300',
			title: 'A aparut o eroare neprevazuta!',
			text: 'Ne cerem scuze pentru inconvenient. Un raport al erorii a fost trimis catre noi pentru a se gasi o rezolvare. Va rugam sa incercati din nou mai tarziu.'
		})
		//log
	})
	
	VueBus.$on('404-error', (e) => {
		Vue.notify({
			group: 'notifications',
			duration: 5000,
			type: 'bg-red-300',
			title: 'Error 404',
			text: 'Aceasta resursa nu exista, sau a fost stearsa.'
		})
		//log
	})
}