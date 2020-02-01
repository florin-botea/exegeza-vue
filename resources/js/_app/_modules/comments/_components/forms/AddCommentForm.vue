<script>
import debounce from 'lodash/debounce'
import MainForm from './MainForm.vue'
import Comment from '@/models/Comment.js'
import localStore from 'local-storage'

export default {
	extends: MainForm,
	props: {
		pagination_id: {type:Number},
	},
	data: () => ({
		submitBtn: {
			value: 'Adauga'
		}
	}),
	computed: {
		author_id(){
			return this.$store.state.auth.id
		},
		form_id(){
			return this.author_id+'_add_comm_'+this.pagination_id
		}
	},
	methods: {
		async submit(){
			let res = await Comment.$create({data: this.comment})
			if (res){
				localStore.remove(this.form_id)
				this.$emit('close-me-pls')
			}
			return res
		},
		cancelHook(){
			if (this.comment.text.length > 30){
				return this.$dialog.confirm('Datele introduse se vor pierde. Sunteti sigur?', {
					okText: 'Da', cancelText: 'Nu'
				}).then( dialog => {
					localStore.remove(this.form_id)
					return true
				}).catch( e => {
					return false
				})
			}
			return true
		}
	},
	mounted(){
		this.comment.target = this.pagination_id
		let draft = localStore.get(this.form_id)
		if (draft) {
			this.comment = draft
		}
	},
	watch: {
		'comment.text': {
			handler: debounce(function(){
				let is_posting = this.comment.text.length > 30
				if (is_posting && !this._isBeingDestroyed){
					localStore.set(this.form_id, this.comment)
				}
				if (!is_posting){
					localStore.remove(this.form_id)
				}
			}, 2000)
		}
	}
}
</script>