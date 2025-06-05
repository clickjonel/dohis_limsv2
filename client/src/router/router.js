import { createRouter, createWebHistory } from 'vue-router'

import Login from '../components/Login.vue';
import AuthenticatedLayout from '../components/PageLayouts/AuthenticatedLayout.vue';
import { useAuthStore } from '../stores/authStore.js';
import Measurement from '../components/Pages/Measurement/Measurement.vue';
import MyDelivery from '../components/Pages/Delivery/MyDelivery.vue';
import MyProperty from '../components/Pages/Property/MyProperty.vue';
import DeliveryPage from '../components/Pages/Delivery/DeliveryPage.vue';
import DeliveryList from '../components/Pages/Delivery/DeliveryList.vue';
import StockPage from '../components/Pages/Stocks/StockPage.vue';
import StockList from '../components/Pages/Stocks/StockList.vue';
import MyStocks from '../components/Pages/Stocks/MyStocks.vue';
import PropertyPage from '../components/Pages/Property/PropertyPage.vue';
import PropertyList from '../components/Pages/Property/PropertyList.vue';
import DashboardPage from '../components/Pages/Dashboard/DashboardPage.vue';
import SCMUDashboard from '../components/Pages/Dashboard/SCMUDashboard.vue';
import MyDashboard from '../components/Pages/Dashboard/MyDashboard.vue';
import PropertyInspectionRequestList from '../components/Pages/PropertyInspectionRequests/PropertyInspectionRequestList.vue';
import MyPropertyInspectionRequest from '../components/Pages/PropertyInspectionRequests/MyPropertyInspectionRequest.vue';
import PropertyInspectionRequestPage from '../components/Pages/PropertyInspectionRequests/PropertyInspectionRequestPage.vue';


const routes = [
    {
        name:'Admin',
        path:'/',
        component:AuthenticatedLayout,
        meta: { requiresAuth: true },
        children:[
            {
                name:'DeliveryPage',
                path:'/deliveries',
                meta: { 
                    requiresAuth: true,
                    roles:[],
                },
                children:[
                     {
                        name:'Deliveries',
                        path:'/deliveries',
                        meta: { 
                            requiresAuth: true,
                            roles:['supply_officer','ICT','superadmin'],
                        },
                        component:DeliveryList
                        
                    },
                    {
                        name:'My Delivery',
                        path:'/deliveries/user',
                        meta: { 
                            requiresAuth: true,
                            roles:['permanent'],
                        },
                        component:MyDelivery
                        
                    },
                ],
                component:DeliveryPage
                
            },
             {
                name:'DashboardPage',
                path:'/dashboard',
                meta: { 
                    requiresAuth: true,
                    roles:[],
                },
                children:[
                     {
                        name:'Dashoard',
                        path:'/dashboard',
                        meta: { 
                            requiresAuth: true,
                            roles:['supply_officer','ICT','superadmin'],
                        },
                        component:SCMUDashboard
                        
                    },
                    {
                        name:'My Dashboard',
                        path:'/dashboard/user',
                        meta: { 
                            requiresAuth: true,
                            roles:['permanent'],
                        },
                        component:MyDashboard
                        
                    },
                ],
                component:DashboardPage
                
            },
            {
                name:'Stock',
                path:'/stocks',
                meta: { 
                    requiresAuth: true,
                    roles:[],
                },
                children:[
                     {
                        name:'Stocks',
                        path:'/stocks',
                        meta: { 
                            requiresAuth: true,
                            roles:['supply_officer','ICT','superadmin'],
                        },
                        component:StockList
                        
                    },
                    {
                        name:'My Stocks',
                        path:'/stocks/section',
                        meta: { 
                            requiresAuth: true,
                            roles:['permanent'],
                        },
                        component:MyStocks
                        
                    },
                ],
                component:StockPage
            },
            {
                name:'Property',
                path:'/properties',
                meta: { 
                    requiresAuth: true,
                    roles:[],

                },
                children:[
                     {
                        name:'Properties',
                        path:'/properties',
                        meta: { 
                            requiresAuth: true,
                            roles:['supply_officer','ICT','superadmin'],
                        },
                        component:PropertyList
                        
                    },
                    {
                        name:'My Properties',
                        path:'/properties/user',
                        meta: { 
                            requiresAuth: true,
                            roles:['permanent'],
                        },
                        component:MyProperty
                        
                    },
                ],
                component:PropertyPage
            },
            {
                name:'Property Inspection Request',
                path:'/property_inspection_request',
                meta: { 
                    requiresAuth: true,
                    roles:[],
                },
                children:[
                     {
                        name:'Property Inspection Requests',
                        path:'/property_inspection_requests',
                        meta: { 
                            requiresAuth: true,
                            roles:['supply_officer','ICT','superadmin'],
                        },
                        component:PropertyInspectionRequestList
                        
                    },
                    {
                        name:'My Property Inspection Requests',
                        path:'/property_inspection_requests/user',
                        meta: { 
                            requiresAuth: true,
                            roles:['permanent'],
                        },
                        component:MyPropertyInspectionRequest
                        
                    },
                ],
                component:PropertyInspectionRequestPage
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
    {
        name:'View Delivery',
        path:'/delivery/view/:id',
        component: () => import('../components/Pages/Delivery/ViewDelivery.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Add Property',
        path:'/property/add',
        component: () => import('../components/Pages/Property/AddProperty.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Add Stock Transaction',
        path:'/stock/transaction/issue/:id',
        component: () => import('../components/Pages/Stocks/IssueStocks.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'Transfer Properties',
        path:'/properties/transfer',
        component: () => import('../components/Pages/Property/TransferProperties.vue'),
        meta: { requiresAuth: true },
    },
    {
        name:'View Property',
        path:'/property/view/:id',
        component: () => import('../components/Pages/Property/ViewProperty.vue'),
        meta: { requiresAuth: false },
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