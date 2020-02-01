<template>
	<div class="fixed md:invisible" @click="setUIState({prop:'commentsSectionShown', value:true})" style="bottom:7%; right:15%; z-index:22; font-size:40px;">
		<i class="far fa-comment-dots"></i>
	</div>
</template>

<script>
	import {mapMutations} from 'vuex'
	
	export default {
		methods: {
			...mapMutations(['setUIState']),
		}
	}
</script>