export default {
	setData(state, {data, route}){
		if (data.books) state.version = data.books.meta.version;
		if (data.chapters) state.book = data.chapters.meta.book;
		if (data.verses && data.verses.meta) state.chapter = data.verses.meta.chapter;
		if (data.verses) state.verses = data.verses.data;
		try {
			state.selectedGlobalId = (parseInt(state.book.index) * 1000000) + (parseInt(state.chapter.index) * 1000) + parseInt(route.queryStrings.verse || 0)
		} catch(e){}
	},
	selectGlobalId(state, globalId){
		state.selectedGlobalId = globalId
	}
}