<template>
    <AuthenticatedPage :pageTitle="'Welcome to your Dashboard'">
        <div v-if="store.getUser.assignment.employee_status_id === 1" class="w-full max-h-[90%] h-full flex justify-start items-center gap-4 p-4 font-lexend">
            <div class="w-2/3 max-h-full h-full flex flex-col justify-center items-center gap-4">
                <div class="w-full h-1/2 flex flex-col justify-center items-center gap-4 shadow-md shadow-slate-600 rounded-xl bg-white dashboard">
                    <span class="w-full text-2xl uppercase text-center font-noto font-black">Your Deliveries</span>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ delivery?.total }}</span>
                            <span class="font-light font-poppins">Total</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ delivery?.procured }}</span>
                            <span class="font-light font-poppins">Procurement</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ delivery?.donated }}</span>
                            <span class="font-light font-poppins">Donation</span>
                        </div>
                    </div>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-1/2 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ delivery?.this_week }}</span>
                            <span class="font-light font-poppins">This Week</span>
                        </div>
                        <div class="w-1/2 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ delivery?.this_month }}</span>
                            <span class="font-light font-poppins">This Month</span>
                        </div>
                    </div>
                </div>
                <div class="w-full h-1/2 flex flex-col justify-center items-center gap-4 shadow-md shadow-slate-600 rounded-xl bg-white dashboard">
                    <span class="w-full text-2xl uppercase text-center font-noto font-black">Your Section Stocks</span>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-2/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ stock?.total }}</span>
                            <span class="font-light font-poppins">Total</span>
                        </div>
                    </div>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ stock?.allocated }}</span>
                            <span class="font-light font-poppins">Allocated</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ stock?.allocating }}</span>
                            <span class="font-light font-poppins">Allocating</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">{{ stock?.to_allocate }}</span>
                            <span class="font-light font-poppins">For Allocation</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3 max-h-full h-full flex flex-col justify-center items-center gap-4">
                <div class="w-full h-full flex flex-col justify-start items-center gap-4 bg-white rounded-xl dashboard">
                    <span class="w-full text-2xl uppercase text-center font-noto font-black p-2 underline sticky top-0 bg-white rounded-t-xl">Your Properties</span>

                    <div class="w-[95%] h-full border-y flex flex-col justify-start items-start font-light gap-2 text-sm overflow-auto">
                        <span v-for="property in properties" class="w-full border-y p-2 bg-emerald-900/40 shadow-md shadow-slate-600">{{ property.particulars }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedPage>


  </template>

<script setup>
    import { ref, onMounted, computed } from 'vue';
    import AuthenticatedPage from '../PageLayouts/AuthenticatedPage.vue';
    import axios from '../../axios/axios.js';
    import { useAuthStore } from '../../stores/authStore.js';
    import { Block } from 'notiflix/build/notiflix-block-aio';

    const store = useAuthStore()

    const delivery = ref(null)
    const stock = ref(null)
    const properties = ref([])

    onMounted(() => {
        fetchDashboardData()
    })

    function fetchDashboardData(){
        Block.pulse('.dashboard', 'Loading, Please wait...', {
            fontFamily: 'Lexend Deca',
        });

        axios.get('/dashboard/user')
        .then(response => {
            delivery.value = response.data.delivery
            stock.value = response.data.stock
            properties.value = response.data.properties
        })
        .catch(error => {
            console.error(error);
        })
        .finally(() => {
            Block.remove('.dashboard', 1500);
        });
    }

  

</script>