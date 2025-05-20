<template>

    
    <div class="w-full flex flex-col justify-start items-start p-2 font-lexend">
        <div class="w-full flex justify-between items-center my-4 print:hidden">
            <span class="w-full text-2xl font-poppins font-bold uppercase mb-4">User Inventory</span>
            <PrimevueButton @click="print" label="Print" class="font-lexend uppercase text-xs"/>
        </div>
        <div class="w-full flex flex-col justify-start items-start gap-2 my-4 print:hidden">
            <FloatLabel class="w-full" variant="on">
                <MultiSelect display="chip" size="medium" v-model="selected_users" :options="users" optionLabel="full_name" optionValue="user_id" filter class="w-full" :overlayStyle="{ backgroundColor: 'lightgray',fontFamily:'Lexend Deca'}"/>
                <label>Select User/s</label>
            </FloatLabel>
            <PrimevueButton @click="fetchUserProperties" label="Get User Properties" severity="info" class="w-fullfont-lexend uppercase text-sm"/>
        </div>

        <div v-for="user in user_properties" class="w-full flex flex-col justify-start items-start break-after-page">
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
            <div v-for="(property,index) in user.properties" v-bind:key="property.property_no" class="w-full flex justify-start items-stretch font-light divide-x border-x border-b text-xs text-center">
                <span class="min-w-[5%] max-w-[5%]">{{index+1}}</span>
                <span class="min-w-[15%] max-w-[15%]">{{ property.property.property_no }}</span>
                <span class="min-w-[10%] max-w-[10%]">{{ property.issuance_date }}</span>
                <span class="min-w-[10%] max-w-[10%]">{{ property.property.measurement.name }}</span>
                <span class="min-w-[5%] max-w-[5%]">1</span>
                <span class="min-w-[30%] max-w-[30%]">{{ property.property.particulars }}</span>
                <span class="min-w-[10%] max-w-[10%]">{{ property.property.unit_cost }}</span>
                <span class="min-w-[15%] max-w-[15%]">{{ property.property.remarks }}</span>
            </div>
            <div class="w-full flex justify-start items-stretch font-light divide-x border-x border-b text-xs text-center">
                <span class="min-w-[5%]"></span>
                <span class="min-w-[15%]"></span>
                <span class="min-w-[10%]"></span>
                <span class="min-w-[10%]"></span>
                <span class="min-w-[5%]"></span>
                <span class="min-w-[30%]"></span>
                <span class="min-w-[10%] max-w-[10%] font-bold">{{ user.property_total_cost }}</span>
                <span class="min-w-[15%]"></span>
            </div>
        </div>


    </div>
 </template>
 
 <script setup> 
    import { ref,onMounted  } from 'vue';
    import { useRouter,useRoute } from 'vue-router';
    import { useAuthStore } from '../../../stores/authStore';
    import PrimevueButton from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import FloatLabel from 'primevue/floatlabel';
    import Select from 'primevue/select';
    import useApi from '../../../composables/api_calls';

     const route = useRoute()
     const router = useRouter()
     const store = useAuthStore()
     const { fetchRequest } = useApi()

    var selected_users = ref([])

    var users = ref([])

    var user_properties = ref(null)
    var total = ref(0)

     onMounted(()=>{
        fetchUsers()
     })

    async function fetchUsers(){
        var response = await fetchRequest('user/selection',{employee_status_id:1})
        response.toast()
        if(response.data.users){
            users.value = response.data.users
        }
       
    }

   async function fetchUserProperties(){
        var response = await fetchRequest('property/inventory/user/find',{user_ids:selected_users.value})
        response.toast()
        if(response.data.users){
            user_properties.value = response.data.users
            console.log(response.data)
        }
       
    }

    function print(){
        window.print()
    }




 
 </script>
