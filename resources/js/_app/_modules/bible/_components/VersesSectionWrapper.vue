<script>
	import MobileSwipeWrapper from '@/$components/wrappers/MobileSwipeWrapper.vue'
	import navbarSwipeReaction from '@/myPlugins/mixins/navbar-swipe-reaction.js'
	
	export default {
		extends: MobileSwipeWrapper,
		mixins: [navbarSwipeReaction],
	}
</script>