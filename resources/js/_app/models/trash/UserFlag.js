import { Model } from '@vuex-orm/core'
import Comment from './Comment'

export default class UserFlag extends Model {
  // This is the name used as module name of the Vuex Store.
  static entity = 'user_flags'

  // List of all fields (schema) of the post model. `this.attr` is used
  // for the generic field type. The argument is the default value.
  static fields () {
	return {
		id: this.attr(null), //belongsTo(Comment, 'comment_id'),
		comment_id: this.attr(null),
		flag_id: this.attr(null),
	}
  }
  
  static methodConf = {
    http: {
      url: '/comments/:comment/flags'
    },
    methods: {
      // $fetch: {
        // name: 'fetch',
        // http: {
          // url: '',
          // method: 'get',
        // },
      // },
      // $get: {
        // name: 'get',
        // http: {
          // url: '/:id',
          // method: 'get',
        // },
      // },
      $create: {
        name: 'create',
        http: {
          url: '',
          method: 'post',
        },
      },
      // $update: {
        // name: 'update',
        // http: {
          // url: '/:id',
          // method: 'put',
        // },
      // },
      $delete: {
        name: 'delete',
        http: {
          url: '/:id',
          method: 'delete',
        },
      },
    },
  }
  
  static insertSchema = function(res){
	  return res.data.user_flag
  }
  
  // static onInsert = function(res){
	  // console.log(res)
  // }
  
  // static onError = function(res){
	  // console.log(res)
  // }
}