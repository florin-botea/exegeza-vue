export default {
	methods: {
		swipeTop(touchDuration){
			//hide navbar
			// if (touchDuration < 300){
				this.$store.commit('setUIState', {prop:'navbarShown', value:false})
			// }
		},
		swipeBottom(touchDuration){
			//show navbar
			if (touchDuration < 300 || this.$el.scrollTop < 50){
				this.$store.commit('setUIState', {prop:'navbarShown', value:true})
			}
		}
	}
}