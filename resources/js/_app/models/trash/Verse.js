import { Model } from '@vuex-orm/core'

export default class Verse extends Model {
	// This is the name used as module name of the Vuex Store.
	static entity = 'verses'

	// List of all fields (schema) of the post model. `this.attr` is used
	// for the generic field type. The argument is the default value.
	static fields (){
		return {
			id: this.attr(null),
			index: this.attr(null),
			chapter_id: this.attr(null),
			text: this.attr(''),
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