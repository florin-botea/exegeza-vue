<template>
	<div class="reply p-1 shadow-inner mb-2 border-l-2 border-gray-600" :class="computedClasses" :id="'reply_'+reply.id">
		<header class="flex flex-wrap" v-show="!edit_form">
			<div class="" v-if="reply.re_reply">
				<i class="fas fa-reply-all"></i>
			</div>
			<AuthorCard :postUrl="replyUrl" :author_id="reply.user_id" :post_id="reply.id" :created_at="reply.created_at"/>
			<small class="text-xs">{{reply.created_at}}</small>
			<ReplyItemActions :model="reply" @edit="edit_form=true"/>
		</header>
		
		<PostText :text="reply.text" v-show="!edit_form"/>
		
		<div class="flex justify-between px-3" v-show="!re_re_form && !edit_form">
			<div class="hover:text-blue-500 cursor-pointer" title="thread-view"
			:class="{'text-blue-500':reply.id===activeThread.id}"
			@click="setActiveThread(reply)">
				<i class="fas fa-bullseye"></i>
			</div>
			<div class="hover:text-blue-500 cursor-pointer" @click="re_re_form=true">
				<i class="fas fa-reply-all"></i>
			</div>
		</div>
		
		<AddReplyForm v-if="re_re_form" :pagination_id="reply.comment_id" :re_reply="reply.id"
		@close-me-pls="re_re_form=false"/>

		<EditReplyForm v-if="edit_form" :subject="reply" @close-me-pls="edit_form=false"/>
	</div>
</template>

<script>
	import {mapState,mapActions,mapMutations} from 'vuex'
	import Reply from '@/models/Reply'
	import Comment from '@/models/Comment'
	import DeletionRequest from '@/models/DeletionRequest'
	import AddReplyForm from './forms/AddReplyForm'
	import EditReplyForm from './forms/EditReplyForm.vue'
	import ReplyItemActions from './ReplyItemActions.vue'
	import AuthorCard from '@/$components/AuthorCard.vue'
	import PostText from '@/$components/PostText.vue'
	
	export default {
		components: {
			AddReplyForm,
			EditReplyForm,
			ReplyItemActions,
			AuthorCard,
			PostText
		},
		props: {
			reply: Object,
		},
		data: () => ({
			edit_form: false,
			re_re_form: false,
			pending: false
		}),
		computed: {
			...mapState('entities/replies', ['activeThread']),
			isRepported(){
				console.log(DeletionRequest.query().all())
				return DeletionRequest.query().where( (repp) => {
					return repp.model_id == this.reply.id && repp.model_type == 'App\\Reply'
				}).first()
			},
			computedClasses(){
				let parent = this.reply.id === this.activeThread.re_reply
				let child = this.reply.re_reply === this.activeThread.id
				let selected = this.reply.id === this.activeThread.id
				return parent || child || selected ? 'bg-orange-200' : (this.isRepported ? 'bg-red-300' : '')
			},
			replyUrl(){
				let comment = Comment.find(this.reply.comment_id)
				return window.location.origin+'/bible-resources/'+comment.target+'?comment='+comment.id+'&reply='+this.reply.id
			}
		},
		methods: {
			...mapMutations('entities/replies', ['setActiveThread'])
		},
	}
</script>