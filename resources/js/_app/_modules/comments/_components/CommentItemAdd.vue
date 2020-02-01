<template>
	<div>
		<button v-if="!isShown" class="bg-gray-900 hover:bg-black rounded text-white font-semibold px-3"
		@click="isShown=true">
			Adauga un comentariu
		</button>

		<AddCommentForm :key="pagination_id" v-if="isShown" :pagination_id="pagination_id"
		@close-me-pls="isShown=false"/>
		
		<div style="height:100px;"></div>
	</div>
</template>

<script>
	import {mapGetters,mapMutations} from 'vuex'
	import Comment from '@/models/Comment'
	import AddCommentForm from './forms/AddCommentForm.vue'

	export default {
		components: {AddCommentForm},
		props: {
			pagination_id: {required:true}
		},
		data: () => ({
			isShown: false,
		}),
	}
</script>