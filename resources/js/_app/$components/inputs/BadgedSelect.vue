<style>
	.badge-select-option {
		display: block;
		width: 100%;	
		border-style: solid;
		border-width: 0px 1px 1px 0px;
		opacity: 0.6;
		transition: 0.3s;
		box-shadow: 2px 0px;
		font-weight: 900;
	}
	.badge-select-option:hover {
		opacity: 1;
	}
</style>

<template>
	<div class="badge" style="position:relative; background-color:white;">
		<span ref="toggler" class="badge badge-select-option" :class="selected_class" v-html="selected_name" @click="toggle"></span>
		<div v-show="isShown" v-click-outside="hide">
			<div v-for="(option, index) in options" class="badge badge-select-option" :class="option.name.split(' ').join('-')"
				@click="select(index)"
			>
				{{ option.name }}
			</div>
		</div>
	</div>
</template>

<script>

export default {
	data(){
		return {
			isShown: false
		}
	},
	props: {
		options: {type:Array},
		selected: Object,
	},
	methods: {
		select(index){
			this.$emit('change', this.options[index])
			this.isShown = false
		},
		unselect(){
			this.$emit('change', this.unselected)		
			this.isShown = false			
		},
		toggle(){
			this.isShown == false ? this.isShown = true : this.isShown = false
		},
		hide(e){
			if (! this.$refs.toggler.isEqualNode(e.target) ){
				this.isShown = false
			}
		}
	},
	computed: {
		selected_class(){
			return this.selected.name.split(' ').join('-')
		},
		selected_name(){
			return this.selected.name
		}
	}
}
</script>