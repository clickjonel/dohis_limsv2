<template>

    <!-- <main class="w-full min-h-screen h-screen flex justify-start items-center bg-[url('./assets/bg-image-honeycomb.png')] bg-cover bg-center bg-no-repeat gap-4"> -->
    <main class="w-full min-h-screen h-screen flex flex-col justify-start items-center bg-gray-200">
        <div class="w-full min-h-[100px] max-h-[100px] flex justify-between items-center bg-white shadow-md font-poppins border-b">
            <div class="flex justify-start items-center gap-2 p-4">
                <img src="../../assets//doh_logo.png" alt="" class="size-[80px]">
                <span class="text-2xl font-semibold">LIMS | Logistics and Inventory Management System</span>
            </div>
            <div class="flex justify-center items-center gap-2">
                <div @click="toggleProfilePopover" class="flex justify-center items-center gap-2 cursor-pointer p-4 rounded-lg hover:bg-emerald-200">
                    <img :src="`http://192.168.224.24/dohis/image_profiles/${store.user.image}`" alt="" class="size-[50px] rounded-full border">
                    <span class="font-medium">{{ store.user.nickname }}</span>
                </div>
                <Popover ref="profilePropover" :style="{ fontFamily: 'Poppins',width:'200px' }">
                    <div class="flex flex-col gap-4 font-poppins">
                       <span @click="confirmLogout" class="text-base cursor-pointer hover:bg-red-200 px-4 py-2 rounded-full">Logout user</span>
                    </div>
                </Popover>
            </div>

        </div>

        <div class="w-full h-full flex justify-center items-center overflow-y-scroll p-2 gap-2">
            <Sidebar></Sidebar>
            <RouterView/>
        </div>

   </main>

</template>

<script setup>
    import { ref } from 'vue'
    import { RouterView } from 'vue-router';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import Popover from 'primevue/popover';
    import Sidebar from '../Sidebar.vue'
    import { useAuthStore } from '../../stores/authStore';
    import { showConfirm } from '../../composables/notiflix';
    import useApi from '../../composables/api_calls';
    import { useRoute,useRouter } from 'vue-router';

    const store = useAuthStore();
    const route = useRoute();
    const router = useRouter();

    const profilePropover = ref()

    const { postRequest } = useApi()


    const toggleProfilePopover = (event) => {
        profilePropover.value.toggle(event);
    }

    const confirmLogout = () => {
        showConfirm(
            'Logout',
            'Are you sure you want to logout?',
            'Logout',
            'Cancel',
            handleLogout
        )
    }

    const handleLogout = async () => {
        var response = await postRequest('logout',{})
        response.toast()
        if(response.data.status){
            localStorage.removeItem('token');
            store.clearUser()
            router.push({ path: '/login' });
        }
    }

</script>