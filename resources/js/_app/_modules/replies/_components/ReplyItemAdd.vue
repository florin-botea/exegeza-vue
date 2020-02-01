<template>
	<div :class="{'w-full':isShown}">
		<div class="flex items-center relative w-full" v-show="!isShown">	
			<button class="rounded shadow-md hover:text-blue-500 text-gray-900 font-semibold px-3 py-1 z-10" 
			:class="{invisible:fetching || isShown}"
			@click="showPostForm">
				Adauga un raspuns
			</button>
			<div class="absolute ml-auto mr-auto" style="height:10px;width:10px;left:50%;margin-left:-5px;">
				<fade-loader :loading="fetching" :color="'green'" :height="'7px'" :width="'2px'" :radius="'7px'"/>
			</div>
		</div>

		<AddReplyForm v-if="isShown" :pagination_id="comment_id" @close-me-pls="isShown=false"/>
	</div>
</template>

<script>
	import {mapActions,mapMutations} from 'vuex'
	import Reply from '@/models/Reply'
	//import ReplyPagination from './../../store/models/ReplyPagination'
	import AddReplyForm from './forms/AddReplyForm'

	export default {
		components: {
			AddReplyForm,
		},
		props: {
			comment_id: Number,
		},
		data: () => ({
			fetching: false,
			isShown: false,
			//pending: false
		}),
		methods: {
			async showPostForm(){
				let pagination_id = this.comment_id
				this.fetching = true
				await this.getPage({pagination:pagination_id})
				this.isShown = true
				this.fetching = false
			},
			...mapActions('entities/replies', ['getPage']),
		}
	}
</script>