import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Login',
      component: () => import('@/views/Login.vue'),
      meta: { requiresAuth: false }
    },
    {
      path: '/Dashboard',
      name: 'Dashboard',
      component: () => import('@/views/Dashboard.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/Karyawan',
      name: 'Karyawan',
      component: () => import('@/views/DataKaryawan.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/PKWT',
      name: 'PKWT',
      component: () => import('@/views/PkwtView.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/Departments',
      name: 'Departments',
      component: () => import('@/views/Departments.vue'),
      meta: { requiresAuth: true }
    },
    {
      path:'/Jabatan',
      name:'Jabatan',
      component: () => import('@/views/Jabatan.vue'),
      meta: { requiresAuth: true }
    }
  ],
})

router.beforeEach((to, from) => {
  const isLoggedIn = !!localStorage.getItem('token')

  if (to.meta.requiresAuth && !isLoggedIn) {
    return { name: 'Login' }
  }
  if (to.name === 'Login' && isLoggedIn) {
    return { name: 'Dashboard' }
  }

  return true
})

export default router