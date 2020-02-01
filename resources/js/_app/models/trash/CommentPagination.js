import { Model } from '@vuex-orm/core'
import Comment from './Comment'
import Action from '@vuex-orm/plugin-axios/src/actions/Action'

export default class CommentPagination extends Model {
	static entity = 'comment_paginations'

	static fields () {
	// `this.belongsTo` is for belongs to relationship. The first argument
	// is the Model class, and second is the foreign key.
		return {
			verse_id: this.attr(null),
			id: this.attr(null),
			data: this.hasMany(Comment, 'target'),
			current_page_top: this.attr(null),
			current_page: this.attr(''),
			current_page_bottom: this.attr(null),
			prev_page_url: this.attr(null),
			next_page_url: this.attr(null),
			path: this.attr(null),
			per_page: this.attr(0),
			total: this.attr(0),
			
			errors: this.attr([]),//
			
			error_prev: this.attr(false),
			error_next: this.attr(false),
			loading_prev: this.attr(false),
			loading_next: this.attr(false),
			post_form: this.attr(false),
			is_posting: this.attr(false),
		}
	}
  
	static methodConf = {
		http: {
			url: '/versete/:verse/comentarii'
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
					url: '',
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
					url: '/:comment',
					method: 'put',
				},
			},
			$delete: {
				name: 'delete',
				http: {
					url: '/:comment',
					method: 'delete',
				},
			},
		},
	}
}