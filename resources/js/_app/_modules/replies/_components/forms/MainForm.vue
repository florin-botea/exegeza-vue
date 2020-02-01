<template>	
	<PostsForm :submitBtn="submitBtn" @togglePrevMode="preview=$event" @toggleFullScreenMode="fullScreenForm=$event">
		<template #body>
			<div class="relative h-full">
				<div class="absolute flex flex-col h-full w-full">
					<div v-if="replyModel" class="flex-1 w-full overflow-y-auto" v-show="fullScreenForm && !preview" style="min-height:30%;">
						{{replyModelAuthor}}:
						<PostText :text="replyModel.text"/>
					</div>
					<ValidationProvider ref="text" name="Text" rules="required|min:50|max:5000" v-slot="{ errors }" mode="passive" slim>
						<FormGroup class="flex-1 relative" :iErrors="errors" :value="reply.text" :minLength="50" :maxLength="5000">
							<ItemedTextarea class="h-full">
								<textarea ref="textarea" v-model="reply.text" class="form-control h-full absolute resize-none"></textarea>
							</ItemedTextarea>
						</FormGroup>
					</ValidationProvider>
				</div>
			</div>
		</template>
		<template #preview>
			<br>
			<AuthorCard :author_id="author_id"/>
			<PostText :text="reply.text"/>			
		</template>
	</PostsForm>
</template>

<script>
import PostsForm from '@/$components/wrappers/PostsForm.vue'
import ItemedTextarea from '@/$components/inputs/ItemedTextarea_v2'
import FormGroup from '@/$components/inputs/FormGroup_v1.vue'
import AuthorCard from '@/$components/AuthorCard.vue'
import PostText from '@/$components/PostText.vue'
import User from '@/models/User'

export default {
	components: {
		ItemedTextarea,
		PostsForm,
		FormGroup,
		AuthorCard,
		PostText,
	},
	data: () => ({
		fullScreenForm: false,
		preview: false,
		reply: {
			re_reply_id:null,
			comment_id: null,
			text: '',
		},
		submitBtn: {
			value: 'Submit',
			class: ''
		},
	}),
	computed: {
		mainFocus(){
			return this.$refs.textarea
		},	
		replyModel(){
			//@
		},
		replyModelAuthor(){
			console.log(this.replyModel)
			return User.find(this.replyModel.user_id).name
		}
	},
	methods: {
		async validate(){
			let text = await this.$refs.text.validate()
			if (!text.valid){
				this.$refs.textarea.focus()
				return false
			}
			return true
		},
		async submit(){
			//override me in actual form
		},
		//async cancelHook(){
			//override me in actual form
		//},
	},
	mounted(){
		this.$refs.textarea.focus()
	}
}
</script>

<style scoped>
.fullScreenForm {
	z-index: 120;
	position: fixed;
	bottom: 0px;
	right: 0px;
	width:100%;
	height:100%;
}
	
@media (min-width: 768px) {
	.fullScreenForm {
		height: calc(100% - 3rem);
		width: 50%;
	}
}
</style>