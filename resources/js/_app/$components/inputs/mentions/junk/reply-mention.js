export default {
	create({reply_id, description}){
		return '#[reply=' +reply_id+ ']{' +description+ '}'
	},
	template: '#[reply=/*replyID*/]{/*description here*/}'
}