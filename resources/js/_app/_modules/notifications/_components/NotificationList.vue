<template>
	<DropMenuWrapper ref="toggled" class="flex flex-col flex-none justify-center rounded ml-1 px-2 hover:bg-black cursor-pointer"
	:class="{'bg-black':isShown}" v-slot="{hide,isShown}" @toggle="setUIState({prop:'notificationsShown',value:$event})" @show="_loadNotifications">
		<div class="relative">
			<i class="far fa-bell" style="font-size:22px"></i>
			<span v-show="unread_notifications" class="inline-block absolute leading-none bg-red-600 text-white text-sm font-normal" style="bottom:0px;right:-5px;border-radius:50%;padding:0px 2px;">
				{{ unread_notifications }}
			</span>
		</div>
		
		<div v-show="isShown" class="self-end h-0 w-0 ml-auto overflow-visible">
			<div v-click-outside.bubble="hide" class="notificationsLayer overflow-y-auto absolute md:relative w-full h-screen left-0 md:float-right p-1 pb-16 md:pb-1 text-center text-base" style="margin-right:-0.5rem;margin-top:0.5rem;">
				<div class="flex justify-between">
					<span>Notificari</span>
					<span @click="markAllAsRead" class="hover:text-blue-500 cursor-pointer">
						Marcheaza toate ca citite
					</span>
				</div>
				<hr>
				<div class="">
					
					<NotificationItem v-for="notification in notifications" :notification="notification"
						:key="notification.id"
					/>
					
					<div class="h-4 mx-auto w-3" v-show="loading">
							<fade-loader :loading="true" :color="'grey'" :height="'7px'" :width="'2px'" :radius="'7px'"/>
					</div>
				</div>
			</div>
		</div>
	</DropMenuWrapper>
</template>

<script>
import NotificationItem from './NotificationItem.vue'
import {mapMutations, mapState, mapActions, mapGetters} from 'vuex'
import Notification from '@/models/Notification'
import DropMenuWrapper from '@/$components/wrappers/DropMenuWrapper_v1'

export default {
	data: () => ({
		loading: false
	}),
	methods: {
		async _loadNotifications(){
			this.loading = true
			await this.loadNotifications()
			this.loading = false
		},
		...mapMutations(['setUIState']), //noScrollOnMobile
		...mapActions('entities/notifications', ['loadNotifications', 'markAllAsRead', 'checkForNotifications']),
	},
	computed: {
		notifications: () => Notification.all(),
		isShown(){
			return (this.$refs.toggled || {isShown:false}).isShown
		},
		...mapGetters('entities/notifications', ['unread_notifications'])
	},
	mounted(){
		this.checkForNotifications()
		setInterval( () => {
			this.checkForNotifications()
		}, 40000 )
	},
	components: { NotificationItem, DropMenuWrapper },
}
</script>
<style>
@media (min-width: 768px) {
	.notificationsLayer {
		width: 400px;
		height:auto;
		max-height: 500px;
	}
}
</style>