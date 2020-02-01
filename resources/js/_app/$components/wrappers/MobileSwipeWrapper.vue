<template>
	<div
	v-touch:swipe.right="throttle(swipeRight)"
	v-touch:swipe.top="throttle(swipeTop)"
	v-touch:swipe.bottom="throttle(swipeBottom)"
	v-touch:start="record_long_touch">
		<slot></slot>
	</div>
</template>

<script>
	export default {
		data: () => ({
			tap_timestamp: 0,
		}),
		methods: {
			record_long_touch(){
				this.tap_timestamp = new Date().getTime()
			},
			longTouch(){
				let now = new Date().getTime()
				return now > (this.tap_timestamp + 300)
			},
			throttle(callback){
				return () => {
					let now = new Date().getTime()
					return callback(now - this.tap_timestamp)
				}
			},
			swipeRight(){
				//
			},
			swipeTop(){
				//
			},
			swipeBottom(){
				//
			}
		}
	}
</script>