<template>
	<div class="flex">
		<LazySearch class="z-50" ref="lazy_search" :suggestions="suggestions" 
		:inputClass="'px-2 border border-gray-500 rounded'"
		:valueProp="(suggestion)=>suggestion.name" :build="(val)=>({id:0,name:val})"
		v-debounce:500ms="fetchUsers" @submit="onSubmit">
			<template v-slot:default="{selectedIndex,mouseSelect}">
				<div class="bg-white hover:bg-gray-300" v-for="(option, index) in suggestions" 
				@click="mouseSelect(index)"
				:class="{'bg-gray-300':selectedIndex === index}">
					{{ option.name }}
				</div>
			</template>
		</LazySearch>
		<button class="bg-gray-900 shadow hover:bg-black px-2 rounded text-white"
		@click="onSubmitBtn">
			<i class="fas fa-check"></i>
		</button>
		<button class="shadow-md hover:text-red-500 px-2 rounded border border-gray-600"
		@click="$emit('abort')">
			<i class="fas fa-times"></i>
		</button>
	</div>
</template>

<script>

import LazySearch from './../LazySearch3'
//import userMention from './user-mention'

export default {
	components: {LazySearch},
	data: () => ({
		suggestions: []
	}),
	methods: {
		onSubmit(user)
		{
			if (!user.id){
				this.$refs.lazy_search.$refs.input.focus()
				return
			}
			//let insertion = userMention.create(user)
			this.$emit('submit', user)
			this.clearForm()
		},
		fetchUsers(qs)
		{
			if (qs.length < 1){
				return
			}
			axios.get('/users/name-suggestion/'+qs).then( res => {
				this.suggestions = res.data
			})
		},
		onSubmitBtn()
		{
			this.$refs.lazy_search.submit()
		},
		clearForm(){
			this.$refs.lazy_search.clearForm()
		}
	},
	mounted(){
		this.$refs.lazy_search.$refs.input.focus()
	}
}
</script>