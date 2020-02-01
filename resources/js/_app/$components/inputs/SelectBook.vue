<template>
	<select class="text-sm" name="book">
		<option value="all">Toate</option>
		<option v-for="book in books" :value="book.name">
			{{book.name}}
		</option>
	</select>
</template>

<script>
	export default{
		data: () => ({
			books: []
		}),
		methods: {
			fetch(alias){
				axios.get('/traduceri/'+alias+'/carti')
					.then( res => this.books = res.data.books.data)
			}
		},
		mounted(){
			if (bible_versions){
				this.fetch(bible_versions.data[0].alias)
			}
			VueBus.$on('search-criteria-version-changed', alias => {
				this.fetch(alias)
			})
		}
	}
</script>