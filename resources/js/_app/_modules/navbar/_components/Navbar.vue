<template>
	<nav class="navbar md:static" :class="navbarHiddenClass"
	v-show="isShown">
	<!-- :style="{'top':topPosition+'px'}"> -->
		<a class="w-16 flex-none" href="/traduceri">
			<img src="/logo.jpg" class="border border-gray-200">
		</a>
		<div class="text-white py-2 hover:nested-hidden-show">
			<div class="md:hidden px-4 cursor-pointer">
				<i class="fas fa-bars"></i>
			</div>
			<div class="md:flex hidden md:ml-4 md:relative absolute md:mt-0 mt-2 bg-gray-800 w-full md:w-auto left-0">
				<a class="block rounded p-2 text-white md:py-0 text-center hover:bg-black" href="/sugestii">
					Sugestii
				</a>
			</div>
		</div>

		<div class="ml-auto"></div> <!-- < delimiter > -->

		<UserMenu v-if="auth"/>
		<NotificationList v-if="auth"/>
		
		<button v-if="!auth" class="bg-green-700 border border-yellow-300 rounded hover:bg-green-500 ml-auto mr-2 px-3"
		@click="redirectToLoginPage">
			Login
		</button>
	</nav>
</template>

<script>
import {mapState} from 'vuex';
import UserMenu from '@/_modules/navbar/_components/UserStats.vue';
import NotificationList from '@/_modules/notifications';

export default {
	components: {
		UserMenu,
		NotificationList
	},
	
	data: () => ({
		isShown: true,
		topPosition: 0,
	}),
	
	computed: {
		...mapState(['auth']),
		navbarHiddenClass(){
			return {
				navbarHidden: this.$store.state.ui.fullscreenForm || !this.$store.state.ui.navbarShown
			}
		}
	},
	
	methods: {
		redirectToLoginPage(){
			window.location.href='/login'
		}
	},
	mounted(){
		document.getElementById('pseudo_navbar').style.display = 'none'
	}
}
</script>

<style>
.navbar {
	transition: top 1s;
	top: 0px;
	@apply flex;
	@apply items-center;
	@apply border-b;
	@apply border-yellow-300;
	@apply fixed;
	@apply w-full;
	@apply bg-gray-800;
	@apply p-2;
	@apply h-12;
	@apply text-lg;
	@apply font-serif;
	@apply font-semibold;
	@apply text-yellow-300;
	@apply z-50;
}
@media (max-width: 768px) {
	.navbarHidden {
		transition: top 1s;
		top: -50px;
	}
}
</style>