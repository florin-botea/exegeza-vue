export default function BibleDataUnifier($data, $route)
{
	this.data = $data
	this.route = $route
	
	this.version = function(){
		return this.data.books ? this.data.books.meta.version : {
			id: 0,
			index: 0,
			name: 'none'
		}
	}
	this.book = function(){
		return this.data.chapters ? this.data.chapters.meta.book : {
			id: 0,
			index: 0,
			name: 'none'
		}
	}
	this.chapter = function(){
		return (this.data.verses && this.data.verses.meta.chapter) ? this.data.verses.meta.chapter : {
			id: 0,
			index: 0,
			name: 'none'
		}
	}
	this.verse = function(){
		return parseInt(this.route.queryStrings.verse ? this.route.queryStrings.verse : 0)
	}
	this.global_id = function(){
		try {
			return (parseInt(this.book().index) * 1000000) + (parseInt(this.chapter().index) * 1000) + this.verse()
		} catch(e){
			return null
		}
	}
}