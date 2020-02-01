<template>
	<h1 class="w-full text-lg font-medium font-semibold p-1 whitespace-pre-wrap break-all" 
		v-html="parsedTitle">
	</h1>
</template>
<script>
	import parser from './inputs/_text-parser'
	export default {
		props: { text: String },
		computed: {
			parsedTitle(){
				return parser.parseText(this.text)
			},
		}
	}
</script>
<style>


</style>