import { createRouter, createWebHistory } from 'vue-router'
import Home from '/src/components/Home.vue'
import Homie from '/src/components/Homie.vue'
import Products from '/src/components/Products.vue'
import About from '/src/components/About.vue'
import Beauty from '/src/components/Beauty.vue'
import Category from '/src/components/Category.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/Beauty',
      name: 'Beauty',
      component: Beauty
    },
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/Homie',
      name: 'Homie',
      component: Homie
    },
    {
      path: '/Products',
      name: 'Products_Page',
      component: Products
    },
    {
      path: '/Category',
      name: 'Category_Page',
      component: Category,
      props: { categoryName: 'all' }
    },
    // Dynamic route for all categories
    {
      path: '/category/:categoryName',
      name: 'CategoryDetail',
      component: Category,
      props: true
    },
    {
      path: '/About',
      name: 'About_Page',
      component: About
    },
  ],
})

export default router
