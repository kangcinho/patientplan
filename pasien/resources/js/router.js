import Vue from 'vue'
import Router from 'vue-router'
import Login from '../js/component/content/auth/Login'
import Pasien from '../js/component/master/Content'
import User from '../js/component/content/user/ListUser'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes:[
    {
      path: '/',
      name: 'LoginPage',
      component: Login,
      beforeEnter(to, from, next){
        next({ 'name' : 'PasienPage'})
      }
    },
    {
      path: '/login',
      name: 'LoginPageSecond',
      component: Login
    },
    {
      path: '/pasien',
      name: 'PasienPage',
      component: Pasien
    },
    {
      path: '/user',
      name: 'UserPage',
      component: User
    }
  ],
  scrollBehavior( to, from, savePosisi){
    return {
      x:0,
      y:0
    }
  }
})

export default router