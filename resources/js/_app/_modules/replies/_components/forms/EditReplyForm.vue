<script>
import Reply from '@/models/Reply'
import Comment from '@/models/Comment'
import MainForm from './MainForm.vue'
import SubmitBtn from '@/$components/buttons/SubmitBtn'
import clone from 'lodash/clone'
/*
	va trebui copilul sa implementeze 
	methods(){
		submit(){}
		signifiantData()
	},
	computed: {
		author_id()
	},
	components: {SubmitBtn}
*/
export default {
	extends: MainForm,
	components: {SubmitBtn},
	props:{
		subject: {type:Object, required:true}
	},
	computed: {
		author_id(){
			return this.$store.state.auth.id
		},
		replyModel(){
			return this.subject.re_reply ? Reply.find(this.reply.re_reply) : Comment.find(this.subject.comment_id)
		}
	},
	methods: {
		async submit(){
			let res = await Reply.$update({params: {id:this.reply.id}, data: this.reply})
			if (res){
				this.$emit('close-me-pls')
			}
			return res
		},
	},
	mounted(){
		this.reply = clone(this.subject)
	}
}
</script>