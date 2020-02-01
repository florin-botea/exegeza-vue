<template>
	<div class="z-60">
		<span v-if="!tag_area" class="hover:text-blue-500 cursor-pointer" @click="tag_area=true">
			+<i class="fas fa-tag"></i>
		</span>
		
		<AddTagForm v-if="tag_area" ref="tag_input" :pending="pending" @submit="submit" @close="tag_area=false"/>
	</div>
</template>

<script>
	import Tag from '@/models/Tag'
	import { mapActions, mapState } from 'vuex'
	import AddTagForm from './TagForm'

	export default {
		components: {AddTagForm},
		props: {
			comment_id: Number,
		},
		data: () => ({
			tag_area: false,
			pending: false
		}),
		methods: {
			async submit(tag_obj)
			{
				if(tag_obj.name.length < 2 || tag_obj.name.length > 25){
					alert('intre 2 si 25 caractere')
					return
				}
				let duplicate = this.tags.filter(tag => {
					return tag.details.name.toLowerCase() === tag_obj.name.toLowerCase()
				})
				if( duplicate.length ){
					DOMel.tag(duplicate[0].id).shake(1000)
					return
				}
				this.pending = true
				tag_obj.comment_id = this.comment_id
				try {
					await Tag.$create({ data:tag_obj })
					this.$refs.tag_input.clearForm()
					this.suggestions = []
				} catch(e){
					VueBus.$emit('error-occured', e)
				}
				this.pending = false
			},
		},
		computed:{
			tags(){
				return Tag.query().where('comment_id', this.comment_id).get()
			},
		},
	}
</script>