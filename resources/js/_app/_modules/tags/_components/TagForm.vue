<template>
	<form @submit.prevent onkeydown="return event.key != 'Enter'">
		<div class="flex">
			<TagInput ref="tag_input" class="z-50" :inputClass="'px-2 border rounded border-gray-500'" :suggestions="suggestions" :autofocus="true"
			:valueProp="(suggestion)=>suggestion.name" :build="(val)=>({id:0,name:val})"
			v-debounce:500ms="getTagSuggestion" @submit="$emit('submit',$event)">
				<template v-slot:default="{selectedIndex,mouseSelect}">
					<div class="suggestion hover:bg-gray-300 bg-white border border-b border-gray-600 px-2 py-1" v-for="(option, index) in suggestions" 
					@click="mouseSelect(index)"
					:class="{'bg-gray-300':selectedIndex === index}">
						{{ option.name }}
					</div>
				</template>
			</TagInput>
			<SubmitBtn :btnClass="'bg-gray-900 shadow hover:bg-black px-2 rounded text-white'" :pending="pending" 
			@click="onSubmitBtn">
				<i class="fas fa-check"></i>
			</SubmitBtn>
			<button @click="$emit('close')" class="shadow-md hover:text-red-500 px-2 rounded border border-gray-600">
				<i class="fas fa-times"></i>
			</button>
		</div>
	</form>
</template>

<script>
	import TagInput from '@/$components/inputs/LazySearch3'
	import SubmitBtn from '@/$components/buttons/SubmitBtn'
	import Tag from '@/models/Tag'
	import { mapActions, mapState } from 'vuex'

	export default {
		components: {TagInput,SubmitBtn},
		props: {
			pending: {type:Boolean, default:false}
		},
		data: () => ({
			suggestions: [],
		}),
		methods: {
			getTagSuggestion(qs)
			{
				if (!qs.length) return
				axios.get('/taguri?qs='+qs).then( res => {
					this.suggestions = res.data
				})
			},
			onSubmitBtn()
			{
				this.$refs.tag_input.submit()
			},
			clearForm(){
				this.$refs.tag_input.clearForm()
			}
		}
	}
</script>