<script>
import MobileSwipeWrapper from '@/$components/wrappers/MobileSwipeWrapper.vue'
import navbarSwipeReaction from '@/myPlugins/mixins/navbar-swipe-reaction.js'

export default {
	extends: MobileSwipeWrapper,
	mixins: [navbarSwipeReaction],
	methods: {
		swipeRight(touchDuration){
			//hide comm section
			if (touchDuration < 300) {
				//let forms_opened = this.$store.state.forms.length > 0
				this.$store.commit('setUIState', {prop:'commentsSectionShown', value:false})
			}
		}
	}
}
</script>