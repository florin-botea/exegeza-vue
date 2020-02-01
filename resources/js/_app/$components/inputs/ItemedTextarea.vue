<template>
	<div class="flex flex-col h-full">
		<div class="textareaItems flex px-1 pb-1">
			<span class="mx-1 text-lg" @click="showMentionForm('user')">
				<i class="fas fa-user-tag"></i>
			</span>
			<span class="mx-1 text-lg" @click="showMentionForm('comment')">
				<i class="far fa-address-card"></i>
			</span>
			<span class="mx-1 text-lg" @click="showMentionForm('url')">
				<i class="fas fa-globe"></i>
			</span>
			<span class="mx-1 text-lg" @click="setTextSelection()">
				<i class="far fa-sticky-note"></i>
			</span>
		</div>
		<div class="absolute z-30">		
			<UserMention v-if="mention_form === 'user'" @submit="insert" @abort="mention_form=''"/>
			<!-- <VerseMention v-if="mention_form === 'verse'" @submit="insert" @abort="mention_form=''"/> -->
			<CommentMention v-if="mention_form === 'comment'" @submit="insert" @abort="mention_form=''"/>
			<!-- <ReplyMention v-if="mention_form === 'reply'" @submit="insert" @abort="mention_form=''"/> -->
			<UrlMention v-if="mention_form === 'url'" @submit="insert" @abort="mention_form=''"/>
			<NoteMention :text="textSelection" v-if="mention_form === 'note'" @submit="insert" @abort="mention_form=''"/>
		</div>
		
		<div class="flex-1 relative top-0 bottom-0 mb-4">
			<textarea class="shadow appearance-none border rounded w-full h-full py-1 md:py-2 px-1 leading-tight focus:outline-none focus:shadow-outline"
			:ref="'textarea'" placeholder="Comment body here" rows="5"
			:value="value" v-bind="$attrs" v-debounce:300="onInput" style="resize:none"
			:disabled="(mention_form.length > 1)"></textarea>
			
			<div v-if="iErrors.length" class="absolute top-0 right-0 error-popper cursor-pointer" :style="{'z-index':(1000 - _uid)}">
				<div class=" px-1 text-red-600">
					<i class="fas fa-exclamation-circle"></i>
				</div>
				<p class="invalid-message : w-64 font-semibold text-red-600 leading-none text-sm absolute bg-white shadow p-1 right-0">
					{{iErrors}}
				</p>
			</div>
		
			<div class="relative float-left bg-white text-sm" style="margin-top:-23px; z-index:100;">
				<span :style="value.length < this.min ? {color:'red'} : {}"> {{ utf8Size }} </span>
				<span :style="value.length > this.max ? {color:'red'} : {}"> /{{ this.max }} </span>
			</div>
		</div>
	</div>
</template>
<script>
	import parser from './_text-parser'
	import Cutter from 'utf8-binary-cutter'
	import UserMention from './mentions/UserMention'
	//import VerseMention from './mentions/VerseMention'
	import CommentMention from './mentions/CommentMention'
	//import ReplyMention from './mentions/ReplyMention'
	import UrlMention from './mentions/UrlMention'
	import NoteMention from './mentions/NoteMention'

	//va trebui sa import doar insertorul,fara parser. nu are sens
	export default {
		inheritAttrs: false,
		data: () => ({
			utf8Size: 0,
			mention_form: '',
			textSelection: '',
			innerValue: ''
		}),
		props: {
			value: '',
			min: {type:Number, default:0},
			max: {type:Number, default:50000},
			iErrors: {
				type:Array,
				default: () => ['dsadasdasadsdasdasadsdads']
			},
		},
		methods: {
			onInput(val){
				this.utf8Size = Cutter.getBinarySize(val)
				this.$emit('input', val)
			},
			insert(insertion){
				var start = this.$refs.textarea.selectionStart
				var end = this.$refs.textarea.selectionEnd
				this.$refs.textarea.focus()
				this.$refs.textarea.value = [
					this.$refs.textarea.value.slice(0, start), 
					insertion,
					this.$refs.textarea.value.slice(end, this.$refs.textarea.value.length)
				].join('');
				this.$emit('input', this.$refs.textarea.value)
				this.mention_form = ''
			},
			setTextSelection(){
				var start = this.$refs.textarea.selectionStart
				var end = this.$refs.textarea.selectionEnd
				this.textSelection = this.$refs.textarea.value.slice(start, end)
				this.textPosition = start
				if (this.textSelection){
					this.showMentionForm('note')
				} else {
					alert('selecteaza un text intai')
				}
			},
			showMentionForm(type){
				this.mention_form = type
			},
		},
		watch: {
			mention_form(val){
				this.$emit('blured', Boolean(val))
			}
		},
		components: {UserMention,CommentMention,UrlMention,NoteMention}
	}
</script>