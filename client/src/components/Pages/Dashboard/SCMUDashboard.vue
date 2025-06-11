<template>
    <AuthenticatedPage pageTitle="Deliveries">
        <div class="w-full min-h-[100%] flex flex-col justify-start items-center gap-4 font-poppins p-2 overflow-y-scroll">
            <div class="w-full h-full flex flex-col justify-start items-start gap-4">
                <div class="w-full flex justify-start items-start gap-2">
                    <Card class="w-full h-full" :style="{backgroundColor:'#E7EFC7'}">
                        <template #title>Welcome Back</template>
                        <template #content>
                            <div class="w-full flex flex-col justify-start items-start gap-4">
                                <span class="text-5xl font-bold">{{ store.user.nickname }}!</span>
                                <!-- <span class="mt-4 text-sm">No Notifications so Far</span> -->
                            </div>
                        </template>
                    </Card>
                </div>

                <div class="w-full flex flex-col justify-start items-start p-2">
                   <div class="w-full flex justify-start items-start gap-2 bg-[#E7EFC7] p-2 font-semibold uppercase text-center">
                        <span class="w-1/3">Category</span>
                        <span class="w-1/3">Total Count</span>
                        <span class="w-1/3">Total Cost</span>
                   </div>
                    <div v-for="category in categories" v-bind:key="category.name" class="w-full flex justify-start items-start gap-2 p-2 uppercase text-center border-b bg-[#ECFAE5]">
                        <span class="w-1/3 capitalize">{{ category.name }}</span>
                        <span class="w-1/3">{{ category.properties_count }}</span>
                        <span class="w-1/3">{{ category.properties_sum_unit_cost }}</span>
                   </div>
                </div>

                <div class="w-full flex justify-start items-start gap-2 p-2">
                    <Card class="w-full h-full" :style="{backgroundColor:'#E7EFC7'}">
                        <template #title>Properties</template>
                        <template #content>
                            <div class="w-full flex flex-col justify-start items-start gap-4">
                                <span class="text-5xl font-bold">{{ counts.properties }}</span>
                                <!-- <span class="mt-4 text-sm">No Notifications so Far</span> -->
                            </div>
                        </template>
                    </Card>
                    <Card class="w-full h-full" :style="{backgroundColor:'#E7EFC7'}">
                        <template #title>Deliveries</template>
                        <template #content>
                            <div class="w-full flex flex-col justify-start items-start gap-4">
                                <span class="text-5xl font-bold">{{ counts.deliveries }}</span>
                                <!-- <span class="mt-4 text-sm">No Notifications so Far</span> -->
                            </div>
                        </template>
                    </Card>
                    <Card class="w-full h-full" :style="{backgroundColor:'#E7EFC7'}">
                        <template #title>Stocks</template>
                        <template #content>
                            <div class="w-full flex flex-col justify-start items-start gap-4">
                                <span class="text-5xl font-bold">{{ counts.stocks }}</span>
                                <!-- <span class="mt-4 text-sm">No Notifications so Far</span> -->
                            </div>
                        </template>
                    </Card>
                </div>
            </div>
        </div>     
    </AuthenticatedPage>
</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Card from 'primevue/card';
    import { useAuthStore } from '../../../stores/authStore';
    import useApi from '../../../composables/api_calls';

    const store = useAuthStore()
    const { fetchRequest } = useApi()

    const categories = ref([])
    const counts = ref({})

    onMounted( async ()=>{
        await fetchDashboardData()
    })

    async function fetchDashboardData(){
       var response = await fetchRequest('dashboard',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            categories.value = response.data.property_categories
            counts.value = response.data.counts
        }
    }

</script>