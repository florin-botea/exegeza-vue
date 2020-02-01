<template>
	<div class="input_select">
		<input type="text"
		autocomplete="off"
		:class="className"
		v-bind="$attrs"
		:ref="'input'" 
		:value="value" 
		@input="onInput"
		@keyup.down="down" 
		@keyup.up="up" 
		@keyup.enter="onSubmit"
		v-focus="d_focused" @focus="d_focused=true" @blur="d_focused=false">
		<div style="overflow:visible;height:0px;z-index:20" v-if="isSuggestionsShown" v-click-outside="onClickOutside">
			<slot :selectedIndex="selectedIndex"></slot>
		</div>
	</div>
</template>

<script>
/*
* va primi :count_suggestions(number) pentru a putea pune limita la index-ul maxim
* va primi un v-model care va constitui sursa unica de adevar pentru valoarea input-ului
*   \voi putea sa il folosesc astfel cu orice structura de date pentru ca valoarea input-ului se va seta din afara
* va emite @pick-suggestion (si va fi gestionat in exterior) atunci cand o sugestie e selectata prin Enter (si click-urmeste) 
*   \si va emite index-ul selectat pentru a putea fi stabilita valoarea input-ului din exterior
* va emite @select de fiecare data cand apas Up or Down pentru a actualiza in timp real selectedIndex din exterior
* va gestiona @submit si se va folosi de <index> actualizat anterior in timp real
*/
const fn = function (){
	console.log('debouche emitting')
	this.$emit('input', this.searchQuery)
}

import {core} from 'lodash'
export default {
	inheritAttrs: false,
	data: () => ({
		selectedIndex: -1,
		first_index: -1,
		d_focused: false
	}),
	props: {
		count_suggestions: Number,
		value: String,
		className: {type:String, default:''},
		isSuggestionsShown: {type:Boolean, default:false},
		forceSuggestion: {type:Boolean, default:false},
		focused: {type:Boolean, default:false},
	},
	methods: {
		down(){
			if (this.selectedIndex+1 < this.count_suggestions){
				this.selectedIndex++
			} else {
				this.selectedIndex = this.forceSuggestion ? 0 : -1
			}
		},
		up(){
			if(this.selectedIndex > this.first_index){
				this.selectedIndex--
			} else {
				this.selectedIndex = this.count_suggestions - 1
			}
		},
		onInput(){
			this.$emit('input', this.$refs.input.value)//debounched?
			this.selectedIndex = this.first_index
		},
		onSubmit(){
			if(!this.isSuggestionsShown || this.selectedIndex < 0){
				this.$emit('submit', this.$refs.input.value)
				return
			}
			this.$emit('pick-suggestion', this.selectedIndex)
		},
		onClickOutside(){
			this.$emit('click-outside')
		}
	},
	watch: {
		selectedIndex(newVal){
			this.$emit('selecting', newVal)
		}
	},
	mounted(){
		this.first_index = this.forceSuggestion ? 0 : -1
		this.d_focused = this.focused
	},
}
</script>

<style>

</style>