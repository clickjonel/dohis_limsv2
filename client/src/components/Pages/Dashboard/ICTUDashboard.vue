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