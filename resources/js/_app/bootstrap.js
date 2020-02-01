try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

window.axios = require('axios');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	console.log(token)
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    axios.defaults.headers.common['Accept'] = 'application/json, text/plain, */*'
    axios.defaults.headers.common['Access-Control-Allow-Origin'] = 'http://exegeza-biblica.epizy.com';
    //axios.defaults.headers.common['Origin'] = 'http://exegeza-biblica.epizy.com/public'
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Vue from 'vue'
import Vuex from 'vuex'
// import store from './store/store'
import VeeValidate from 'vee-validate'
import { abilitiesPlugin } from '@casl/vue'
window.VueBus = new Vue()
// import listeners from './listeners.js'
import abilities from './utils/ability'

/* components */

// import FormGroup from './components/_globals/inputs/FormGroup_v1.vue'
// import TagPopover from './components/_globals/popovers/TagPopover.vue'
import Bootstrap from './Bootstrap.vue'
import SearchBook from './$components/inputs/SelectBook.vue'
import TheVerseSection from './_modules/bible'
import RepportPostModal from './$components/RepportPostModal.vue'
// import VersesWithSending from './components/VersesWithSending.vue'
// import Navbar from './components/Navbar.vue'
// import VersesSection from './components/VersesSection.vue'
// import VBootstrap from './components/VBootstrap.vue'
import VersesSectionWrapper from './_modules/bible/_components/VersesSectionWrapper.vue'
import CommentSectionShowIcon from './$components/CommentSectionShowIcon.vue'
// import PostTitle from './components/_globals/PostTitle.vue'
// import PostText from './components/_globals/PostText.vue'
// import AuthorCard from './components/_globals/AuthorCard.vue'
// import DropMenuWrapper from './components/_globals/wrappers/DropMenuWrapper.vue'
import Notifications from 'vue-notification'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { Can } from '@casl/vue'
import VuejsDialog from 'vuejs-dialog'
import 'vuejs-dialog/dist/vuejs-dialog.min.css'
import FadeLoader from 'vue-spinner/src/FadeLoader.vue'
import InputOneImage from '@/$components/inputs/InputOneImage'

/* models */
// import BibleDataUnifier from './utils/BibleDataUnifier.js'
// import CommentPagination from './store/models/CommentPagination'
// import ReplyPagination from './store/models/ReplyPagination'

/* directives */
import vClickOutside from './myplugins/v-click-outside'
import AspectRatio from "./myplugins/v-aspect-ratio";
// import vPopover from './myplugins/v-popover'
// import Popover  from 'vue-js-popover'
import vueDebounce from 'vue-debounce'
import Vue2TouchEvents from 'vue2-touch-events'
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js'
// import { focus } from 'vue-focus';
// import vuescroll from 'vue-scroll'

window.DOMel = require('./utils/DOMel').default
// window.buildNotif = require('./utils/notifications-builder').default
const ability = abilities.defineFor($_appData.auth)
 
Vue.use(Vuex)
Vue.use(abilitiesPlugin, ability)
Vue.use(vueDebounce, {listenTo: 'oninput'})
Vue.use(vClickOutside)
// Vue.use(Popover)
// Vue.use(vPopover)
Vue.use(Notifications)
// Vue.use(VeeValidate)
// Vue.use(vuescroll)
Vue.component('Bootstrap', Bootstrap);
Vue.component('SearchBook', SearchBook);
Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('TheVerseSection', TheVerseSection)
// Vue.component('TagPopover', TagPopover)
Vue.component('FadeLoader', FadeLoader)
// Vue.component('VBootstrap', VBootstrap)
Vue.component('VersesSectionWrapper', VersesSectionWrapper)
Vue.component('CommentSectionShowIcon', CommentSectionShowIcon)
Vue.component('InputOneImage', InputOneImage)
Vue.use(AspectRatio)

// Vue.component('PostTitle', PostTitle)
// Vue.component('PostText', PostText)
// Vue.component('AuthorCard', AuthorCard)
// Vue.component('DropMenuWrapper', DropMenuWrapper)
// Vue.component('FormGroup', FormGroup)
Vue.use(Vue2TouchEvents, { longTapTimeInterval: 200 })
// Vue.directive('focus', focus)
Vue.mixin({
	mounted(){
		if (this.$attrs.autofocus){
			this.$el.querySelector('[autofocus]').focus()
		}
	},
})
Vue.component('Can', Can)
Vue.use(VuejsDialog, {
	html: true,
	animation: 'fade',
	backdropClose: true,
	okText: 'Da',
	cancelText: 'Nu'
})
Vue.use(VuejsDialogMixin)
Vue.dialog.registerComponent('RepportPostModal', RepportPostModal);
export default Vue;