import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Edit from './views/Edit.vue'
import Sp from './views/Sp.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/edit',
      name: 'edit',
      component: Edit
    },
    {
      path: '/edit/:id',
      name: 'edit-id',
      component: Edit
    },
    {
      path: '/sp',
      name: 'sp',
      component: Sp
    },
  ]
})
