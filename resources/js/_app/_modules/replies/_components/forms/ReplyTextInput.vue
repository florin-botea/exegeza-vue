<template>
	<ValidationProvider name="text" class="px-1" rules="required|min:50|max:2000" v-slot="{ errors }" mode="passive">
		<ItemedTextarea v-model="innerValue" :min="50" :max="5000" :autofocus="true"/>
		<span class="text-danger" v-for="error in errors">
			{{ error }}
		</span>
	</ValidationProvider>
</template>

<script>
	import ItemedTextarea from '@/$components/inputs/ItemedTextarea'
	
	export default {
		components: {ItemedTextarea},
		props: {
			value: {type:String}
		},
		data: () => ({
			innerValue: ''
		}),
		watch: {
			innerValue(val){
				this.$emit('input', val)
			},
			value(val){
				this.innerValue = val
			}
		},
	}
</script>