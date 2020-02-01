<template>
	<div class="flex items-center relative">
		<button :class="[btnClass, {'hover:bg-red-500':disabled}]" class="z-10" :disabled="disabled" @click="$emit('click')" :style="pending ? {visibility:'hidden'} : {}">
			<slot>Submit</slot>
		</button>
		<div class="absolute ml-auto mr-auto" style="height:10px;width:10px;left:50%;margin-left:-5px;">
			<fade-loader :loading="pending" :color="'green'" :height="'7px'" :width="'2px'" :radius="'7px'"/>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		pending: {type:Boolean, default:false},
		btnClass: {type:String, default:''},
		disabled: {type:Boolean, default:false}
	}
}
</script>