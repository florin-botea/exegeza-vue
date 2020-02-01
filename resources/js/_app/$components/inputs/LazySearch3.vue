<template>
	<div class="input_select" v-click-outside.bubble="hideSuggestions">
		<input type="text" autocomplete="off" :class="inputClass" v-model="input_value"
		v-bind="$attrs" ref="input" @input="onInput($event)"
		@keyup.down="next" @keyup.up="prev" @keyup.enter="onKeyEnter"
		@focus="isSuggestionsShown=true">
		<div v-show="isSuggestionsShown" style="overflow:visible;height:0px;z-index:20">
			<slot :selectedIndex="selectedIndex" :mouseSelect="mouseSelect"></slot>
		</div>
	</div>
</template>

<script>
	export default {
		inheritAttrs: false,
		props: {
			suggestions: {type:Array, required:true},
			valueProp: {type:Function, required:true},
			build: {type:Function, required:true},
			inputClass: String,
		},
		data: () => ({
			selectedIndex: -1,
			first_index: -1,
			isSuggestionsShown: false,
			input_value: '',
			backup_value: ''
		}),
		computed: {
			countSuggestions(){
				return this.suggestions.length
			},
			firstIndex(){
				return -1
			}
		},
		methods: {
			next(){
				this.selectedIndex+1 < this.countSuggestions ? this.selectedIndex++ : (this.countSuggestions ? this.selectedIndex = 0 : this.selectedIndex = -1)
				this.isSuggestionsShown = true
			},
			prev(){
				this.selectedIndex > this.firstIndex ? this.selectedIndex-- : this.selectedIndex = this.firstIndex
			},
			onInput(input){
				this.$emit('input', input)
				this.isSuggestionsShown = true
				this.backup_value = input.target.value
				this.selectedIndex = this.first_index
			},
			onKeyEnter(){
				if (this.isSuggestionsShown && this.countSuggestions > 0){
					this.isSuggestionsShown = false
					return
				}
				this.isSuggestionsShown = false
				this.submit()
			},
			mouseSelect(index){
				this.isSuggestionsShown = false
				console.log(this.suggestions[index])
				this.selectedIndex = index
				this.$refs.input.focus()
				//this.input_value = this.valueProp( this.suggestions[index] )
			},
			submit(){
				if (this.selectedIndex >= 0){
					this.$emit('submit', this.suggestions[this.selectedIndex])
				} else {
					this.$emit('submit', this.build(this.input_value))
				}
			},
			clearForm(){
				this.input_value = ''
				this.backup_value = ''
			},
			hideSuggestions(){
				this.isSuggestionsShown = false
			}
		},
		watch: {
			selectedIndex(newVal){
				this.input_value = newVal > -1 && this.countSuggestions ? this.valueProp( this.suggestions[newVal] ) : this.backup_value
			}
		},
	}
</script>

<style>

</style>