<template>
	<span class="inline-block leading-none m-1 rounded px-2 bg-gray-400 font-semibold hover:bg-gray-600 border border-gray-600 cursor-pointer" :id="'tag_'+tag.id"
	@click="showDetails=true">
		{{ tag.details.name }}
		<can I="delete" :this="tag">
			<span class="ml-1 hover:text-red-500 cursor-pointer" @click="removeTag()">x</span>
		</can>
	</span>
</template>

<script>
import Tag from '@/models/Tag'

export default {
	props: {
		tag: {type:Object,required:true}
	},
	data: () => ({
		showDetails: false
	}),
	methods: {
		f(){
		
		},
		async removeTag(){
			Tag.$delete({params: {id:this.tag.id}})
		}
	},
}
</script>