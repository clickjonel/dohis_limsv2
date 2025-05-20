<template>

    
    <div class="w-full flex flex-col justify-start items-start p-2 font-lexend">
        <div class="w-full flex justify-between items-center my-4 print:hidden">
            <span class="w-full text-2xl font-poppins font-bold uppercase mb-4">User Inventory</span>
            <PrimevueButton @click="print" label="Print" class="font-lexend uppercase text-xs"/>
        </div>
        <div class="w-full flex justify-start items-start gap-2 my-4 print:hidden">
            <FloatLabel class="w-full" variant="on">
                <Select display="chip" size="small" v-model="selected_user" :options="users" optionLabel="full_name" optionValue="user_id" filter class="w-full" :overlayStyle="{ backgroundColor: 'lightgray',fontFamily:'Lexend Deca'}" @change="fetchUserProperties"/>
                <label>Select User</label>
            </FloatLabel>
        </div>

        <div class="w-full flex flex-col justify-start items-center font-light text-base my-4">
            <span class="w-full text-left">Name of Employee: <span class="font-semibold uppercase">{{ user?.full_name }}</span></span>
            <span class="w-full text-left">Position: <span class="font-semibold uppercase">{{ user?.position }}</span></span>
        </div>

        <div class="w-full flex justify-start items-stretch uppercase font-medium divide-x border text-xs text-center">
            <span class="w-[5%]">Item No.</span>
            <span class="w-[15%]">Property No.</span>
            <span class="w-[10%]">Issuance Date.</span>
            <span class="w-[10%]">Unit</span>
            <span class="w-[5%] break-words">Quantity</span>
            <span class="w-[30%]">Particulars</span>
            <span class="w-[10%]">Unit Cost</span>
            <span class="w-[15%]">Remarks</span>
        </div>
        <div v-for="(property,index) in properties" v-bind:key="property.property_no" class="w-full flex justify-start items-stretch font-light divide-x border-x border-b text-xs text-center">
            <span class="min-w-[5%] max-w-[5%]">{{index+1}}</span>
            <span class="min-w-[15%] max-w-[15%]">{{ property.property_no }}</span>
            <span class="min-w-[10%] max-w-[10%]">{{ property.user.issuance_date }}</span>
            <span class="min-w-[10%] max-w-[10%]">{{ property.measurement.name }}</span>
            <span class="min-w-[5%] max-w-[5%]">1</span>
            <span class="min-w-[30%] max-w-[30%]">{{ property.particulars }}</span>
            <span class="min-w-[10%] max-w-[10%]">{{ property.unit_cost }}</span>
            <span class="min-w-[15%] max-w-[15%]">{{ property.remarks }}</span>
        </div>
        <div class="w-full flex justify-start items-stretch font-light divide-x border-x border-b text-xs text-center">
            <span class="min-w-[5%]"></span>
            <span class="min-w-[15%]"></span>
            <span class="min-w-[10%]"></span>
            <span class="min-w-[10%]"></span>
            <span class="min-w-[5%]"></span>
            <span class="min-w-[30%]"></span>
            <span class="min-w-[10%] max-w-[10%] font-bold">{{ total }}</span>
            <span class="min-w-[15%]"></span>
        </div>
    </div>
 </template>
 
 <script setup> 
    import { ref,onMounted,computed  } from 'vue';
    import { useRouter,useRoute } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import InputText from 'primevue/inputtext';
    import Button from '../../Button.vue';
    import axios from '../../../axios/axios';
    import Dialog from 'primevue/dialog';
    import { useAuthStore } from '../../../stores/authStore';
    import PrimevueButton from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import FloatLabel from 'primevue/floatlabel';
    import Select from 'primevue/select';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import DatePicker from 'primevue/datepicker';
    import useApi from '../../../composables/api_calls';
    import PropertySelection from '../../selections/PropertySelection.vue';
    import { showReport } from '../../../composables/notiflix';
    import { showToast } from '../../../composables/notiflix';

     const route = useRoute()
     const router = useRouter()
     const store = useAuthStore()
     const { fetchRequest } = useApi()

    var selected_user = ref(0)

    var users = ref([])
    var properties = ref([])

    var user = ref(null)
    var total = ref(0)

     onMounted(()=>{
        fetchUsers()
     })

    async function fetchUsers(){
        var response = await fetchRequest('user/selection',{})
        response.toast()
        if(response.data.users){
            users.value = response.data.users
        }
       
    }

   async function fetchUserProperties(){
        var response = await fetchRequest('property/inventory/user/find',{user_id:selected_user.value})
        response.toast()
        if(response.data.properties){
            properties.value = response.data.properties
            user.value = response.data.user
            total.value = response.data.total
            console.log(response.data)
        }
       
    }

    function print(){
        window.print()
    }




 
 </script>
