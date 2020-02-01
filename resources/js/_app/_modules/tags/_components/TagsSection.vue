<template>
	<div class="relative z-30">
		<small>Tag-uri:</small>
		<div class="flex flex-wrap mb-2">
			<TagItem v-for="tag in tags" :tag="tag" :key="tag.id"/>
		</div>
		
		<can I="update tags" :on="comment">
			<AddTag :comment_id="comment_id"/>
		</can>
	</div>
</template>

<script>
	import TagInput from '@/$components/inputs/LazySearch3'
	import Tag from '@/models/Tag'
	import Comment from '@/models/Comment'
	import TagItem from './TagItem.vue'
	import AddTag from './AddTag'

	export default {
		components: {TagInput,AddTag,TagItem},
		props: {
			comment_id: Number,
		},
		data: () => ({
			tag_area: false,
		}),
		computed:{
			tags(){
				return Tag.query().with('author').where('comment_id', this.comment_id).get()
			},
			comment(){
				return Comment.find(this.comment_id)
			}
		},
	}
</script>