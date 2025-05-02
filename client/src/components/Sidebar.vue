<template>
     <!-- Sidebar -->
     <div class="min-w-[15%] h-full flex flex-col justify-start items-center p-2 font-lexend gap-4">
        <span class="w-full text-center text-2xl font-bold font-noto uppercase border-b animate-pulse border">Navigate Here</span>

        <div class="w-full min-h-[80%] flex flex-col justify-start items-center py-4 px-2 gap-4">
            <!-- <Button @click="handleNavigation('Dashboard')" :text="'Dashboard'" :buttonType="'navigation'" :class="route.name === 'Dashboard' ? 'w-full bg-blue-800' : 'w-full' "/> -->
            <Button v-if="store.hasRole('user')" @click="handleNavigation('My Dashboard')" :text="'My Dashboard'" :buttonType="'navigation'" :icon="'mdi:truck-delivery'" :class="route.name === 'My Dashboard' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('supply_officer') || store.hasRole('superadmin')" @click="handleNavigation('Delivery')" :text="'Deliveries'" :buttonType="'navigation'" :icon="'mdi:truck-delivery'" :class="route.name === 'Delivery' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('supply_officer') || store.hasRole('superadmin')" @click="handleNavigation('Stock')" :text="'Stocks'" :buttonType="'navigation'" :icon="'material-symbols:stacks'" :class="route.name === 'Stock' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('supply_officer') || store.hasRole('superadmin')" @click="handleNavigation('Property')" :text="'Properties'" :buttonType="'navigation'" :icon="'hugeicons:property-new'" :class="route.name === 'Property' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('supply_officer') || store.hasRole('superadmin')" @click="handleNavigation('Measurement')" :text="'Measurements'" :buttonType="'navigation'" :icon="''" :class="route.name === 'Measurement' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('supply_officer') || store.hasRole('superadmin')" :text="'Warehouses'" :buttonType="'navigation'" :icon="''" :class="route.name === 'Warehouse' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('supply_officer') || store.hasRole('superadmin')" :text="'Calendar'" :buttonType="'navigation'" :icon="''" :class="route.name === 'Calendar' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('permanent') || store.hasRole('superadmin')" @click="handleNavigation('My Delivery')" :text="'My Deliveries'" :buttonType="'navigation'" :icon="'mdi:truck-delivery'" :class="route.name === 'My Delivery' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('permanent') || store.hasRole('superadmin')" @click="handleNavigation('My Stock')" :text="'My Stocks'" :buttonType="'navigation'" :icon="'bi:boxes'" :class="route.name === 'My Stock' ? 'w-full bg-blue-800' : 'w-full' "/>
            <Button v-if="store.hasRole('permanent') || store.hasRole('superadmin')" @click="handleNavigation('My Property')" :text="'My Properties'" :buttonType="'navigation'" :icon="'bi:boxes'" :class="route.name === 'My Property' ? 'w-full bg-blue-800' : 'w-full' "/>
            <!-- <Button v-if="store.hasRole('permanent')" @click="handleNavigation('Form')" :text="'Forms'" :buttonType="'navigation'" :icon="'mdi:document-sign'" :class="route.name === 'Calendar' ? 'w-full bg-blue-800' : 'w-full' "/> -->
            
        </div>

        <div class="w-full min-h-[10%] flex justify-center items-center">
            <Button @click="confirmLogout" :text="'Logout'" :buttonType="'info'"/>
        </div>

    </div>
</template>



<script setup>
    import { ref } from 'vue';
    import Button from './Button.vue';
    import { useRoute,useRouter } from 'vue-router';
    import axios from '../axios/axios.js';
    import { Confirm, Notify } from 'notiflix';
    import { useAuthStore } from '../stores/authStore.js';
   
    const route = useRoute();
    const router = useRouter();

    const store = useAuthStore();
    console.log(store.roles)

    function handleNavigation(name){
        router.push({name:name})
    }

    function confirmLogout(){
        Confirm.show(
                'Confirm Logout',
                'Are you sure you want to logout?',
                'Yes',
                'No',
            () => {
                handleLogout()
            },
            
            () => {
                Notify.success('Logout Cancelled')
            },
        );
    }

    function handleLogout(){
       

        axios.post('logout')
        .then((response) => {
            if (response.data.status) {
                Notify.success('Logout Success')
                localStorage.removeItem('token');
                store.clearUser()
                router.push({ path: '/login' });
            }
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            // Any final actions
        });
        
    }

</script>

