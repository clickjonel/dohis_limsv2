import { createRouter, createWebHistory } from 'vue-router'

import Login from '../components/Login.vue';
import Delivery from '../components/Pages/Delivery/Delivery.vue';
import Stock from '../components/Pages/Stocks/Stock.vue';
import Dashboard from '../components/Pages/Dashboard.vue';
import Property from '../components/Pages/Property/Property.vue';
import AuthenticatedLayout from '../components/PageLayouts/AuthenticatedLayout.vue';
import axios from '../axios/axios.js';
import { useAuthStore } from '../stores/authStore.js';
import Measurement from '../components/Pages/Measurement/Measurement.vue';
import Form from '../components/Pages/Form/Form.vue';
import MyDelivery from '../components/Pages/Delivery/MyDelivery.vue';

const routes = [
    {
        name:'Admin',
        path:'/',
        component:AuthenticatedLayout,
        meta: { requiresAuth: true },
        children:[
            {
                name:'Delivery',
                path:'/deliveries',
                meta: { requiresAuth: true },
                component:Delivery
                
            },
            {
                name:'My Delivery',
                path:'/deliveries/user',
                meta: { requiresAuth: true },
                component:MyDelivery
                
            },
            {
                name:'Stock',
                path:'/stocks',
                meta: { requiresAuth: true },
                component:Stock
            },
            {
                name:'Property',
                path:'/properties',
                meta: { requiresAuth: true },
                component:Property
            },
            {
                name:'Dashboard',
                path:'/dashboard',
                meta: { requiresAuth: true },
                component:Dashboard
            },
            {
                name:'Measurement',
                path:'/measurements',
                meta: { requiresAuth: true },
                component:Measurement
            },
            {
                name:'Form',
                path:'/forms',
                meta: { requiresAuth: true },
                component:Form
            }
        ]
    },

    {
        name:'Login',
        path:'/login',
        component:Login,
        meta: { requiresAuth: false },
    },
    {
        name:'Add Delivery',
        path:'/delivery/add',
        component: () => import('../components/Pages/Delivery/AddDelivery.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Delivery IAR',
        path:'/delivery/iar/:id',
        component: () => import('../components/Pages/Delivery/GenerateIAR.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Update Delivery',
        path:'/delivery/update/:id',
        component: () => import('../components/Pages/Delivery/UpdateDelivery.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Notice of Delivery',
        path:'/delivery/notice',
        component: () => import('../components/Pages/Delivery/NoticeOfDelivery.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Add Stock Card',
        path:'/stock_card/add',
        component: () => import('../components/Pages/Stocks/AddStockCard.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Update Stock Card',
        path:'/stock_card/update/:id',
        component: () => import('../components/Pages/Stocks/UpdateStockCard.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Generate Stock Card',
        path:'/stock_card/generate/:id',
        component: () => import('../components/Pages/Stocks/GenerateStockCard.vue'),
        meta: { requiresAuth: true },
    },
    
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) =>  {
    const store = useAuthStore(); // Use the named import
    await store.fetchUser();

    store.fetchUser();
    
    if (to.meta.requiresAuth) {
        if (store.isAuthenticated) {
          next();
        } else {
          localStorage.removeItem('token')
          next({ name: 'Login' });
        }
    } 

    else if (to.name === 'Login' && store.isAuthenticated) {
        next({ name: 'Dashboard' });
    } 

    else {
        next();
    }

})

  
export default router;