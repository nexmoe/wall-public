// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

import '../theme/index.css'
import ElementUI from 'element-ui'

Vue.use(ElementUI)

import axios from 'axios';
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
Vue.prototype.$axios = axios;

import VueAxios from 'vue-axios'

import VueLazyload from 'vue-lazyload'

import VueContentPlaceholders from 'vue-content-placeholders'

Vue.use(VueContentPlaceholders)
Vue.use(VueLazyload)
Vue.use(ElementUI)
Vue.use(VueAxios, axios)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  render: h => h(App)
})