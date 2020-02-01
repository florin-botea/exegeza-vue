<template>
	<div class="lazy_form" v-bind="$attrs">
		<div>
			<input class="lazy_form__input" ref="input" type="text" v-model="searchQuery" @input="isAutocompleting=false;selectedIndex=-1" v-on:keyup="select">
			<div style="overflow:visible;height:0px;" v-if="isSuggestionsShown">
				<div class="lazy_form__suggestios" style="position:relative; background-color:white;z-index:999;"
					v-click-outside="hide" >
					<div class="lazy_form__suggestion" v-for="(suggestion, index) in suggestions" 
						@click="setValue(index)" :class="{'lazy_form__suggestion--selected':index==selectedIndex}">
						{{ suggestion.name }}
					</div>
				</div>
			</div>
		</div>
		<button v-if="submitBtnValue" class="lazy_form__submit_btn" @click="submit">
			{{submitBtnValue}}
		</button>
		<slot></slot>
	</div>
</template>

<script>

const fn = function (){
	console.log('debouche emitting')
	this.$emit('input', this.searchQuery)
}

import {core} from 'lodash'
export default {
  data: function (){
		return {
			isSuggestionsShown: false,
			isAutocompleting: false,
			selectedIndex: -1,
			searchQuery: ''
		}
	},
	props: {
		suggestions: Array,
		clearOnSubmit: {default:false, type:Boolean},
		submitBtnValue: '',
		wait: {
			type: Number,
			default: 500
		}
	},
	methods: {
		hide(){
			this.isSuggestionsShown = false
		},
		setValue (index){
			this.isAutocompleting = true
			this.isSuggestionsShown = false
			this.searchQuery = this.suggestions[index].name
			this.selectedIndex = index
			this.$refs.input.focus()
		},
		select (){
			if (event.keyCode == 40){
				if (!this.isSuggestionsShown){
					this.isSuggestionsShown = true
					return
				}
				if (this.selectedIndex < this.suggestions.length - 1) this.selectedIndex++
			} else if (event.keyCode == 38){
				if (this.selectedIndex > -1) this.selectedIndex--
			} else if (event.keyCode == 13){
				if ( (this.selectedIndex == -1 || this.isSuggestionsShown == false) ){
					this.submit()
					return
				}
				this.setValue(this.selectedIndex)
			}
		},
		submit (){
			let custom = {id:null}
			custom.name = this.searchQuery
			let eVal = this.selectedIndex >= 0 ? this.suggestions[this.selectedIndex] : custom
			this.$emit('submit', eVal)
			this.isSuggestionsShown = false
			if (this.clearOnSubmit){
				this.searchQuery = ''
			}
		},
	},
  watch: {
    searchQuery: function () {
			if (!this.isAutocompleting && this.searchQuery.length > 0){
				this.selectedIndex = -1
				this.isSuggestionsShown = true
				this.fetchData()
			} else {
				this.isSuggestionsShown = false
			}
    }
  },
  computed: {
    fetchData (){
			return _.debounce(fn , this.wait)
		}
  }
}
</script>