import Vue from 'vue'
import Router from 'vue-router'
import Login from '../js/component/content/auth/Login'
import Pasien from '../js/component/content/pasienPulang/Pasien'
import User from '../js/component/content/user/ListUser'
import store from './store/store'
import Analisa from './component/content/analisa/Analisa'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  // base: "ongoing/pasienPulang/pasien/public",
  base: process.env.BASE_URL,
  // base: "rpp/public/",
  routes:[
    {
      path: '/',
      name: 'LoginPage',
      component: Login,
    },
    {
      path: '/login',
      name: 'LoginPageSecond',
      component: Login,
      meta: {
        auth: false
      }
    },
    {
      path: '/pasien',
      name: 'PasienPage',
      component: Pasien,
      meta: {
        auth: true
      }
    },
    {
      path: '/user',
      name: 'UserPage',
      component: User,
      meta: {
        auth: true
      },
      beforeEnter(to, from, next){
        const user = store.getters.getDataUserLogin.canAdmin
        if(user){
          next()
        }else{
          next({ 'name' : 'PasienPage'})
        }
      }
    },
    {
      path: '/analisa',
      name: 'AnalisaPage',
      component: Analisa,
      meta: {
        auth: true
      },
      beforeEnter(to, from, next){
        const user = store.getters.getDataUserLogin.canEkspor
        if(user){
          next()
        }else{
          next({ 'name' : 'PasienPage'})
        }
      }
    }
  ],
  scrollBehavior( to, from, savePosisi){
    return {
      x:0,
      y:0
    }
  }
})

router.beforeEach( (to, from, next) => {
  const isAuth = store.getters.getAuth
  if(to.matched.some( record => record.meta.auth )){
    if(!isAuth){
      next({ 'name' : 'LoginPageSecond'})
    }else{
      next()
    }
  }else{
    if(isAuth){
      next({ 'name': 'PasienPage'})
    }else{
      next()
    }
  }
})


export default router