import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import ProductList from '../pages/ProductList.vue'
import ProductForm from '../pages/ProductForm.vue'

const routes = [
  { path: '/login', component: Login },
  { path: '/', component: ProductList, meta: { requiresAuth: true } },
  { path: '/create', component: ProductForm, meta: { requiresAuth: true } },
  { path: '/edit/:id', component: ProductForm, meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else {
    next()
  }
})

export default router