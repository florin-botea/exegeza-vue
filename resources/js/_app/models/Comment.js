import { Model } from '@vuex-orm/core'
import User from './User'
import Tag from './Tag'
import DeletionRequest from './DeletionRequest'
import CommentObserver from './observers/CommentObserver'
//import FlagRecord from './FlagRecord'
//import UserFlag from './UserFlag'

export default class Comment extends Model {

	static entity = 'comments'
	static observer = CommentObserver

	static fields () {
		return {
			id: this.attr(null),
			type: this.attr('App\\Comment'),
			user_id: this.attr(null),
			author: this.belongsTo(User, 'user_id'),
			target: this.attr(null),
			title: this.attr(''),
			text: this.attr(''),
			created_at: this.attr(null),
			updated_at: this.attr(null),
			replies_count: this.attr(0),
			tags: this.hasMany(Tag, 'comment_id'),
			repported_by_me: this.hasOne(DeletionRequest, 'model_id'),
			//flag_records: this.hasMany(FlagRecord, 'id'),
			//user_flag: this.hasOne(UserFlag, 'id'),
			
			edit_form: this.attr(false),
			is_editing: this.attr(false),
			just_edited: this.attr(false),
			just_added: this.attr(false),
			has_replies_section_shown: this.attr(false)
		}
	}
	
	static methodConf = {
		http: {
			url: '/comentarii'
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
				}
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