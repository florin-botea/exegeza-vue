<template>
	<ReplyList :comment_id="comment_id" :replies_count="replies_count"></ReplyList>
</template>

<script>
import ReplyList from './_components/ReplyList'

export default {
	name: 'ReplyModule',
	components: {
		ReplyList
	},
	props: {
		comment_id: Number,
		replies_count: Number
	},
}
</script>

<style>

</style>