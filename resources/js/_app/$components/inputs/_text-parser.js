import escapeHtml from '@/utils/escape-html.js'

let postTextRegex = /(\s*)((?!---footer---).\s*)*/
let postFootersRegex = /\n+[ \t]*\[(\d+)\]\: *(url|user|note)\((.*)\)/g
let postDecoratorsRegex = /\[([a-zA-Z0-9 \@\#\(\)\_\+\*\&\:\;\"\'\`\~\$\%\^\&\-\=\<\>\?\!]+)\]\[(\d+)\]/g
export {
	postTextRegex, postFootersRegex, postDecoratorsRegex
}
export default {
	parseText (text){
		if (!text || text == 'undefined'){
			return
		}
		let sanitized_text = escapeHtml(text)
		sanitized_text = sanitized_text.match(postTextRegex)[0]
		let footers =  Array.from( text.matchAll(postFootersRegex) )
		// 1 = index, 2 = type, 3 = ressource
		let footerMap = {}
		footers.forEach( (item) => {
			footerMap[item[1]] = item
		})
		
		sanitized_text = sanitized_text.replace(postDecoratorsRegex, function (match, description, footer) {
			if (!footerMap[footer]){
				return match
			}
			if (footerMap[footer][2] == 'url'){
				return '<a class="text-blue-600 hover:text-blue-400" href="'+ footerMap[footer][3] +'">'+ description +'</a>'
			}
			if (footerMap[footer][2] == 'user'){
				return '<a class="font-semibold text-blue-600 hover:text-blue-400" href="'+ footerMap[footer][3] +'">'+ description +'</a>'
			}
			if (footerMap[footer][2] == 'note'){
				return '<span class="bg-yellow-300" title="'+ footerMap[footer][3] +'">'+ description +'</span>'
			}
			return match
		})
		sanitized_text = sanitized_text
			.replace(/&lt;b /g, '<b>').replace(/ b&gt;/g, '</b>')
			.replace(/&lt;u /g, '<u>').replace(/ u&gt;/g, '</u>')
			.replace(/&lt;i /g, '<i>').replace(/ i&gt;/g, '</i>')
			.replace(/&lt;d /g, '<del>').replace(/ d&gt;/g, '</del>')
		return sanitized_text
	}
}