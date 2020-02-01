<template>
	<article class="comment p-1 shadow-lg mb-3 mr-1" :id="'comment_'+comment.id"
	:class="{'bg-red-200':isRepported}">
		<header class="flex flex-wrap" v-show="!edit_form">
			<AuthorCard :postUrl="commentUrl" :author_id="comment.user_id" :post_id="comment.id"/>
			<small class="text-xs">{{comment.created_at}}</small>
			<CommentItemActions v-if="auth" :model="comment" @edit="edit_form=true"/>
			<PostTitle :text="comment.title"/>
		</header>
		
		<PostText :text="comment.text" v-show="!edit_form"/>
		
		<TagsSection :comment_id="comment.id" v-show="!edit_form"/>
		<br>

		<EditCommentForm v-if="edit_form" :predefined="comment"
		:signifiantData="signifiantData" @close-me-pls="edit_form=false"/>
		
		<RepliesSection :comment_id="comment.id" :replies_count="comment.replies_count"/>
	</article>
</template>

<script>
import {mapActions,mapState} from 'vuex'
import Comment from '@/models/Comment'
//import ReplyPagination from './../../store/models/ReplyPagination'
import DeletionRequest from '@/models/DeletionRequest'
import TagsSection from '@/_modules/tags'
import CommentItemActions from './CommentItemActions.vue'
import AuthorCard from '@/$components/AuthorCard.vue'
import PostTitle from '@/$components/PostTitle.vue'
import PostText from '@/$components/PostText.vue'
//import FlagsSection from './FlagsSection.vue'
import EditCommentForm from './forms/EditCommentForm.vue'
import RepliesSection from '@/_modules/replies'
//import { mapActions, mapMutations, mapGetters, mapState } from 'vuex'

export default {
	components: {
		RepliesSection,
		EditCommentForm,
		TagsSection,
		CommentItemActions,
		AuthorCard,
		PostTitle,
		PostText
	},
	props: {
		comment: Object
	},
	data: () => ({
		edit_form: false,
		pending: false
	}),
	computed: {
		auth() {
			return this.$store.state.auth
		},
		repliesPagination(){
			return ReplyPagination.find(this.comment.id)
		},
		isRepported(){
			return DeletionRequest.query().where( (repp) => {
				return repp.model_id == this.comment.id && repp.model_type == 'App\\Comment'
			}).first()
		},
		commentUrl(){
			return window.location.origin+'/bible-resources/'+this.comment.target+'?comment='+this.comment.id
		}
	},
	methods: {
		signifiantData(newText, oldText){
			return newText.length > 30
		},
		async updateComment(comment){
			this.pending = true
			await Comment.$update({
				params: {id:comment.id},
				data: comment
			})
			this.pending = false
		}
	},
}
</script>
<style>

</style>