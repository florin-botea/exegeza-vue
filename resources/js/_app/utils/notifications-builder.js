export default function(e){
	let text = ''
	if (e.data.errors){
		Object.values(e.data.errors).forEach(field_errors => {
			field_errors.forEach( error => {
				text += (error + '<br>')
			})
		})
	} else {
		text = e.reesponse ? e.reesponse.data.message : e
		console.log(e)
	}
	
	return {
		group: 'notifications',
		//type: responseCodeClassMap[e.status],
		duration: 5000,
		title: e.statusText,
		text: text,
	}
}

const responseCodeClassMap = {
	'200': 'bg-primary',
	'500': 'bg-danger',
	'422': 'bg-warning text-dark',
	'429': 'bg-warning text-dark',
}