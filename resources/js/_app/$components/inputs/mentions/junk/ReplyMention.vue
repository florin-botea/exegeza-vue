<template>
	<form v-on:submit.prevent>
		<div class="form-row p-1">
			<div class="form-group mb-0 col-2">
				<input class="form-control form-control-sm" type="text" placeholder="reply_id" v-model="reply_id"
				v-focus="focused" @focus="focused=true" @blur="focused=false">
			</div>
			<div class="form-group mb-0 col-auto">
				<input class="form-control form-control-sm" type="text" placeholder="description" v-model="description">
			</div>
			
			<div class="btn-group mb-0 col-auto">
				<button @click="onSubmit" class="btn-sm btn-dark">
					add
				</button>
				<button @click="$emit('abort')" class="btn-sm btn-warning">
					cancel
				</button>
			</div>
		</div>
	</form>
</template>

<script>

import replyMention from './reply-mention'

export default {
	data: () => ({
		reply_id: null,
		description: '',
		focused: true
	}),
	methods: {
		onSubmit()
		{
			if ( !this.reply_id || !parseInt(this.reply_id) ){
				alert('Te rugam sa introduci un ID de raspuns valid.')
				return
			}
			if ( this.description.length < 2 ){
				alert('Te rugam sa introduci o descriere sub care va aparea raspunsul.')
				return
			}
			let insertion = replyMention.create( {
				reply_id: this.reply_id,
				description: this.description
			})
			this.$emit('submit', insertion)
			this.clearForm()
		},
		clearForm()
		{
			this.reply_id = null,
			this.description = ''
		}
	}
}
</script>