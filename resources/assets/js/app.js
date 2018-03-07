/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * Mixins es una forma flexible de distribuir funcionalidades reutilizables
 * para los componentes Vue. Un objeto mixin puede contener cualquier opción
 * de componente. Cuando un componente usa una mezcla, todas las opciones en
 * la mezcla se "mezclarán" en las propias opciones del componente.
 */

Vue.mixin({
	methods: {
		can: function (accion, permissions) {
			if (permissions === 'all-access') return true;
			if (permissions === 'no-access') return false;
			return permissions.includes(accion);
		},
		errorsManager: function (errors) {
			console.log(errors.data.msg);
		}
	}
})

Vue.filter('capitalize', function (value) {
	if (!value) return '';
	value = value.toString();
	return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.component('table-users', require('./components/TableUsersComponent.vue'));
Vue.component('table-roles', require('./components/TableRolesComponent.vue'));
Vue.component('table-permissions', require('./components/TablePermissionComponent.vue'));
Vue.component('modal-change-password', require('./components/forms/changePassword.vue'));
Vue.component('change-module', require('./components/forms/changeModule.vue'));
Vue.component('registro', require('./registro.vue'));

const app = new Vue({
	el: '#app'
});
