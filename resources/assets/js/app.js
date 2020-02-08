
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import router from './router'
import VModal from 'vue-js-modal'
import ElementUI from 'element-ui'
import store from './vuex'
import locale from 'element-ui/lib/locale/lang/en'
import localforage from 'localforage'
Vue.use(VModal, {dialog: true})
Vue.use(ElementUI, { locale })


import vSelect from 'vue-select'
 
Vue.component('v-select', vSelect)

localforage.config({
    driver: localforage.LOCALSTORAGE,
    storeName: 'batadash'
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app', require('./components/App.vue').default);
Vue.component('leftmenu', require('./components/Leftmenu.vue').default);
Vue.component('topbarmenu', require('./components/Topbarmenu.vue').default);
Vue.component('allcontent', require('./components/Allcontent.vue').default);


Vue.component('mobilemenu', require('./components/Mobilemenu.vue').default);
Vue.component('chat', require('./components/Chat.vue').default);
Vue.component('reportModal', require('./components/reportModal.vue').default);
Vue.component('reportCard', require('./components/reportCard.vue').default);
Vue.component('swalMessageModal', require('./components/swalMessageModal.vue').default);
Vue.component('qm', require('./components/swalQuestionModal.vue').default);
Vue.component('formerror', require('./components/Formerror.vue').default);
Vue.component('fuelcard', require('./components/fuelCard.vue').default);
Vue.component('report-settings-modal', require('./components/reportSettingsModal.vue').default);
Vue.component('data-pages', require('./components/dataPages.vue').default);
Vue.component('loading', require('./components/loadinganimation.vue').default);
Vue.component('reptanim', require('./components/reportAnimation.vue').default);
Vue.component('bkModal', require('./components/bookingModal.vue').default);
Vue.component('todolist', require('./components/todolist.vue').default);
Vue.component('asteriks', require('./components/asteriks.vue').default);
Vue.component('vehicleReportModal', require('./components/vehicleReportModal.vue').default);
Vue.component('poolReportModal', require('./components/poolReportModal.vue').default);
Vue.component('costingReportModal', require('./components/costingReportModal.vue').default);
Vue.component('fuelReportModal', require('./components/fuelReportModal.vue').default);
Vue.component('repairReportModal', require('./components/repairReportModal.vue').default);
Vue.component('inventoryReportModal', require('./components/inventoryReportModal.vue').default);
Vue.component('driversReportModal', require('./components/driversReportModal.vue').default);
Vue.component('accidentReportModal', require('./components/accidentReportModal.vue').default);
Vue.component('tripsReportModal', require('./components/tripsReportModal.vue').default);
Vue.component('reportGroupingCard', require('./components/reportGroupingCard.vue').default);
Vue.component('reportListing', require('./components/reportListing.vue').default);
Vue.component('footernav', require('./components/footernav.vue').default);
Vue.component('ImageUpload', require('./components/Imagerupload.vue').default);
Vue.component('ShoesUpload', require('./components/ShoesUpload.vue').default);
Vue.component('ProductsUpload', require('./components/ProductsUpload.vue').default);

store.dispatch('auth/setToken').then(() => {
    store.dispatch('auth/fetchUser').catch(() => {
        store.dispatch('auth/clearAuth')
        router.replace({ name: 'login' })
    })
}).catch(() => {
    store.dispatch('auth/clearAuth')
});

const app = new Vue({
    el: '#app',
    router: router,
    store: store
});
