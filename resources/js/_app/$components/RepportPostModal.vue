<template>
    <div class="custom-view-wrapper">
		<div class="text-red-500 font-semibold">
			Va rugam sa selectati motivul raportarii acestei postari:
		</div>
		<div @click="handleRepport('duplicat')" class="bg-gray-300 hover:bg-gray-500 text-center rounded cursor-pointer my-1">
			Duplicat
		</div>
		<div @click="handleRepport('ostentativ')" class="bg-gray-300 hover:bg-gray-500 text-center rounded cursor-pointer my-1">
			Ostentativ
		</div>
		<div @click="handleRepport('nu isi are locul aici')" class="bg-gray-300 hover:bg-gray-500 text-center rounded cursor-pointer my-1">
			Nu isi are locul aici
		</div>
		<div class="flex my-1">
			<input type="text" v-model="customReason" class="flex-1 border border-gray-700 leading-none p-0">
			<div @click="handleRepport('altul')" class="self-stretch bg-gray-300 hover:bg-gray-500 text-center rounded cursor-pointer border border-gray-700 px-2">
				Altul
			</div>
		</div>
		<button class="bg-yellow-300 border border-yellow-500 hover:bg-yellow-500 rounded px-2" :options="options" @click="handleDismiss()">
			Anuleaza
		</button>
    </div>
</template>
 
<script>
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js'
 
export default {
	mixins: [VuejsDialogMixin],
	data: () => ({
		customReason: ''
	}),
	methods: {
		handleRepport(reason) {
			if (reason === 'altul' && (5 < this.customReason.length < 50) ){
				alert('intre 5 si 50 caractere')
				return
			}
			if (reason === 'altul'){
				reason = this.customReason
			}
			this.proceed(reason)
		},
		handleDismiss() {
			this.cancel()
		}
	},
}
</script>