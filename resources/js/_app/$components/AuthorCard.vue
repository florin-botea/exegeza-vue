<template>
	<div class="flex flex-1 items-center">
		<a :href="'/users/'+author_id">
			<div class="w-8 h-8 cursor-pointer bg-no-repeat" style="width:2rem;background-size:auto 100%;background-position:center" :style="{'background-image':'url('+ auth_photo +')'}"></div>
		</a>
		<div class="leading-none p-1">
			<a class="mb-auto hover:text-blue-500 cursor-pointer" :href="'/users/'+author_id">
				{{author_name}}
			</a>
			<br>
			<div class="relative hover:nested-hidden-show" v-if="post_id">
				<div class="w-0 h-0 overflow-visible relative">
					<div :class="popupClass" class="absolute w-40 px-2 py-2 text-center border border-black rounded bg-white bottom-0">
						Copiat in clipboard
					</div>
				</div>
				<small @click="copyToClipboard" class="cursor-pointer text-xs">Post ID: {{ post_id }}</small>
				<input type="text" ref="input_url" class="absolute top-0 left-0 pl-2 pr-8" :value="postUrl" style="z-index:-999">
			</div>
		</div>
	</div>
</template>

<script>
import User from '@/models/User'
import {mapState} from 'vuex'

export default {
	props: {
		author_id: Number,
		post_id: Number,
		created_at: String,
		postUrl: String
	},
	data: ()=> ({
		popup: false
	}),
	computed: {
		author(){ //LUCRU
			return User.find(this.author_id) || this.$store.state.auth
		},
		author_name(){
			return (this.author || {name:'Anonim'}).name
		},
		auth_photo(){
			console.log(this.author)
			let root = '/images/profile-photos/'
			let photo = this.author ? (this.author.profile_image || 'default.png') : '0.png'
			return root + photo
		},
		popupClass(){
			return {
				popup: this.popup,
				hidden: !this.popup
			}
		}
	},
	methods: {
		copyToClipboard(){
			let copyText = this.$refs.input_url
			copyText.select()
			copyText.setSelectionRange(0, 99999)
			document.execCommand("copy")
			this.popup = true
			setTimeout(() => {
				this.popup = false
			}, 5000)
		}
	}
}
</script>

<style>
@keyframes fadeOut {
   0% {opacity: 1;}
   40% {opacity: 0.8;}
   60% {opacity: 0.7;}
   100% {opacity: 0;}
}

.popup {
	-webkit-animation-duration: 5s;
	animation-duration: 5s;
	-webkit-animation-name: fadeOut;
	animation-name: fadeOut;
}
</style>