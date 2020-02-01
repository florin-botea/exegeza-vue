import { Model } from '@vuex-orm/core'
import FlagRecord from './FlagRecord'

export default class Flag extends Model {
  // This is the name used as module name of the Vuex Store.
  static entity = 'flags'

  // List of all fields (schema) of the post model. `this.attr` is used
  // for the generic field type. The argument is the default value.
  static fields () {
    return {
      id: this.attr(null),
      name: this.attr(''),
      value: this.attr(0),
	  records: this.hasOne(FlagRecord, 'flag_id')
    }
  }
}