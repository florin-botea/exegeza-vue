<template>
	<div>
		<div class="flex">
			<input ref="comment_id" class="appearance-none border border-gray-500 rounded px-2 w-1/3" :class="{'border-red-600 border-l-4':validationErrors.includes('comment_id')}" type="text" placeholder="comment_id"
			v-model="comment_id" @input="showErrors=false">
			
			<input ref="description" class="ml-1 flex-1 border border-gray-500 rounded px-2" type="text" :class="{'border-red-600 border-l-4':validationErrors.includes('description')}" placeholder="description" v-model="description"
			@input="showErrors=false">
			
			<button class="bg-gray-900 shadow hover:bg-black px-2 rounded text-white"
			@click="onSubmit">
				<i class="fas fa-check"></i>
			</button>
			<button class="shadow-md hover:text-red-500 px-2 rounded border border-gray-600"
			@click="$emit('abort')">
				<i class="fas fa-times"></i>
			</button>
		</div>
		<!-- <span v-if="showErrors" class="text-red-500 text-xs" v-for="(error, prop) in validationErrors"> -->
			<!-- {{error.text}};  -->
		<!-- </span> -->
	</div>
</template>

<script>

import commentMention from './comment-mention'
import debounce from 'lodash/debounce'

export default {
	data: () => ({
		comment_id: null,
		description: '',
		focused:true,
		validationErrors: [],
	}),
	methods: {
		onSubmit()
		{
			this.validate()
			if (this.validationErrors.length){
				this.$refs[this.validationErrors[0]].focus()
				return
			}
			let insertion = commentMention.create( {
				comment_id: this.comment_id,
				description: this.description
			})
			this.$emit('submit', insertion)
			this.clearForm()
		},
		clearForm()
		{
			this.comment_id = null,
			this.description = ''
		},
		validate(){
			this.validationErrors = [];
			(!isNaN(this.comment_id) && this.comment_id) || this.validationErrors.push('comment_id');
			(this.description.length > 3) || this.validationErrors.push('description');
		}
	},
	mounted(){
		this.$refs.comment_id.focus()
	}
}
</script>