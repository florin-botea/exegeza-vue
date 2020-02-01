export default {
	create({url, description}){
		return '#[href=' +url+ ']{' +description+ '}'
	},
	template: '#[href=/*link*/]{/*description here*/}'
}