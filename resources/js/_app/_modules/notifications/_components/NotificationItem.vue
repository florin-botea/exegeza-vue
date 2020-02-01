<template>
	<div class="p-1 flex justify-between" :class="{'bg-gray-400':!notification.read_at}">
		<p class="mb-0 mr-1 flex-none">
			<img :src="user_photo" style="height:auto; width:35px;">
		</p>
		<a class="flex-initial" :href="notification_url">
			<p class="mb-0 mr-2 text-justify text-sm">
				{{ notification_text }}
			</p>
		</a>
		
		<div class="flex flex-col mr-2 text-sm">
			<i class="fas fa-trash-alt hover:text-red-500" @click="deleteNotification(notification)"></i>
			<br>
			<i v-show="ui" class="fas fa-check text-sm" :class="checkmarkStyle"
			@click="toggleReadState(notification); saveReadState(notification)"></i>
		</div>
	</div>
</template> 

<script>
import debounce from 'lodash/debounce';
import Notification from '@/models/Notification';
import {mapMutations, mapActions} from 'vuex';

export default {
	props: {
		notification: {type:Object}
	},
	data: () => ({
		ui: {
			checkBtn: true
		}
	}),
	computed: {
		notification_text(){
			return this.notification.text.replace('$[subject]', (this.notification.author || {name:'System'}).name)
		},
		notification_url(){
			return this.notification.author ? '/notifications/' + this.notification.id : null
		},
		user_photo(){
			let root = '/images/profile-photos/'
			let photo = this.notification.author ? (this.notification.author.profile_photo || 'default.png') : '0.png'
			return root + photo
		},
		checkmarkStyle(){
			return {
				'md:hover:text-blue-500': !this.notification.read_at,
				'md:hover:text-black': this.notification.read_at,
				'text-blue-500': this.notification.read_at
			}
		}
	},
	methods: {
		...mapActions('entities/notifications', ['deleteNotification', 'toggleReadState', 'saveReadState']),
	}
}
</script>

<style>
@media (min-width: 768px) {
	.md\:hover\:text-blue-500:hover {
		@apply text-blue-500;
	}
	.md\:hover\:text-black:hover {
		@apply text-black;
	}
}

</style>