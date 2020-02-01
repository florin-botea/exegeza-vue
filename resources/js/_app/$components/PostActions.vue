<template>
	<DropMenuWrapper v-slot="{hide,isShown,forceHide}" class="h-0">
		<!-- <DropMenuWrapper :layerWrapper="{class:'self-end ml-auto'}"> -->
		<div class="px-2 leading-none cursor-pointer">
			<i class="far fa-caret-square-down"></i>
		</div>
		
		<div v-show="isShown" class="self-end h-0 w-0 ml-auto overflow-visible">
			<div v-click-outside.bubble="hide" class="menu inline-block relative h-auto float-right  shadow-md p-1  bg-gray-100 text-start text-sm font-normal text-black cursor-pointer">
				<can I="delete" :this="model">
					<p class="px-2 py-1 hover:bg-gray-300 mb-2 md:mb-0" @click="forceHide();remove()">
						Sterge
					</p>
				</can>
				<can I="update" :this="model">
					<p class="px-2 py-1 hover:bg-gray-300 mb-2 md:mb-0" @click="forceHide();$emit('edit')">
						Editeaza
					</p>
				</can>
				<can not I="update" :this="model">
					<p v-if="!repported_by_me" class="px-2 py-1 hover:bg-gray-300" @click="forceHide();repportDialog()">
						Raporteaza
					</p>
					<p v-else class="px-2 py-1 hover:bg-gray-300" @click="forceHide();unrepport()">
						Anuleaza raportarea
					</p>
				</can>
			</div>
		</div>
	</DropMenuWrapper>
</template>

<script>
import DropMenuWrapper from '@/$components/wrappers/DropMenuWrapper_v1.vue'
import DeletionRequest from '@/models/DeletionRequest.js'

export default {
	components: {DropMenuWrapper},
	props: {
		model: {type:Object, required:true}
	},
	computed: {
		repported_by_me(){
			return DeletionRequest.query().where( (repp) => {
				return repp.model_id == this.model.id && repp.model_type == this.model.type
			}).first()
		}
	},
	methods: {
		remove(){
			console.error('define remove() method in PostActions inheriter')
		},
		async repportDialog(){
			let reason = await this.$dialog.alert('RepportPostModal', {view: 'RepportPostModal'}).catch(()=>false)
			if (!reason) return
			axios.post('/repports', {
				reason: reason.data,
				model: this.model
			}).then( res => {
				DeletionRequest.insertOrUpdate({
					data: res.data
				})
			})
		},
		unrepport(){
			axios.post('/repports/'+this.repported_by_me.id, {
				_method: 'delete',
				model: this.model
			}).then( res => {
				DeletionRequest.delete({
					where: (repp) => {
						return repp.model_type == this.model.type && repp.model_id == this.model.id
					}
				})
			})
		},
	}
}
</script>