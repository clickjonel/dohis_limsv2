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
import MyStocks from '../components/Pages/Stocks/MyStocks.vue';
import MyProperty from '../components/Pages/Property/MyProperty.vue';
import MyDashboard from '../components/Pages/MyDashboard.vue';
import PreInspection from '../components/Pages/PreinspectionRequest/PreInspection.vue';
import MyPreinspectionRequest from '../components/Pages/PreinspectionRequest/MyPreinspectionRequest.vue';

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
                name:'My Stock',
                path:'/stocks/user',
                meta: { requiresAuth: true },
                component:MyStocks
                
            },
            {
                name:'Property',
                path:'/properties',
                meta: { requiresAuth: true },
                component:Property
            },
            {
                name:'My Property',
                path:'/properties/user',
                meta: { requiresAuth: true },
                component:MyProperty
            },
            {
                name:'Dashboard',
                path:'/dashboard',
                meta: { requiresAuth: true },
                component:Dashboard
            },
            {
                name:'My Dashboard',
                path:'/dashboard/user',
                meta: { requiresAuth: true },
                component:MyDashboard
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
            },
            {
                name:'Preinspection Request',
                path:'/preinspection_requests',
                meta: { requiresAuth: true },
                component:PreInspection
            },
            {
                name:'My Preinspection Request',
                path:'/preinspection_requests/user',
                meta: { requiresAuth: true },
                component:MyPreinspectionRequest
            },
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
        name:'Update Property',
        path:'/property/update/:id',
        component: () => import('../components/Pages/Property/UpdateProperty.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Generate Stock Card',
        path:'/stock_card/generate/:id',
        component: () => import('../components/Pages/Stocks/GenerateStockCard.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Create Item Allocation List',
        path:'/item/allocation_list/:id',
        component: () => import('../components/Pages/Delivery/CreateAllocationList.vue'),
        meta: { requiresAuth: true },
    },

    {
        name:'Create ITR',
        path:'/property/itr/create',
        component: () => import('../components/Pages/Property/CreateITR.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Create WMR',
        path:'/property/wmr/create',
        component: () => import('../components/Pages/Property/CreateWMR.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Create RIS',
        path:'/property/ris/create',
        component: () => import('../components/Pages/Property/CreateRIS.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Create User Property Report',
        path:'/property/user',
        component: () => import('../components/Pages/Property/CreateUserInventoryReport.vue'),
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