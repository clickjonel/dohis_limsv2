<template>
     <!-- Sidebar -->
     <div class="min-w-[15%] max-w-[15%] max-h-[98%] min-h-[98%] flex flex-col justify-start items-center m-2 bg-white rounded-lg shadow-md shadow-slate-400 overflow-y-scroll">
        <div class="w-full flex flex-col justify-center items-center bg-white p-2">
             <span class="w-full text-center text-xl font-semibold font-lexend">Main Navigation</span>
        </div>

        <div class="w-full flex flex-col justify-start items-center font-poppins px-2 mt-2">
            <div v-for="child in routes" class="w-full rounded-md">
                <Panel v-if="child.children" :header="child.name" :toggleable="true" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span v-for="link in child.children" @click="handleNavigation(link.path)" class="w-full text-left p-2 rounded-lg" :class="link.name === route.name ? 'bg-emerald-200' : 'hover:bg-emerald-200'">{{link.name}}</span>
                    </div>
                </Panel>
                <Panel v-else :header="child.name" class="w-full text-black text-sm">
                    <div class="flex flex-col justify-start items-center gap-2">
                        <span @click="handleNavigation(child.path)" class="w-full text-left p-2 rounded-lg" :class="child.name === route.name ? 'bg-emerald-200' : 'hover:bg-emerald-200'">{{child.name}}</span>
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
    const routes = router.getRoutes().find(routeRecord => routeRecord.name === 'Admin').children
   
    const store = useAuthStore();


    onMounted(()=>{
        // routes.value = .filter(route => route.is_parent)
        // console.log(routes.value.children)
    })

    function handleNavigation(path){
        router.push({path:path})
        console.log(path)
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

