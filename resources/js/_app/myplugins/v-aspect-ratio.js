export default {
	install(Vue, options){
		Vue.directive('aspect-ratio', {
			inserted: function (el, binding, vnode) {
				let ratio = Object.keys(binding.modifiers)[0]
				if (!ratio){
					ratio = '1:1'
				}
				ratio = ratio.split(':')
				if (el.clientWidth){
					el.style.height = (el.clientWidth*ratio[1]/ratio[0]) + 'px'
				} else if (el.clientHeight){
					el.style.width = (el.clientHeight*ratio[0]/ratio[1]) + 'px'
				}
			}
		})
	}
}