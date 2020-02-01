<template>
	<div @click="toggle">
		<slot v-bind="{forceHide,hide,isShown}"></slot>
	</div>
</template>

<script>
export default {
	props: {
		toggler: {default:() => ({'class':'', style:{}})},
		layerWrapper: {default:() => ({class:{}})}
	},
	data: () => ({
		isShown: false,
		fingerprint: 1
	}),
	methods: {
		toggle(e){
			this.isShown = !this.isShown
			if (this.isShown){
				this.fingerprint = e.fingerprint = new Date().getTime()
				this.$emit('show', this.isShown)
			}
		},
		hide(e){
			if(e.fingerprint !== this.fingerprint){
				this.isShown = false
			}
		},
		forceHide(){
			this.isShown = false
		}
	},
	watch: {
		isShown(state){
			this.$emit('toggle', state)
		}
	}
}
</script>