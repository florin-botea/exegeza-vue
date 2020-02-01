<script>
	import {mapActions,mapMutations} from 'vuex'
	import Comment from '@/models/Comment'
	import PostActions from '@/$components/PostActions.vue'
	
	export default {
		extends: PostActions,
		
		methods: {
			remove(){
				Comment.$delete({params: {id:this.model.id}})
			},
		},
	}
</script>