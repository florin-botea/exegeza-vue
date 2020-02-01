export default {
	el: null,
	comment(id){
		this.el = document.getElementById('comment_'+id)
		return this
	},
	reply(id){
		this.el = document.getElementById('reply_'+id)
		if (!this.el) console.log('no element with id reply_'+id)
		return this
	},
	verse(id){
		this.el = document.getElementById('verse_'+id)
		if (!this.el) console.log('no element with id verse_'+id)
		return this
	},
	tag(id){
		this.el = document.getElementById('tag_'+id)
		return this
	},
	get(id){
		this.el = document.getElementById(id)
		return this
	},
	// biblesSection(){
		// this.el = document.getElementById('bibles_content')
		// return this
	// },
	// theCommentsSection(){
		// this.el = document.getElementById('theCommentsSection')
		// return this
	// },
	bringIntoFocus(){
		if (!this.el){
			return
		}
		this.el.scrollIntoView({block:'center'})
		this.el.classList.add('focused')
		return this
	},
	smoothScrollTop(){
		if (!this.el) return
		this.el.scrollIntoView({behavior:'smooth',block:'start'})
		return this
	},
	scrollTop(){
		if (!this.el) return
		this.el.scrollIntoView({block:'start'})
		return this
	},
	smoothScrollCenter(){
		if (!this.el) return
		this.el.scrollIntoView({block:'center'})
		return this
	},
	shake(ms){
		if (!this.el) return
		this.el.classList.add('shake')
		setTimeout( () => {
			this.el.classList.remove('shake')
		}, ms )
	},
	// slideIntoView(){
		// if (!this.el) return
		// this.el.classList.add('theCommentsSection--fadeIn')
		// this.el.classList.remove('theCommentsSection--fadeOut')
	// },
	// slideOutOfView(){
		// if (!this.el) return
		// this.el.classList.add('theCommentsSection--fadeOut')
		// this.el.classList.remove('theCommentsSection--fadeIn')
	// },
	// yCollapseOnMobile(yes = true){
		//mai lucrez la felul cum functioneaza
		// if (!this.el) return
		// if (yes){
			// this.el.classList.add('yCollapseOnMobile')
		// } else {
			// this.el.classList.remove('yCollapseOnMobile')
		// }
	// },
	// hide(bool = true){
		// if (!this.el) return
		// if (bool){
			// this.el.classList.add('d-none')
		// } else {
			// this.el.classList.remove('d-none')
		// }
	// },
	// display(el_id, bool){
		// let d = document.getElementById('display_controller')
		// bool ? d.classList.add(el_id) : d.classList.remove(el_id)
	// }
}