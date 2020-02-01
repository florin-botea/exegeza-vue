<template>
	<div class="relative flex flex-wrap items-center">
		<label v-if="$attrs.id && label" :for="$attrs.id" class="inline-block pr-1 font-semibold" :class="labelPosition">
			{{label}}
		</label>
		
		<textarea :value="value" @input="$emit('input',$event)" v-bind="$attrs" :class="inputClass" class="flex-1 shadow border border-gray-600 appearance-none border rounded leading-tight focus:outline-none focus:shadow-outline w-full rounded" :required="required"></textarea>
		
		<div v-if="iErrors.length" class="error-popper self-stretch cursor-pointer" :style="{'z-index':(1000 - _uid)}">
			<div class="px-1 text-red-600 h-full table">
				<i class="fas fa-exclamation-circle align-middle" style="display:table-cell"></i>
			</div>
			<p class="invalid-message : w-full font-semibold text-red-600 leading-none text-sm absolute bg-white shadow p-1 left-0">
				{{iErrors}}
			</p>
		</div>
	</div>
</template>

<script>
	export default {
		inheritAttrs: false,
		props: {
			value: String,
			iErrors: {
				type:Array,
				default: () => []
			},
			required: {type:Boolean,default:false},
			label: {type:String},
			labelPos: {type:String},
			inputClass: {type:String,default:'py-1 px-2'}
		},
		computed: {
			labelPosition(){
				let pos = 'w-full';
				if (this.labelPos){
					switch(this.labelPos){
						case 'top': pos = 'w-full'; break;
						case 'left': pos = ''; break;
					}
				}
				return pos
			}
		}
	}
</script>