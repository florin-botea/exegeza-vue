<script>
	import VersesSection from './VersesSection.vue'
	import VerseItemWithSending from './VerseItemWithSending.vue'
	
	export default {
		extends:VersesSection,
		components: {VerseItem:VerseItemWithSending}
	}

</script>