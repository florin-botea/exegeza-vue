<template>
	<form v-on:submit.prevent>
		<div class="form-row p-1">
			<div class="form-group mb-0">
				<select v-model="version">
					<option value="null" selected hidden>Version</option>
					<option v-for="version in versions" :value="version.id">
						{{version.alias}}
					</option>
				</select>
			</div>
			<div class="form-group mb-0">
				<select v-model="selected_book">
					<option value="null" selected hidden>Book</option>
					<option v-for="book in books" :value="book.id">
						{{book.name.length < 12 ? book.name : book.name.substring(0, 9)+'...'}}
					</option>
				</select>
			</div>
			
			<div class="form-group mb-0">
				<select v-model="selected_chapter">
					<option value="null" selected hidden>Chapter</option>
					<option v-for="chapter in chapters" :value="chapter.id">
						{{chapter.index}}. {{ chapter.title.length < 12 ? chapter.title : chapter.title.substring(0, 9)+'...'}}
					</option>
				</select>
			</div>
			
			<div class="form-group mb-0">
				<select @input="selectVerse">
					<option value="null" selected hidden>Verses</option>
					<option v-for="verse in verses" :value="verse.id">
						{{verse.index}}. {{ verse.text.length < 23 ? verse.text : verse.text.substring(0, 20)+'...'}}
					</option>
				</select>
			</div>
			
			<span class="badge" @click="selected_verses=[]">
				{{ selected_verses_indexes.length ? selected_verses_indexes + ' x' : '' }}
			</span>
		</div>
		
		<div class="form-group">
			<input type="text" v-model="description" class="form-control form-control-sm" placeholder="Description here"
			:class="{'is-invalid':description.length<5}" v-focus="focused" @focus="focused=true" @blur="focused=false">
		</div>
		
		<div class="btn-group mb-0">
			<button @click="onSubmit" class="btn-sm btn-dark">
				add
			</button>
			<button @click="$emit('abort')" class="btn-sm btn-warning">
				cancel
			</button>
		</div>
	</form>
</template>

<script>

import versesMention from './verses-mention'

export default {
	data: () => ({
		version: null,
		selected_book: null,
		books: [],
		chapters: [],
		selected_chapter: null,
		verses: [],
		selected_verses: [],
		description: '',
		focused: true
	}),
	computed: {
		versions: () => bible_versions,
		selected_verses_asc(){
			return this.selected_verses.sort((a, b) => a - b)
		},
		selected_verses_indexes(){
			return this.selected_verses_asc.map(v => v%1000)
		}
	},
	methods: {
		selectVerse(e){
			let verse_id = e.target.value
			if (this.selected_verses.length < 2){
				this.selected_verses.push(verse_id)
			}
			else if ( this.selected_verses.includes(verse_id) ){
				this.selected_verses = []
			} else {
				this.selected_verses = [verse_id]
			}
		},
		onSubmit(){
			if ( this.selected_verses.length && this.description.length > 5 ){
				let insertion = versesMention.create( this.selected_verses, this.description )
				this.$emit('submit', insertion)
			}
		}
	},

	watch: {
		version(newVal){
			let url = '/bibles/'+newVal+'/books'
			axios.get(url).then( res => {
				this.books = res.data.books
			})
			this.chapters = []
			this.verses = []
		},
		selected_book(newVal){
			let url = '/bibles/'+this.version+'/books/'+newVal+'/chapters'
			axios.get(url).then( res => {
				this.chapters = res.data.chapters.chapters
			})
			this.verses = []
		},
		selected_chapter(newVal){
			let url = '/bibles/'+this.version+'/books/'+newVal+'/chapters/'+newVal+'/verses'
			axios.get(url).then( res => {
				this.verses = res.data.verses.chapter.verses
			})
		}
	}
}
</script>