<template>
	<TagsSection :comment_id="comment_id"></TagsSection>
</template>

<script>
import TagsSection from './_components/TagsSection.vue'

export default {
	name: 'TagModule',
	components: {
		TagsSection
	},
	props: {
		comment_id: {type:Number,required:true}
	}
}
</script>

<style>

</style>