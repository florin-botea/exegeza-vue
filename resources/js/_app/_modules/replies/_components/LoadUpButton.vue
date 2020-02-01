<script>
import {mapGetters,mapActions,mapState} from 'vuex'
import LoadPageButton from '@/$components/buttons/LoadPageButton.vue'

export default {
	extends: LoadPageButton,
	methods: {
		...mapActions('entities/comments', ['getPage'])
	},
	computed: {
		pagination(){
			return this.$store.state.entities.replies.paginations[this.pagination_id]
		},
		count(){
			if (this.pagination && this.pagination.prevPage){
				return (this.pagination.prevPage*this.pagination.perPage)
			}
			return 0
		},
		button(){
			return {
				class: 'loadUpButton hover:text-blue-500',
				value: 'Incarca raspunsuri mai vechi ('+ this.count +')'
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