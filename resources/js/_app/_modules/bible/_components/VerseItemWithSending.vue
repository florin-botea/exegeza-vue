<script>
	import VerseItem from './VerseItem.vue'
	
	export default {
		extends: VerseItem,
		
		computed: {
			render(){
				return "<strong>"+this.verse.book_name+"["+this.verse.chapter_index+","+this.verse.index+"]</strong> "+this.verse.text
			}
		}
	}
</script>