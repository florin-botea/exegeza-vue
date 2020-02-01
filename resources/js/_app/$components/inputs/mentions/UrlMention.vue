<template>
	<div>
		<div class="flex">
			<input ref="url" class="flex-1 border border-gray-500 rounded px-2" @input="showErrors=false"
			type="text" :class="{'border-red-600 border-l-4':validationErrors.includes('url')}" placeholder="url" v-model="url">
			
			<button class="bg-gray-900 shadow hover:bg-black px-2 rounded text-white"
			@click="onSubmit">
				<i class="fas fa-check"></i>
			</button>
			<button class="shadow-md hover:text-red-500 px-2 rounded border border-gray-600"
			@click="$emit('abort')">
				<i class="fas fa-times"></i>
			</button>
		</div>
	</div>
</template>

<script>

export default {
	data: () => ({
		url: '',
		validationErrors: [],
	}),
	methods: {
		onSubmit()
		{
			this.validate()
			if (this.validationErrors.length){
				this.$refs.url.focus()
				return
			}
			this.$emit('submit', this.url)
			this.clearForm()
		},
		clearForm()
		{
			this.url = null,
			this.description = ''
		},
		validate(){
			this.validationErrors = [];
			(this.url.length > 6) || this.validationErrors.push('url');
		}
	},
	mounted(){
		this.$refs.url.focus()
	}
}
</script>