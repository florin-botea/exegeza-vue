<template>
	<div class="flex flex-col h-full w-full">
		<div class="textareaItems flex px-1 pb-1">
			<span class="mx-1 text-lg cursor-pointer" @click="mention_form='user'">
				<i class="fas fa-user-tag"></i>
			</span>
			<!-- <span class="mx-1 text-lg" @click="mention_form='comment'"> -->
				<!-- <i class="far fa-address-card"></i> -->
			<!-- </span> -->
			<span class="mx-1 text-lg cursor-pointer" @click="getTextSelection();mention_form='url'">
				<i class="fas fa-globe"></i>
			</span>
			<span class="mx-1 text-lg cursor-pointer" @click="getTextSelection();mention_form='note'">
				<i class="far fa-sticky-note"></i>
			</span>
			<span class="mx-1 text-lg cursor-pointer" @click="insertDecorator('<b', 'b>')">
				<i class="fas fa-bold"></i>
			</span>
			<span class="mx-1 text-lg cursor-pointer" @click="insertDecorator('<i', 'i>')">
				<i class="fas fa-italic"></i>
			</span>
			<span class="mx-1 text-lg cursor-pointer" @click="insertDecorator('<u', 'u>')">
				<i class="fas fa-underline"></i>
			</span>
			<span class="mx-1 text-lg cursor-pointer" @click="insertDecorator('<d', 'd>')">
				<i class="fas fa-ban"></i>
			</span>
		</div>
		<div class="absolute z-30">		
			<UserMention v-if="mention_form === 'user'" @submit="insertUserMention" @abort="onItemAbort"/>
			<!-- <VerseMention v-if="mention_form === 'verse'" @submit="insert" @abort="mention_form=''"/> -->
			<!-- <CommentMention v-if="mention_form === 'comment'" @submit="insert" @abort="mention_form=''"/> -->
			<!-- <ReplyMention v-if="mention_form === 'reply'" @submit="insert" @abort="mention_form=''"/> -->
			<UrlMention v-if="mention_form === 'url'" @submit="insertUrlMention" @abort="onItemAbort"/>
			<NoteMention :text="textSelection" v-if="mention_form === 'note'" @submit="insertNote" @abort="onItemAbort"/>
		</div>
		
		<div class="flex-1 relative top-0 bottom-0">
			<slot></slot>
		</div>
	</div>
</template>
<script>
import UserMention from './mentions/UserMention'
//import VerseMention from './mentions/VerseMention'
//import CommentMention from './mentions/CommentMention'
//import ReplyMention from './mentions/ReplyMention'
import UrlMention from './mentions/UrlMention'
import NoteMention from './mentions/NoteMention'
import {postTextRegex,postFootersRegex,postDecoratorsRegex} from './_text-parser.js'

export default {
	inheritAttrs: false,
	data: () => ({
		mention_form: '',
		textSelection: '',
	}),
	props: {
		iErrors: {
			type:Array,
			default: () => []
		},
	},
	methods: {
		insertUserMention(user){
			let c = this.insert(`[${user.name}][0]`, `[0]: user(${user.id})`)
			this.setSelection(c.selectionStart+c.footerLength)
		},
		insertUrlMention(url){//string $url
			let description = this.textSelection || 'descrierea aici'
			let c = this.insert('['+description+'][0]', `[0]: url(${url})`)
			this.setSelection(c.selectionStart+2, c.selectionStart+description.length+2)
		},
		insertNote(note){//string $note
			let description = this.textSelection || 'descrierea aici'
			let c = this.insert('['+description+'][0]', `[0]: note(${note})`)
			this.setSelection(c.selectionStart+2, c.selectionStart+description.length+2)
		},
		fixTextFooters(){
			let elm = this.$slots.default[0].elm,
			footers =  Array.from( elm.value.matchAll(postFootersRegex) ),
			// 1 = index, 2 = type, 3 = ressource
			footerMap = {};
			footers.forEach( (item) => {
				footerMap[item[1]] = item
			})
			var i = 0
			footers = []
			let textWithAscItems = elm.value.replace(postDecoratorsRegex, function (match, description, footer) {
				i++
				if (footerMap[footer]){
					footers.push('['+ i +']: '+ footerMap[footer][2] +'('+ footerMap[footer][3] +')')
				} else {
					footers.push('['+ i +']: ')
				}
				return '['+ description +']['+ i +']'
			})
			let textWithoutFooters = textWithAscItems.match(postTextRegex)
			elm.value = textWithoutFooters[0].trim() + '\n\n---footer---\n' + footers.join('\n')
		},
		insert(insertion, footer){
			this.textSelection = ''
			let elm = this.$slots.default[0].elm,
			start = elm.selectionStart,
			end = elm.selectionEnd,
			footersBefore = Array.from( elm.value.slice(0, start).matchAll(postDecoratorsRegex) ),
			thisFooterLength = insertion.length + (String(footersBefore.length).length);
			//caretPos = start + thisFooterLength
			elm.value = [
				elm.value.slice(0, start), 
				insertion,
				elm.value.slice(end, elm.value.length)
			].join(' ');
			elm.value += '\n---footer---\n'+footer
			this.fixTextFooters()
			this.mention_form = ''
			elm.dispatchEvent(new Event('input'))
			return {selectionStart:start, footerLength:thisFooterLength}
		},
		insertDecorator(open, close){
			this.textSelection = ''
			let elm = this.$slots.default[0].elm,
			selection = this.getTextSelection();
			
			elm.value = [
				elm.value.slice(0, selection.start), 
				open+' '+selection.text+' '+close,
				elm.value.slice(selection.end, elm.value.length)
			].join(' ');
			this.setSelection(selection.start+4,selection.start+selection.text.length+4)
			elm.dispatchEvent(new Event('input'))
		},
		setSelection(start, end = null){
			let elm = this.$slots.default[0].elm;
			end = end || start;
			this.$slots.default[0].elm.removeAttribute('disabled');
			this.$nextTick(function(){
				elm.focus()
				elm.selectionStart = start
				elm.selectionEnd = end
			})
		},
		getTextSelection(){
			let elm = this.$slots.default[0].elm
			let start = elm.selectionStart
			let end = elm.selectionEnd
			this.textSelection = elm.value.slice(start, end)
			return {
				start: start,
				end: end,
				text: elm.value.slice(start, end)
			}
		},
		onItemAbort(){
			this.mention_form='';
			let elm = this.$slots.default[0].elm;
			this.$nextTick().then(function(){
				elm.focus();
			});
		}
	},
	watch: {
		mention_form(val){
			this.$nextTick(function(){
				if (val.length){
					this.$slots.default[0].elm.setAttribute('disabled', true)
				} else {
					this.$slots.default[0].elm.removeAttribute('disabled')
				}
			})
		},
	},
	components: {UserMention,UrlMention,NoteMention}
}
</script>