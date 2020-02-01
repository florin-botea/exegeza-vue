<template>
	<PostsForm :submitBtn="submitBtn">
		<template #header>
			<ValidationProvider ref="title" name="Title" rules="required|min:10|max:120" v-slot="{errors}" mode="lazy" slim>
				<FormGroup :iErrors="errors">
					<input type="text" ref="title_input" class="form-control px-1 py-2" placeholder="Title here" v-model="comment.title">
				</FormGroup>
			</ValidationProvider>
		</template>
		<template #body>
			<ValidationProvider ref="text" name="Text" rules="required|min:50|max:5000" v-slot="{ errors }" mode="passive" slim>
				<FormGroup class="h-full" :iErrors="errors" :value="comment.text" :minLength="50" :maxLength="5000">
					<ItemedTextarea class="h-full">
						<textarea ref="textarea" v-model="comment.text" class="form-control h-full resize-none absolute"></textarea>
					</ItemedTextarea>
				</FormGroup>
			</ValidationProvider>
		</template>
		<template #preview>
			<br>
			<AuthorCard :author_id="author_id"/>
			<PostTitle :text="comment.title"/>
			<PostText :text="comment.text"/>			
		</template>
	</PostsForm>
</template>

<script>
import PostsForm from '@/$components/wrappers/PostsForm.vue'
import ItemedTextarea from '@/$components/inputs/ItemedTextarea_v2'
import FormGroup from '@/$components/inputs/FormGroup_v1.vue'
import AuthorCard from '@/$components/AuthorCard.vue'
import PostTitle from '@/$components/PostTitle.vue'
import PostText from '@/$components/PostText.vue'

export default {
	components: {
		ItemedTextarea,
		PostsForm,
		FormGroup,
		AuthorCard,
		PostTitle,
		PostText,
	},
	data: () => ({
		comment: {
			target: null,
			title: '',
			text: '',
		},
		//will be passed as props in generic form
		submitBtn: {
			value: 'Submit',
			class: ''
		},
	}),
	computed: {
		mainFocus(){
			return this.$refs.textarea
		}
	},
	methods: {
		async validate(){
			let title = await this.$refs.title.validate()
			let text = await this.$refs.text.validate()
			if (!title.valid){
				this.$refs.title_input.focus()
				return false
			}
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
		this.$refs.title_input.focus()
	}
}
</script>