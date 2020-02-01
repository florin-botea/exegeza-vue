<template>
	<Navbar/>
</template>

<script>
import Navbar from '@/_modules/navbar/_components/Navbar.vue';

export default {
	name: 'NavbarModule',
	components: {
		Navbar,
	},
	
	mounted(){
		document.getElementById('pseudo_navbar').style.display = 'none'
	}
}
</script>