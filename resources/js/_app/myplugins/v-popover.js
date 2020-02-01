/**
	se presupune ca folosesc vuex - e nevoie de un modul care sa gestioneze pozitia fiecarui element in pagina
	-----------popovers------------------------
*/

export default {
	install(Vue, options){
		Vue.directive('popover', {
			bind: function (el, binding, vnode) {
				el.addEventListener("click", function(e){
					let trueHit = e.target === el
					if ( trueHit || binding.modifiers.bubble ){
						vnode.context.$store.commit('popovers/show', {
							name: binding.value.name,
							data: binding.value.data,
							DOMRect: el.getBoundingClientRect()
						})
						e.stopPropagation()
					}
				})
				document.addEventListener("click", function(){
					vnode.context.$store.commit('popovers/hide')
				})
			}
		})
	}
}