<template>
	<div class="flex">
		<input ref="footer" class="border border-gray-500 rounded px-2 flex-1" type="text" placeholder="footer" v-model="footer">
		
		<button class="bg-gray-900 shadow hover:bg-black px-2 rounded text-white"
		@click="onSubmit">
			<i class="fas fa-check"></i>
		</button>
		<button class="shadow-md hover:text-red-500 px-2 rounded border border-gray-600"
		@click="$emit('abort')">
			<i class="fas fa-times"></i>
		</button>
	</div>
</template>

<script>

import noteMention from './note-mention'

export default {
	data: () => ({
		footer: '',
	}),
	props:{
		text: {type:String, default:''},
	},
	methods: {
		onSubmit()
		{
			if ( this.footer.length < 3 ){
				this.$refs.footer.focus()
				return
			}
			this.$emit('submit', this.footer)
			this.footer = ''
		}
	},
	mounted(){
		this.$refs.footer.focus()
	}
}
</script>