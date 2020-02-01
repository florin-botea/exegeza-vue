<template>
	<div v-show="active" class="absolute w-64 bg-yellow-300 h-auto shadow-md p-1 bg-gray-100 text-start text-sm font-normal text-black cursor-pointer" style="z-index:9999"
	:style="cStyle">
		{{cStyle}}
	</div>
</template>

<script>
	export default {
		computed: {
			popover(){
				return this.$store.state.popovers.all.filter( popover => popover.name == 'TagPopover' )[0] || {
					DOMRect: {bottom:0,height:0,left:0,right:0,top:0,width:0,x:0,y:0}
				}
			},
			active(){
				return this.$store.state.popovers.active == 'TagPopover'
			},
			cStyle(){
				console.log(this.popover)
				return {
					top: this.popover.DOMRect.bottom + 'px',
					right: window.innerWidth - this.popover.DOMRect.right + 'px'
				}
			}
		},
		mounted(){
			this.$store.commit('popovers/register', {
				name: 'TagPopover',
				data: {},
				DOMRect: {bottom:0,height:0,left:0,right:0,top:0,width:0,x:0,y:0},
			})
		}
	}
</script>