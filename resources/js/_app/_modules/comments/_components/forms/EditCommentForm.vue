<script>
	import MainForm from './MainForm.vue'
	import Comment from '@/models/Comment.js'
	import clone from 'lodash/clone'
	
	export default {
		extends: MainForm,
		props: {
			pagination_id: {type:Number},
			predefined: {required:true}
		},
		data: () => ({
			submitBtn: {
				value: 'Actualizeaza'
			}
		}),
		computed: {
			author_id(){
				return this.$store.state.auth.id
			},
		},
		methods: {
			async submit(){
				let res = await this.$store.dispatch('entities/comments/updateComment', this.comment)
				if (res){
					this.$emit('close-me-pls')
				}
				return res
			},
		},
		mounted(){
			this.comment = clone(this.predefined)
		}
	}
</script>