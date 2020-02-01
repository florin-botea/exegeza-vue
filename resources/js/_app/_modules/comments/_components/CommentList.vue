<template>
	<CommentSectionWrapper v-if="comm_target" class="commentSection"
	:class="{'w-full':isShown, 'w-0':isShown===false}">
		<div class="absolute w-screen md:w-full h-full overflow-x-visible">
			<div class="h-12"></div>
			<h1 class="bg-orange-300 text-center">Comentarii</h1>
			
			<LoadUpButton class="h-8 mb-4 comment mr-1" :pagination_id="comm_target"/>
			
			<CommentItem v-for="comment in comments" :key="comment.id"
				:comment="comment"
			/>
			
			<div v-show="pending || error">
				<Loading class="mx-auto" :error="error"/>
			</div>
			
			<LoadDownButton class="h-8 mb-4 comment mr-1" :pagination_id="comm_target"/>
			
			<can I="create" a="Comment">
				<CommentItemAdd v-show="!pending" :pagination_id="comm_target" :key="comm_target"/>
			</can>

			<div v-if="!auth" class="text-orange-500 font-bold mb-32">
				Autentifica-te pentru a putea posta!
			</div>
		</div>
	</CommentSectionWrapper>
</template>

<script>
import Loading from '@/$components/Loading.vue'
import CommentSectionWrapper from './CommentSectionWrapper.vue'
import CommentItem from './CommentItem.vue'
import CommentItemAdd from './CommentItemAdd.vue'
//import CommentPagination from './../../store/models/CommentPagination'
import Comment from '@/models/Comment'
import {mapActions,mapMutations,mapState,mapGetters} from 'vuex'
import LoadDownButton from './LoadDownButton'
import LoadUpButton from './LoadUpButton'
import Vue from 'vue'

export default {
	components: {
		Loading,
		CommentItem,
		LoadDownButton,
		LoadUpButton,
		CommentItemAdd,
		CommentSectionWrapper
	},
	data: () => ({
		pending: false,
		error: false,
	}),
	methods: {
		async _getPage(pagination_id){
			this.pending = true
			let result = await this.$store.dispatch('entities/comments/getPage', {pagination:pagination_id})
			this.error = !result
			this.pending = false
		},
	},
	computed:{
		...mapState({
			auth: (state) => state.auth,
			comm_target: (state) => state.entities.comments.filters.target,
			isShown: (state) => state.ui.commentsSectionShown
		}),
		...mapGetters({
			comments: 'entities/comments/paginationComments'
		})
	},
	watch:{
		comm_target(newVal, oldVal){
			if (oldVal) this.$store.commit('setUIState', {prop:'commentsSectionShown', value:true});
			this._getPage(newVal)
		},
		
	},
	mounted(){
		var route = this.$store.state.route
		var notifSubject = null;
		if (route.queryStrings.verse && !route.queryStrings.comment){
			notifSubject = () => DOMel.verse(route.queryStrings.verse)
		}
		if (route.queryStrings.comment && !route.queryStrings.reply){
			notifSubject = () => DOMel.comment(route.queryStrings.comment)
		}
		if (route.queryStrings.comment && route.queryStrings.reply){
			notifSubject = () => DOMel.reply(route.queryStrings.reply)
		}
		if (!notifSubject){
			return
		}
		this.$store.commit('setUIState', {prop:'commentsSectionShown',value:true})
		var attempts = 0;
		var i = setInterval(function(){
			attempts++
			if (notifSubject().el){
				clearInterval(i)
				notifSubject().bringIntoFocus()
			} else if ( attempts > 10 ){
				clearInterval(i)
				Vue.notify({
					group: 'notifications',
					duration: 5000,
					type: 'bg-red-300',
					title: 'Error 404',
					text: 'Aceasta resursa nu exista, sau a fost stearsa.'
				})
			}
		}, 300)
	}
}
</script>

<style>
@media screen and (max-width: 767px) {
	.commentSection {
		transition: width 0.5s;
	}
}
</style>