import { Model } from '@vuex-orm/core'
//import User from './User'
import Comment from './Comment'
import User from './User'
import TagObserver from './observers/TagObserver'

export default class Tag extends Model {
	static entity = 'tags'
	static observer = TagObserver

	static fields () {
		return {
			id: this.attr(null),
			details: this.attr({}),
			assigned_by: this.attr(null),
			comment_id: this.attr(null),
			author: this.belongsTo(User, 'assigned_by'),
		}
	}

	static methodConf = {
		http: {
			url: '/taguri'
		},
		methods: {
			$create: {
				name: 'create',
				http: {
					url: '',
					method: 'post',
				},
			},
			$update: {
				name: 'update',
				http: {
					url: '/:id',
					method: 'put',
				},
			},
			$delete: {
				name: 'delete',
				http: {
					url: '/:id',
					method: 'delete',
				},
			},
		},
	}
}