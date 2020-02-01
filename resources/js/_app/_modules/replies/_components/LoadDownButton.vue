<script>
import {mapGetters,mapActions,mapState} from 'vuex'
import LoadPageButton from '@/$components/buttons/LoadPageButton.vue'

export default {
	extends: LoadPageButton,
	props: {
		replies_count: {type:Number, required:true}
	},
	methods: {
		...mapActions('entities/replies', ['getPage'])
	},
	computed: {
		pagination(){
			return this.$store.state.entities.replies.paginations[this.pagination_id]
		},
		count(){
			if (!this.pagination && this.replies_count){
				return this.replies_count
			}
			if (this.pagination && this.pagination.nextPage){
				return this.pagination.total - ((this.pagination.nextPage-1)*this.pagination.perPage)
			}
			return 0
		},
		button(){
			return {
				class: 'rounded w-full shadow-md hover:text-blue-500 text-gray-900 font-semibold px-3 py-1 z-10',
				value: (!this.pagination ? 'Vezi raspunsuri (' : 'Mai multe (')+ this.count +')'
			}
		},
		loadPage_args(){
			return {
				pagination: this.pagination_id,
				page: this.pagination ? this.pagination.nextPage : 1
			}
		}
	},
}
</script>