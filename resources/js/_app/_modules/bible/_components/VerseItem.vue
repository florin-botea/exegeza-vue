<template>
	<div class="hover:bg-gray-400 text-justify cursor-default" :id="'verse_'+global_id"
	:class="{'bg-gray-400':selected==global_id, 'font-bold text-lg':verse.index==0}"
	@mousedown="setMouseDownTime" @mouseup.left="onVerseClick" v-html="render">
		
	</div>
</template>

<script>
	export default {
		props: {
			selected: {type:Number},
			verse: Object
		},
		data: () => ({
			mouseDownTime: null,
		}),
		computed: {
			render(){
				return "<strong>"+(this.verse.index ? (this.verse.index+'. ') : '')+"</strong>"+this.verse.text
			},
			global_id(){
				return (this.verse.book_index*1000000) + (this.verse.chapter_index*1000) + this.verse.index
			}
		},
		methods: {
			onVerseClick()
			{
				let user_is_selecting = (new Date().getTime() - this.mouseDownTime) > 250
				if ( user_is_selecting ){
					return
				}
				if ( this.global_id === this.selected ){
					this.$store.commit('setUIState', {prop:'commentsSectionShown', value:true})
					return
				}
				//let forms = Object.keys(this.$store.state.forms)
				//console.log(forms)
				//if (forms.length){
				//	this.$store.commit('setUIState', {prop:'commentsSectionShown', value:true})
				//	let last = forms.length-1
				//	DOMel.get(forms[last]).bringIntoFocus()
				//	return
				//}
				this.$emit('select-verse', this.global_id)
			},
			setMouseDownTime()
			{
				this.mouseDownTime = new Date().getTime()
			},
		}
	
	}
</script>