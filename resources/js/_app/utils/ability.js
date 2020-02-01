import { AbilityBuilder, Ability } from '@casl/ability'

export default {
	defineFor(user){
		const { rules, can, cannot } = AbilityBuilder.extract()
		if (!user){
			user = {user: {id:-1}, permissions: []}
		}
		let perm_name_list = user.permissions.map( (perm) => perm.name )
		console.log(perm_name_list)
		
		if ( perm_name_list.includes('post comments') ){
			can('create', 'Comment')
		}
		if ( perm_name_list.includes('post replies') ){
			can('create', 'Reply')
		}
		
		//default
		can(['update', 'delete'], 'Comment', { user_id: user.user.id })
		
		can(['update', 'delete'], 'Reply', { user_id: user.user.id })
		
		can(['update', 'delete'], 'Tag', { assigned_by: user.user.id })

		return new Ability(rules)
	}
}