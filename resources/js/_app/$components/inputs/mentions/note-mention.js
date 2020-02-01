export default {
	create({text, note}){
		return '#[note=' +note+ ']{' +text+ '}'
	},
	template: '#[note=/*note description*/]{/*refering text here*/}'
}