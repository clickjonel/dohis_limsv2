<template>
    <AuthenticatedPage :pageTitle="'Welcome to your Dashboard'">
        <div class="w-full h-screen flex justify-start items-center gap-4 p-4 font-lexend">
            <div class="w-2/3 h-full flex flex-col justify-center items-center gap-4">
                <div class="w-full h-1/2 flex flex-col justify-center items-center gap-4 shadow-md shadow-slate-600 rounded-xl bg-white">
                    <span class="w-full text-2xl uppercase text-center font-noto font-black">Your Deliveries</span>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">Total</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">Procurement</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">Donation</span>
                        </div>
                    </div>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-1/2 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">This Week</span>
                        </div>
                        <div class="w-1/2 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">This Month</span>
                        </div>
                    </div>
                </div>
                <div class="w-full h-1/2 flex flex-col justify-center items-center gap-4 shadow-md shadow-slate-600 rounded-xl bg-white">
                    <span class="w-full text-2xl uppercase text-center font-noto font-black">Your Section Stocks</span>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-2/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">Total</span>
                        </div>
                    </div>
                    <div class="w-full h-1/3 flex justify-center items-center gap-4 px-4">
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">Allocated</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">Allocating</span>
                        </div>
                        <div class="w-1/3 h-full flex flex-col justify-center items-center shadow-md shadow-slate-600 p-2 gap-2 rounded-">
                            <span class="text-5xl font-black">10</span>
                            <span class="font-light font-poppins">For Allocation</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3 h-full flex flex-col justify-center items-center gap-4">
                <div class="w-full h-full flex justify-start items-start gap-4 bg-white rounded-xl">
                    <span class="w-full text-2xl uppercase text-center font-noto font-black p-2 underline">Your Properties</span>
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
    import VueApexCharts from 'vue3-apexcharts';
    import Dialog from 'primevue/dialog';

    const store = useAuthStore();

</script>