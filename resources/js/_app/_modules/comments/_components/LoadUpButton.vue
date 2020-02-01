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
			if (this.pagination && this.pagination.prevPage){
				return (this.pagination.prevPage*this.pagination.perPage)
			}
			return 0
		},
		button(){
			return {
				class: 'loadUpButton hover:text-blue-500',
				value: 'Incarca comentarii mai vechi ('+ this.count +')'
			}
		},
		loadPage_args(){
			return {
				pagination: this.$store.state.entities.comments.filters.target,
				page: this.pagination.prevPage
			}
		}
	},
}
</script>