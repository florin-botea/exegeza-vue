
<script>
import Comment from '@/models/Comment'
import Reply from '@/models/Reply'
import MainForm from './MainForm.vue'
import debounce from 'lodash/debounce'
import localStore from 'local-storage'

export default {
	extends: MainForm,
	props: {
		pagination_id: {type:Number},
		re_reply: {type:Number, default:null}
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
		replyModel(){
			return this.re_reply ? Reply.find(this.re_reply) : Comment.find(this.pagination_id)
		},
		form_id(){
			return this.author_id+'_add_reply_'+this.pagination_id+(this.re_reply ? '_'+this.re_reply : '')
		}
	},
	methods: {
		async submit(){
			let res = await Reply.$create({data: this.reply})
			if (res){
				localStore.remove(this.form_id)
				this.$emit('close-me-pls')
			}
			return res
		},
		cancelHook(){
			if (this.reply.text.length > 30){
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
		this.reply.comment_id = this.pagination_id
		this.reply.re_reply = this.re_reply
		let draft = localStore.get(this.form_id)
		if (draft) {
			this.reply = draft
		}
	},
	watch: {
		'reply.text': {
			handler: debounce(function(){
				let is_posting = this.reply.text.length > 30
				if (is_posting && !this._isBeingDestroyed){
					localStore.set(this.form_id, this.reply)
				}
				if (!is_posting){
					localStore.remove(this.form_id)
				}
			}, 2000)
		}
	}
}
</script>