<template>
	<form class="flex flex-col shadow-md p-2 bg-white" @submit.prevent :id="_uid" :class="{fullScreenForm}">
		
		<div class="z-50" v-show="!previewMode">
			<slot name="header"></slot>
		</div>
		
		<div class="h-64 z-40" :class="{'flex-1':fullScreenForm}" v-show="!previewMode">
			<slot name="body"></slot>
		</div>
		
		<div class="w-full relative z-30" :class="{'flex-1':fullScreenForm}" v-if="previewMode || !fullScreenForm">
			<div class="h-full w-full overflow-y-auto" :class="{absolute:fullScreenForm}">
				<slot name="preview"></slot>
			</div>
		</div>
		
		<div class="flex p-1">
			<div class="px-2" v-show="!fullScreenForm" @click="fullScreenForm=true">
				<i class="fas fa-compress"></i>
			</div>
			<div class="px-2" v-show="fullScreenForm" @click="fullScreenForm=false;preview=false">
				<i class="fas fa-compress-arrows-alt"></i>
			</div>
			<div class="px-2" v-show="fullScreenForm && !preview" @click="preview=true">
				<i class="far fa-file-video"></i>
			</div>
			<div class="px-2" v-show="fullScreenForm && preview" @click="preview=false">
				<i class="far fa-edit"></i>
			</div>
			<div class="flex ml-auto">
				<button class="bg-yellow-100 hover:bg-yellow-300 px-3 font-semibold rounded shadow-md border border-gray-500 cursor-pointer"
				:disabled="actionsDisabled || pending" @click="cancel">
					Anuleaza
				</button>
				<SubmitBtn :pending="pending"
				:btnClass="'bg-gray-900 hover:bg-gray-600 px-3 font-semibold rounded shadow-md text-yellow-300 cursor-pointer'"
				:disabled="actionsDisabled" @click="submit">
					{{submitBtn.value}}
				</SubmitBtn>
			</div>
		</div>
	</form>
</template>

<script>
import debounce from 'lodash/debounce'

import postFormMixin from '@/myPlugins/mixins/post-form'
import SubmitBtn from '@/$components/buttons/SubmitBtn'

export default {
	components: {SubmitBtn},
	//mixins: [postFormMixin],
	props: {
		submitBtn: {
			type: Object,
			default: () => ({
				value: 'submit',
				class: ''
			})
		},
		//pending: {type:Boolean, default:false}
	},
	data: () => ({
		fullScreenForm: false,
		preview:false,
		actionsDisabled:false,
		pending: false,
		//lastVerseSelectionTime: 0,
		//formLocks: 0
//		lockedInput: false,
	}),
	computed: {
		previewMode(){
			return (this.preview && this.fullScreenForm)
		},
	},
	methods: {
		async submit(){
			let goodToGo = true
			if (this.$parent.validate){
				goodToGo = await this.$parent.validate()
			}
			if (goodToGo){
				this.pending = true
				let res = await this.$parent.submit()
				this.pending = false
			}
		},
		async cancel(){
			let goodToGo = true
			if (this.$parent.cancelHook){
				goodToGo = await this.$parent.cancelHook()
			}
			if (goodToGo){
				this.$parent.$emit('close-me-pls')
			}
		},
		restoreFocus(){
			if (!this.$parent.mainFocus){
				return
			}
			this.$nextTick(function(){
				this.$parent.mainFocus.focus()
			})
		}
	},
	watch: {
		fullScreenForm(fullScreenForm){
			if (! fullScreenForm){
				this.$nextTick(function(){
					DOMel.get(this._uid).scrollTop()
				})
			}
			this.$store.commit('setUIState', {prop:'fullscreenForm', value:fullScreenForm})
			this.restoreFocus()
			this.$emit('toggleFullScreenMode', fullScreenForm)
		},
		previewMode(is){
			this.restoreFocus()
			this.$emit('togglePrevMode', is)
		}
	},
	mounted(){
		this.$store.commit('setUIState', {prop:'navbarShown', value:false})
		DOMel.get(this._uid).smoothScrollCenter()
	},
	beforeDestroy(){
		this.$store.commit('setUIState', {prop:'fullscreenForm', value:false})
	},
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