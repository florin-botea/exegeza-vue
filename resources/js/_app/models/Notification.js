import { Model } from '@vuex-orm/core'

export default class Notification extends Model {
	static entity = 'notifications'

	static fields () {
		return {
			id: this.attr(null),
			author: this.attr(''),
			created_at: this.attr(null),
			data: this.attr(null),
			from: this.attr(null),
			from_more: this.attr(0),
			notifiable_id: this.attr(null),
			read_at: this.attr(null),
			text: this.attr(''),
			url: this.attr(null),
			type: this.attr(null),
		}
	}
}