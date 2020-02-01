<template>
	<div class="flex flex-wrap">
		<label v-if="label" :for="label.for" :class="label.class">
			{{label.value}}
		</label>
		<div class="relative flex flex-wrap items-center h-full w-full">
			<slot>
				<input v-bind="$attrs" class="form-control py-2 px-3" :value="value">
			</slot>
			<div v-if="iErrors.length" class="hover:next-hidden-show absolute right-0 px-1 text-red-600 h-full table cursor-pointer">
				<i class="fas fa-exclamation-circle align-middle" style="display:table-cell"></i>
			</div>
			<div class="hidden w-full h-0">
				<p v-for="err in iErrors" class="w-full font-semibold text-red-600 leading-none absolute text-sm bg-white shadow p-1 left-0">
					{{err}}
				</p>
			</div>
		</div>
		<div v-if="minLength && maxLength" class="relative float-left bg-white text-sm" style="top:-16px;left:5px;z-index:100;">
			<span :style="utf8Size < minLength ? {color:'red'} : {}"> {{ utf8Size }} </span>
			<span :style="utf8Size > maxLength ? {color:'red'} : {}"> /{{ maxLength }} </span>
		</div>
	</div>
</template>

<script>
import Cutter from 'utf8-binary-cutter'
import debounce from 'lodash/debounce'

export default {
	props: {
		value: String,
		label: Object,
		iErrors: Array,
		minLength: Number,
		maxLength: Number
	},
	data: () => ({
		utf8Size: 0
	}),
	watch: {
		value: debounce(function(newVal){
			this.utf8Size = Cutter.getBinarySize(this.value)
		}, 300)
	},
}
</script>