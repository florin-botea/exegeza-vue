<template>
	<div>
		<notifications group="notifications" style="top:50px;right:20px;">
		   <template slot="body" slot-scope="props">
			<div class="border border-black mb-2 p-2" :class="props.item.type" @click="props.close">
				<div class="font-bold border-b border-black">
				  {{props.item.title}}
				</div>
				<div class="text-sm text-justify">
					{{props.item.text}}
				</div>
			</div>
		  </template>
		</notifications>
	</div>
</template>

<script>
//import BibleDataUnifier from '@/utils/BibleDataUnifier.js'
import Comment from '@/models/Comment.js'
import Reply from '@/models/Reply.js'
import User from '@/models/User.js'
import {mapGetters} from 'vuex'

export default {
	props: {
		auth: {
			required: true
		},
		comments: Object,
		replies: Object,
		bibleData: Object,
		route: Object
	},
	computed: {
		noScrollOnMobile(){
			return this.$store.state.ui.notificationsShown || this.$store.state.ui.userMenuShown || this.$store.state.ui.fullscreenForm;
		},
		commentSection(){
			return this.$store.state.ui.commentsSectionShown
		},
		global_id(){
			return this.$store.state.bible.selectedGlobalId
		}
	},
	mounted() {
		if (this.auth) {
			console.log(this.auth)
			this.$store.commit('setAuth', this.auth.user)
			User.insert({data:this.auth.user})
		}
		if (this.route){
			this.$store.commit('setRoute', this.route)
		}
		if (this.bibleData && this.route) {
			this.$store.commit('bible/setData', {data: this.bibleData, route: this.route})
		}
		if (this.comments) {
			this.$store.commit('entities/comments/insertOrUpdatePagination', {
				data: this.comments,
				id: this.global_id,
			})
			Comment.insert({
				data: this.comments.data
			})
		}
		if (this.replies) {
			this.$store.commit('entities/replies/insertOrUpdatePagination', {
				data: this.replies,
				id: this.route.queryStrings.comment,
			})
			Reply.insert({
				data: this.replies.data
			})
		}
	},
	watch: {
		noScrollOnMobile(yes){
			let body = document.getElementsByTagName("BODY")[0];
			yes ? body.classList.add("noScrollOnMobile") : body.classList.remove("noScrollOnMobile");
		},
		commentSection(shown){
			if (shown) this.$store.commit('setUIState', {prop:'navbarShown', value:true})
		},
		global_id(newVal){
			this.$store.commit('entities/comments/setFilter', {target:newVal})
		}
	},
}
</script>