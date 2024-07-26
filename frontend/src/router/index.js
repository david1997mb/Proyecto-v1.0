import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue')
    }
    ,{
      path: '/areas',
      name: 'areas',
      component: () => import('../views/Areas/Index.vue')
    }
    ,{
      path: '/areasgrafic',
      name: 'areasgrafic',
      component: () => import('../views/Areas/Grafic.vue')
    }
    ,{
      path: '/clients',
      name: 'clients',
      component: () => import('../views/Clients/Index.vue')
    }
    ,{
      path: '/clientsgrafic',
      name: 'clientsgrafic',
      component: () => import('../views/Clients/Grafic.vue')
    }
    ,{
      path: '/events',
      name: 'events',
      component: () => import('../views/Events/Index.vue')
    }
    ,{
      path: '/events/create',
      name: 'createevents',
      component: () => import('../views/Events/Create.vue')
    }
    ,{
      path: '/events/edit/:id',
      name: 'editevents',
      component: () => import('../views/Events/Edit.vue')
    }
    ,{
      path: '/eventsgrafic',
      name: 'eventsgrafic',
      component: () => import('../views/Events/Grafic.vue')
    }
    ,{
      path: '/pays',
      name: 'pays',
      component: () => import('../views/Pays/Index.vue')
    }
    ,{
      path: '/paysgrafic',
      name: 'paysgrafic',
      component: () => import('../views/Pays/Grafic.vue')
    }
    ,{
      path: '/pays/create',
      name: 'payscreate',
      component: () => import('../views/Pays/Create.vue')
    }
    ,{
      path: '/users',
      name: 'users',
      component: () => import('../views/Users/Index.vue')
    }
    ,{
      path: '/reports',
      name: 'reports',
      component: () => import('../views/Users/Reports.vue')
    }
    ,{
      path: '/reporte',
      name: 'reporte',
      component: () => import('../views/Reporte.vue')
    }
  ]
})

router.beforeEach( async (to) =>{
  const publicPages = ['/pays/create','/','/login']
  const authRequired = !publicPages.includes(to.path)
  const auth = useAuthStore()
  if (authRequired && !auth.user) {
    auth.returnUrl = to.fullPath
    return '/login'
  }
})
export default router
