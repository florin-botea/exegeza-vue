export default {
	create({comment_id, description}){
		return '#[comm=' +comment_id+ ']{' +description+ '}'
	},
	template: '#[comm=/*commentID*/]{/*description here*/}'
}