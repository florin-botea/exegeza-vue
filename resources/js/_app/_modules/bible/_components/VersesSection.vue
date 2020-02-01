<template>
	<div class="relative p-1 text-justify md:pt-0">
	<!-- <VersesSectionWrapper class="relative p-1 pl-2 text-justify"> -->
		<VerseItem v-for="verse in verses" :key="verse.id" class="px-2 border-b border-gray-300 pr-2"
		:selected="selectedVerse" :verse="verse"
		@select-verse="selectGlobalId($event)"/>
		
		<div v-if="!verses.length">
			<div class="text-lg font-bold text-orange-300">
				Niciun rezultat...
			</div>
		</div>

		<CommentSectionShowIcon/>
	</div>
	<!-- </VersesSectionWrapper> -->
</template>

<script>
import CommentSectionShowIcon from '@/$components/CommentSectionShowIcon'
//import Chapter from './../store/models/Chapter'
//import Verse from './../store/models/Verse'
import VersesSectionWrapper from './VersesSectionWrapper.vue'
import VerseItem from './VerseItem.vue'
import {mapState,mapActions,mapMutations} from 'vuex'

export default {
	components: {
		VersesSectionWrapper,
		VerseItem,
		CommentSectionShowIcon
	},
	computed:{
		selectedVerse(){
			return this.$store.state.bible.selectedGlobalId
		},
		verses(){
			return this.$store.state.bible.verses
		}
	},
	methods: {
		...mapMutations('bible', ['selectGlobalId'])
		//setCommentsSection(verse_g_id){
			//this.$store.commit('setUIState', {prop:'commentsSectionShown', value:true})
			//this.$store.commit('setUIState', {prop:'navbarShown', value:true})
		//	this.$store.commit('selectVerse', verse_g_id)
		//}
	},
}
</script>