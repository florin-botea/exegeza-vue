<template>
	<section class="p-1 pt-0 overflow-x-hidden">
		<pre class="text-justify whitespace-pre-wrap" 
			v-html="parsedText">
		</pre>
	</section>
</template>
<script>
import parser from './inputs/_text-parser'
import debounce from 'lodash/debounce'

export default {
	props: { text: String },
	data: () => ({
		parsedText: ''
	}),
	watch: {
		text: debounce(function(newVal){
			this.parsedText = parser.parseText(newVal)
		}, 300)
	},
	mounted(){
		this.parsedText = parser.parseText(this.text)
	}
}
</script>