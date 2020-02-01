<template>
	<DropMenuWrapper ref="toggled" class="flex-shrink overflow-hidden md:overflow-visible flex justify-center rounded px-2 hover:bg-black cursor-pointer h-full"
	:class="{'bg-black':isShown}" v-slot="{hide,isShown}" @toggle="setUIState({prop:'userMenuShown',value:$event})">
		<div v-aspect-ratio class="h-full border border-white bg-no-repeat"
		style="background-size:auto 100%;background-position:center" :style="{'background-image':'url('+ auth_photo +')'}"></div>
		<div class="h-full table ml-2 overflow-hidden">
			<div class="table-cell align-middle whitespace-no-wrap overflow-hidden">
				{{ auth.name }}
			</div>
		</div>
		<div v-show="isShown" class="self-end h-0 w-0 ml-auto overflow-visible">
			<div v-click-outside.bubble="hide" class="menu absolute md:static w-full md:w-32 h-screen md:h-auto left-0 md:float-right p-1 text-center text-base font-normal text-black" style="margin-right:-0.5rem;margin-top:0.5rem;">
				<a class="block hover:bg-gray-500" :href="'/users/'+auth.id">User profile</a>
				
				<form class="my-8 text-red-700 font-bold md:my-0" action="/logout" method="POST">
					<input type="hidden" name="_token" :value="csrf">
					<button type="submit" class="block hover:bg-gray-500 w-full">Logout</button>
				</form>
			</div>
		</div>		
	</DropMenuWrapper>
</template>

<script>
	import DropMenuWrapper from '@/$components/wrappers/DropMenuWrapper_v1.vue';
	import {mapMutations,mapState} from 'vuex';

	export default {
		components: {DropMenuWrapper},
		computed: {
			...mapState(['auth']),
			csrf(){
				return this.$store.state.api.csrf
			},
			isShown(){
				return (this.$refs.toggled || {isShown:false}).isShown
			},
			auth_photo(){
				return '/images/profile-photos/' + (this.auth.profile_image || 'default.png')
			}
		},
		methods: {
			...mapMutations(['setUIState']) //noScrollOnMobile
		}
	}
</script>