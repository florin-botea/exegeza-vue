import { Model } from '@vuex-orm/core'
import Flag from './Flag'

export default class FlagRecord extends Model {
  // This is the name used as module name of the Vuex Store.
  static entity = 'flag_records'

  // List of all fields (schema) of the post model. `this.attr` is used
  // for the generic field type. The argument is the default value.
  static fields () {
    return {
      id: this.attr(null),
      comment_id: this.attr(null),
      flag_id: this.attr(null),
      count: this.attr(0),
	  details: this.hasOne(Flag, 'id')
    }
  }
}