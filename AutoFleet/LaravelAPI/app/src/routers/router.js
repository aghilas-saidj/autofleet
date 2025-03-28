// src/router.js

import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../views/HomePage.vue'
import CarsListing from '../views/CarsListing.vue'
import TestFilter from '../views/TestFilter.vue'


const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomePage
  },
  {
    path: '/cars',
    name: 'About',
    component: CarsListing
  },

  {
    path: '/test',
    name: 'Test',
    component: TestFilter
  }
]



const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
