export default {
	create(user){
		return '#[user=' +user.id+ ']{' +user.name+ '}'
	},
	template: '#[user=/*userID*/]{/*username here*/}'
}