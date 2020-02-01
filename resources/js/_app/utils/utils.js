var arrayDump = function (array)
{
	array = array.sort(function(a, b){return a-b})
	return {
		first: array[0] || null,
		last: array.length ? array[array.length-1] : null
	}
}

export {
	arrayDump
}