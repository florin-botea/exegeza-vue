<template>
	<div class="h-8 w-full mb-4" v-if="pagination"
	v-show="count > 0 || error">
		<button v-show="!loading && !error" @click="loadNextPage"
		class="loadDownButton bg-yellow-100 hover:text-blue-500">
			Incarca comentarii mai recente ({{ count }})
		</button>
		
		<Loading class="mx-auto" v-show="loading || error" :error="error"/>
	</div>
</template>

<script>
import Loading from '@/$components/Loading'
import {mapGetters,mapActions,mapState} from 'vuex'
//import CommentPagination from './../../store/models/CommentPagination'
import Comment from '@/models/Comment'

export default {
	data: () => ({
		loading: false
	}),
	methods: {
		...mapActions('entities/comments', ['nextPage']),
		async loadNextPage(){
			this.loading = true
			let comments = await this.nextPage(this.pagination)
			this.loading = false
		}
	},
	computed: {
		...mapGetters({
			pagination: 'entities/comments/activePagination'
		}),
		count(){
			return this.pagination.total - (this.pagination.loadedSequenceEnd*this.pagination.perPage)
		},
		error() {
			return this.pagination.loadedSequenceEnd === null
		}
	},
	components: { Loading },
}
</script>

<style>

</style>