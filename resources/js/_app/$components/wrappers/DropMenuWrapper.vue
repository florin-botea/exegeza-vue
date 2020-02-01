<template>
	<div class="flex">
		<div @click="toggle" :class="toggler.class" :style="toggler.style">
			<slot name="toggler"></slot>
		</div>
		<div v-show="isShown" v-click-outside.bubble="hide" 
		style="width:0px;height:0px;overflow:show;" :class="layerWrapper.class">
			<slot v-bind="{forceHide}"></slot>
		</div>
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