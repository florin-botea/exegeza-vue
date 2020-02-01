<template>
  <section class="relative ml-2 shadow-inner">
		<LoadUpButton :pagination_id="comment_id"/>
		
		<ReplyItem v-for="reply in replies" :reply="reply" :key="reply.id"/>
		
		<div class="flex flex-wrap-reverse justify-between items-center">
			<can I="create" a="Reply">
				<ReplyItemAdd :comment_id="comment_id"/>
			</can>
			<div class="delimiter"></div>
			<LoadDownButton :pagination_id="comment_id" :replies_count="replies_count"/>
		</div>
	</section>
</template>

<script>
	import {mapActions, mapGetters, mapMutations, mapState} from 'vuex'
	import Reply from '@/models/Reply'
	import Comment from '@/models/Comment'
	import ReplyItem from './ReplyItem.vue'
	import ReplyItemAdd from './ReplyItemAdd.vue'
	import LoadDownButton from './LoadDownButton'
	import LoadUpButton from './LoadUpButton'

	export default {
		components: {
			ReplyItem,
			ReplyItemAdd,
			LoadDownButton,
			LoadUpButton
		},
		props: {
			comment_id: Number,
			replies_count: Number
		},
		computed: {
			replies(){
				return Reply.query().where('comment_id', this.comment_id).orderBy('id', 'asc').all()
			},
			comment(){
				return Comment.find(this.comment_id)
			}
		}
	}
</script>