<template>
  <div v-scroll="onScroll" id="comments_layer" style="height:80vh; overflow-y:auto;padding:0px;">
		<div style="height:1px;" v-if="forcingScroll.top"></div>
		<slot></slot>
		<div style="height:1px;" v-if="forcingScroll.bottom"></div>
  </div>
</template>

<script>

export default {
	props: {
		disableIf: {type:Boolean, default:false}
	},
	data(){
		return {
			forcingScroll: {
				top: false,
				bottom: false,
			}
		}
	},
  methods: {
		onScroll(e, pos){
			let scrollBottom = ( (e.target.offsetHeight + pos.scrollTop) === e.target.scrollHeight )
			if (pos.scrollTop === 0){
				//alert('touched top')
			}
			if (scrollBottom){
				if (this.forcingScroll.bottom && !this.disableIf){
					console.log('touched bottom')
					//this.scroll.loadingBottom = false
					return
				}
				this.forcingScroll.bottom = true

			}
		},
	}
}
</script>