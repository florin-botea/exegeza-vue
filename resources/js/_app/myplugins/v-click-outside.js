export default {
	install(Vue, options){
		Vue.directive('click-outside', {
			bind: function (el, binding, vnode) {
				el.addEventListener("click", function(e){
					let trueHit = e.target === el
					if ( trueHit || binding.modifiers.bubble ){
						e.stopPropagation()
					}
				})
				document.addEventListener("click", function(e){
					binding.value(e)
				})
			}
		})
	}
}