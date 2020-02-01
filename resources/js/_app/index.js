require('./bootstrap');
import Vue from 'vue';
import store from './store';
import navbar from './_modules/navbar';
import bible from './_modules/bible';
import TheCommentSection from './_modules/comments'
import TheVerseSection from './_modules/bible'
import VersesWithSending from './_modules/bible/_components/VersesWithSending'
//var cache = require('memory-cache'); uninstall
//import cache from 'js-cache' uninstall
//var cookie = require('cookie'); ---

window.cl = console.log

window.app = new Vue({
    components: {
		navbar,
		TheCommentSection,
		TheVerseSection,
		VersesWithSending
	},
	store,
	computed: {
		
	},
	watch: {
		
	},
}).$mount('#app');

// ls.set('foo', {
	// title: 123,
	// text: 456
// })
// cl(ls.get('foo'))
//cache.put('lorem', 'ipsum', 60000);
//console.log(cache.get('lorem'));

//localStorage.setItem("lastname", "Smith");
//console.log(localStorage.lastname)