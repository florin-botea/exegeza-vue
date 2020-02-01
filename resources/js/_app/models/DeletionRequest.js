import { Model } from '@vuex-orm/core'
import Comment from './Comment'
import Action from '@vuex-orm/plugin-axios/src/actions/Action'

export default class DeletionRequest extends Model {
	static entity = 'deletion_requests'

	static fields () {
	// `this.belongsTo` is for belongs to relationship. The first argument
	// is the Model class, and second is the foreign key.
		return {
			id: this.attr(null),
			model_type: this.attr(''),
			model_id: this.attr(null),
			deleted_by: this.attr(null),
			reason: this.attr(''),
		}
	}
}