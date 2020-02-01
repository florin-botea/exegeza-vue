import Vue from 'vue';
import Vuex from 'vuex';
import VuexORM from '@vuex-orm/core';
import VuexORMAxios from '@/myplugins/plugin-axios/src'
import database from './database.js';
import mutations from './mutations.js';
import bible from '@/_modules/bible/_store'
Vue.use(Vuex);

const token = document.head.querySelector('meta[name="csrf-token"]');

VuexORM.use(VuexORMAxios, {
  database,
  http: {
    baseURL: '',
    url: '/',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
	onError(error){
		//handle error de orice tip aici ,,,sau in alt fisier.
		return false
	}
  }
})

export default new Vuex.Store({
	plugins: [ VuexORM.install(database) ],
	modules: {
		bible
	},
	state: {
		api: {
			csrf: token.content,
		},
		ui: {
			commentsSectionShown: null,
			fullscreenForm: false,
			navbarShown: true,
			notificationsShown: false,
			userMenuShown: false
		},
		route: {},
		savedForms: {},
		auth: null,
	},
	mutations
});