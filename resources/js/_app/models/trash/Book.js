import { Model } from '@vuex-orm/core'
import Chapter from './Chapter'

export default class Book extends Model {
	// This is the name used as module name of the Vuex Store.
	static entity = 'books'

	// List of all fields (schema) of the post model. `this.attr` is used
	// for the generic field type. The argument is the default value.
	static fields (){
		return {
			id: this.attr(null),
			version_id: this.attr(null),
			index: this.attr(null),
			chapter: this.hasMany(Chapter, 'book_id'),
			name: this.attr('')
		}
	}

	static methodConf = {
		http: {
			url: '/bibles'
		},
		methods: {
			$fetch: {
				name: 'fetch',
				http: {
					url: '',
					method: 'get',
				},
			},
		},
	}
}