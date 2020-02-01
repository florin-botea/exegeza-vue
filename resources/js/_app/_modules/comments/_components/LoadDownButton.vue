<script>
import {mapGetters,mapActions,mapState} from 'vuex'
import LoadPageButton from '@/$components/buttons/LoadPageButton.vue'

export default {
	extends: LoadPageButton,
	methods: {
		...mapActions('entities/comments', ['getPage'])
	},
	computed: {
		...mapGetters({
			pagination: 'entities/comments/activePagination'
		}),
		count(){
			if (this.pagination && this.pagination.nextPage){
				return this.pagination.total - ((this.pagination.nextPage-1)*this.pagination.perPage)
			}
			return 0
		},
		button(){
			return {
				class: 'loadDownButton hover:text-blue-500',
				value: 'Incarca comentarii mai recente ('+ this.count +')'
			}
		},
		loadPage_args(){
			return {
				pagination: this.$store.state.entities.comments.filters.target,
				page: this.pagination.nextPage
			}
		}
	},
}
</script>

<style>
.loadDownButton {
	@apply rounded-b-lg;
	@apply w-full;
	@apply shadow-md;
	@apply text-sm;
	@apply py-2;
	@apply font-semibold;
	@apply text-gray-900;
}
</style>