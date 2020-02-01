<script>
	import {mapActions,mapMutations} from 'vuex'
	import Reply from '@/models/Reply'
	import PostActions from '@/$components/PostActions.vue'
	
	export default {
		extends: PostActions,
		
		methods: {
			remove(){
				Reply.$delete({params: {id:this.model.id}})
			},
		},
	}
</script>