export default {
	data: () => ({
		fullScreenForm: false,
		preview:false,
		actionsDisabled:false,
		pending: false,
		lastVerseSelectionTime: 0
	}),
	computed: {
		previewMode(){
			return (this.preview && this.fullScreenForm) || !this.fullScreenForm
		},
		selectedVerse(){
			return this.$store.state.entities.comment_paginations.active
		}
	},
	methods: {
		closeForm(){
			this.$store.commit('saveForm', {form_id:this._uid, bool:false})
			this.$emit('close', this._uid)
		},
		closeOnConfirm(){
			if (this.$store.state.forms[this._uid]){
				this.$dialog.confirm('Datele introduse se vor pierde. Sunteti sigur?', {
					okText: 'Da',
					cancelText: 'Nu'
				})
					.then((dialog) => {
						this.closeForm()
					}).catch()
				return
			}
			this.closeForm()
		},
		preventScrollOnFullscreen(dirrection, e){
			if (this.fullScreenForm){
				e.stopPropagation()
				e.preventDefault()
			}
		},
		lockForm(bool){
			//daca selecteaza un vers imediat dupa ce a dat copy paste de text in post.text, form se va bloca, versul se schimba si nu va mai putea apoi sa il inchida si ramane blocat pe versul respectiv.
			//mai jos impiedic asta
			let preventLock = new Date().getTime() - this.lastVerseSelectionTime < 1000
			if (preventLock){
				return
			}
			this.$store.commit('saveForm', {form_id:this._uid, bool:bool})
		}
	},
	beforeDestroy(){
		this.$store.commit('setUIState', {prop:'fullscreenElement', value:false})
	},
	watch: {
		fullScreenForm(bool){
			this.$store.commit('setUIState', {prop:'fullscreenElement', value:bool})
		},
		selectedVerse(){
			this.lastVerseSelectionTime = new Date().getTime()
		}
	}
}