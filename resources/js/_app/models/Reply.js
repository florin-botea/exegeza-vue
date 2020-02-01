import { Model } from '@vuex-orm/core'
import User from './User'
import DeletionRequest from './DeletionRequest'
import ReplyObserver from './observers/ReplyObserver'

export default class Reply extends Model {
	// This is the name used as module name of the Vuex Store.
	static entity = 'replies'
	static observer = ReplyObserver
	
	static fields () {
		return {
			id: this.attr(null),
			type: this.attr('App\\Reply'),
			user_id: this.attr(null),
			author: this.belongsTo(User, 'user_id'),
			comment_id: this.attr(null),
			text: this.attr(''),
			re_reply: this.attr(null),
			repported_by_me: this.hasOne(DeletionRequest, 'model_id'),
			
			edit_form: this.attr(false),
			is_editing: this.attr(false),
			just_edited: this.attr(false),
			just_added: this.attr(false),
		}
	}
	static methodConf = {
		http: {
			url: '/raspunsuri'
		},
		methods: {
			$fetch: {
				name: 'fetch',
				http: {
					url: '',
					method: 'get',
				},
			},
			$get: {
				name: 'get',
				http: {
					url: '/:id',
					method: 'get',
				},
			},
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
				}
			},
		},
	}
}