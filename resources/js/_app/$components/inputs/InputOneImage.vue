<template>
	<div>
		<input v-bind="$attrs" @change="readURL" class="hidden" type='file' id="image_input_with_preview"/>
		<label v-show="isDirty" id="blah" for="image_input_with_preview" class="block bg-no-repeat w-full h-full"
		style="background-size:auto 100%;background-position:center"
		:class="label.class"></label>
		
		<!-- placeholder -->
		
		<label v-show="!isDirty" for="image_input_with_preview" class="block bg-no-repeat w-full h-full"
		:style="{'background-image':'url('+ defaultSrc.url +')'}"
		style="background-size:auto 100%;background-position:center"
		:class="label.class"></label>
	</div>
</template>

<script>

export default {
	inheritAttrs: false,
	props: {
		label: {
			default: () => ({})
		},
		defaultSrc: {
			type: Object,
			default: () => ({url:'#'})
		}
	},
	data: () => ({
		isDirty: false
	}),
	methods: {
		readURL(e) {
			let input = e.target
			this.isDirty = true
			if (input.files && input.files[0]) {
				var reader = new FileReader()

				reader.onload = function(e) {
					document.getElementById('blah').style.backgroundImage = 'url('+ e.target.result +')'
				}
				reader.readAsDataURL(input.files[0])
			}
		}
	},
	mounted(){
		cl(this.defaultSrc)
	}
}
</script>