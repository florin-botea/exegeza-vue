<template>
	<div class="" v-if="count > 0 || error">
		<button @click="load" :class="button.class" :disabled="loading || error">
			<span v-show="!loading && !error"> {{button.value}} </span>
			<Loading class="mx-auto" v-show="loading || error" :error="error"/>
		</button>
	</div>
</template>

<script>
import Loading from '@/$components/Loading'

export default {
	props: {
		pagination_id: {required:true,type:Number}
	},
	components: {
		Loading 
	},
	data: () => ({
		loading: false,
		error: false
	}),
	methods: {
		async load(){
			this.loading = true
			let response = await this.getPage(this.loadPage_args)
			this.error = !response
			this.loading = false
		}
	},
	computed: {
		button(){
			//class: '',
			//value: ''
		},
		count(){
			//
		},
	},
}
</script>

<style>
.loadUpButton {
	@apply rounded-t-lg;
	@apply w-full;
	@apply shadow-md;
	@apply text-sm;
	@apply py-2;
	@apply font-semibold;
	@apply text-gray-900;
	@apply bg-yellow-100;
}

.loadDownButton {
	@apply rounded-b-lg;
	@apply w-full;
	@apply shadow-md;
	@apply text-sm;
	@apply py-2;
	@apply font-semibold;
	@apply text-gray-900;
}
</style>