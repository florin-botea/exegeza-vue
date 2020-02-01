import { Model } from '@vuex-orm/core'
import Verse from './Verse'

export default class Chapter extends Model {
	// This is the name used as module name of the Vuex Store.
	static entity = 'chapters'

	// List of all fields (schema) of the post model. `this.attr` is used
	// for the generic field type. The argument is the default value.
	static fields (){
		return {
			id: this.attr(null),
			title: this.attr(''),
			index: this.attr(null),
			verses: this.hasMany(Verse, 'chapter_id')
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