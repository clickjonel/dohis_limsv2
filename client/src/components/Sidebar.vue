<template>
     <!-- Sidebar -->
     <div class="min-w-[15%] max-w-[15%] max-h-[98%] min-h-[98%] flex flex-col justify-start items-center m-2 bg-white rounded-lg shadow-md shadow-slate-400 overflow-y-scroll">
        <div class="w-full flex flex-col justify-center items-center bg-white p-2">
             <span class="w-full text-center text-xl font-semibold font-lexend">Main Navigation</span>
        </div>

        <div class="w-full flex flex-col justify-start items-center font-poppins px-2 mt-2">
            <!-- <div v-for="child in routes" class="w-full rounded-md">
                <Panel v-if="child.children" :header="child.name" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-for="link in child.children" @click="handleNavigation(link.path)" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="link.name === route.name ? 'bg-emerald-200' : 'hover:bg-emerald-200'">{{link.name}}</span>
                    </div>
                </Panel>
                <Panel v-else :header="child.name" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span @click="handleNavigation(child.path)" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="child.name === route.name ? 'bg-emerald-200' : 'hover:bg-emerald-200'">{{child.name}}</span>
                    </div>
                </Panel>
            </div> -->
            <div class="w-full rounded-md">
                <Panel header="Dashboard" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-if="checkRole('superadmin') || checkRole('supply_officer')" class="w-full text-left p-2 rounded-lg cursor-pointer">SCMU Dashboard</span>
                        <span v-if="checkRole('permanent')" @click="handleNavigation('/dashboard/user')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'My Dashboard' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">My Dashboard</span>
                    </div>
                </Panel>
            </div>
            <div class="w-full rounded-md">
                <Panel header="Deliveries" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-if="checkRole('superadmin') || checkRole('supply_officer')" @click="handleNavigation('/deliveries')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'Deliveries' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">Delivery List</span>
                        <span v-if="checkRole('permanent')" @click="handleNavigation('/deliveries/user')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'My Delivery' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">My Deliveries</span>
                    </div>
                </Panel>
            </div>
            <div class="w-full rounded-md">
                <Panel header="Stocks" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-if="checkRole('superadmin') || checkRole('supply_officer')" @click="handleNavigation('/stocks')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'Stocks' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">Stocks List</span>
                        <span v-if="checkRole('permanent')" @click="handleNavigation('/stocks/section')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'My Stocks' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">My Stocks</span>
                    </div>
                </Panel>
            </div>
            <div class="w-full rounded-md">
                <Panel header="Properties" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-if="checkRole('superadmin') || checkRole('supply_officer')" @click="handleNavigation('/properties')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'Properties' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">Properties List</span>
                        <span v-if="checkRole('permanent')" @click="handleNavigation('/properties/user')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'My Properties' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">My Properties</span>
                    </div>
                </Panel>
            </div>
            <div class="w-full rounded-md">
                <Panel header="Preinspection" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-if="checkRole('superadmin') || checkRole('supply_officer')" @click="handleNavigation('/preinspection_requests')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'Preinspection Requests' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">Preinspection Requests List</span>
                        <span v-if="checkRole('permanent')" @click="handleNavigation('/preinspection_requests/user')" class="w-full text-left p-2 rounded-lg cursor-pointer" :class="route.name === 'My Preinspection Requests' ? 'bg-emerald-200' : 'hover:bg-emerald-200'">My Preinspection Requests</span>
                    </div>
                </Panel>
            </div>
            
        </div>
    </div>
</template>



<script setup>
    import { ref,onMounted } from 'vue';
    import Button from './Button.vue';
    import { useRoute,useRouter } from 'vue-router';
    import axios from '../axios/axios.js';
    import { Confirm, Notify } from 'notiflix';
    import { useAuthStore } from '../stores/authStore.js';
    import PrimevueButton from 'primevue/button';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import PanelMenu from 'primevue/panelmenu';
    import Fieldset from 'primevue/fieldset';
    import Menu from 'primevue/menu';
    import SplitButton from 'primevue/splitbutton';
    import Panel from 'primevue/panel';

   
    const route = useRoute();
    const router = useRouter();
    const routes = ref([])
   
    const store = useAuthStore();


    onMounted(()=>{
        console.log(store.roles)
    })

    function handleNavigation(path){
        router.push({path:path})
        console.log(path)
    }

    function checkRole(role){
        return store.hasRole(role)
    }


</script>

<style scoped>
   .p-panel {
        border: none;
        /* border-radius: var(--p-panel-border-radius);
        background: var(--p-panel-background);
        color: var(--p-panel-color); */
    }
</style>

