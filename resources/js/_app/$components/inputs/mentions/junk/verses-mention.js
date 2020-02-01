export default {
	//first verse id and second
	create(verses_arr, description){
		let verses_string = verses_arr.join('-')
		return '#[verse=' +verses_string+ ']{' +description+ '}'
		//voi avea book alias si atunci o sa insereze descriere automat
	},
	template: '#[verse=/*startID-endID(optional)*/]{/*description here*/}',
}