import Vue from 'vue'
import {arrayDump} from '@/utils/utils'

const insertOrUpdatePagination = function(state, {data, id}){
	if (!data){
		return
	}
	let pagination = state.paginations[id] || null
	if (pagination){
		pagination.loadedPages.push(data.current_page);
		let loadedPages = arrayDump(pagination.loadedPages);
		pagination.nextPage = loadedPages.last < data.last_page ? loadedPages.last+1 : null;
		pagination.prevPage = loadedPages.first > 0 ? loadedPages.first-1 : null;
		pagination.lastPage = data.last_page;
		pagination.path = data.path;
		pagination.perPage = data.per_page;
		pagination.total = data.total;
	} 
	else {
		Vue.set(state.paginations, id, {
			loadedPages: [data.current_page],
			nextPage: data.current_page < data.last_page ? data.current_page+1 : null,
			prevPage: data.current_page > 0 ? data.current_page-1 : null,
			lastPage: data.last_page,
			path: data.path,
			perPage: data.per_page,
			total: data.total
		})
	}
}

export {
	insertOrUpdatePagination
}