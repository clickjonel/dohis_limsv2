<template>
    <AuthenticatedPage pageTitle="Properties (as of January 2025)">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                   <Button @click="fetchProperties" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>

           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[30%] max-w-[30%]">Article</span>
                   <span class="min-w-[20%]">Cost</span>
                   <span class="min-w-[15%]">Acquisition Date</span>
                   <span class="min-w-[10%]">Status</span>
                   <span class="min-w-[15%]">Actions</span>
               </div>
               
               <div v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black">
                   <span class="min-w-[10%]">{{ property.property_no }}</span>
                   <span class="min-w-[30%] max-w-[30%] text-xs">{{ property.particulars }}</span>
                   <span class="min-w-[20%] text-xs">{{ property.unit_cost }}</span>
                   <span class="min-w-[15%]">{{ property.user.issuance_date }}</span>
                   <span class="min-w-[10%]">{{ property.status }}</span>
                   <div class="min-w-[15%] flex justify-center items-start gap-2">
                        <span v-if="!property.currentTransferRequest" @click="openTransferRequestModal(property)" title="Request to Transfer"><Icon icon="fluent:person-arrow-right-20-filled" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span>
                        <span v-else @click="openCurrentProperty(property)" title="View Status of Transfer Request"><Icon icon="solar:eye-broken" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                   </div>
               </div>
           </div>

       </div>

       <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchProperties"/>

   </AuthenticatedPage>

   <Dialog v-model:visible="transferRequestModal" modal header="Request this Property for Transfer" :style="{ width: '70rem',  fontFamily: 'Lexend Deca' }" @hide="clearTransferRequestForm">
       <div class="w-full flex flex-col justify-start items-start gap-4 bg-gray-200 p-4 text-black">

            <div class="w-full flex justify-start items-start gap-4">
                <FloatLabel class="w-1/2" variant="on">
                    <Select v-model="transferRequest.transfer_to" :options="users" :invalid="errors.transfer_to ? true : false" filter optionLabel="full_name" class="w-full">
                        <template #option="slotProps">
                            <div class="flex items-center font-lexend">
                                <div>{{ slotProps.option.full_name }}</div>
                            </div>
                        </template>
                    </Select>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Transfer To:</label>
                </FloatLabel>

                <FloatLabel variant="on" class="font-light w-1/2">
                    <InputText v-model="transferRequest.transfer_type" :invalid="errors.transfer_type ? true : false" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Transfer Type</label>
                </FloatLabel>
            </div>

            <div class="w-full flex justify-start items-start gap-4">
                <FloatLabel variant="on" class="font-light w-1/4">
                    <DatePicker v-model="transferRequest.date_requested" :invalid="errors.date_requested ? true : false" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Request Date</label>
                </FloatLabel>

                <FloatLabel variant="on" class="font-light w-3/4">
                    <InputText v-model="transferRequest.transfer_reason" :invalid="errors.transfer_reason ? true : false" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Reason for Transfer</label>
                </FloatLabel>

            </div>

            <div class="w-full flex justify-end items-start p-4">
                <Button @click="sendRequest" text="Send Request" buttonType="create" class="translate-y-2.5"/>
            </div>
       </div>
   </Dialog>

   <Dialog v-model:visible="currentPropertyModal" modal header="Property Transfer Request Status" :style="{ width: '70rem',  fontFamily: 'Lexend Deca' }">
       <div v-if="currentProperty.currentTransferRequest.status === 'PC Approved' " class="w-full flex flex-col justify-start items-start gap-4 bg-emerald-900/50 p-4 text-black shadow-slate-600 shadow-md">
            <FloatLabel variant="on" class="font-light w-full">
                <DatePicker v-model="currentProperty.currentTransferRequest.pc_request_approved_date" :invalid="errors.date_requested ? true : false" class="w-full" disabled/>
                <label class="font-poppins" style="font-weight: 300; font-size: small;">Approved</label>
            </FloatLabel>
            <FloatLabel variant="on" class="font-light w-full">
                <InputText v-model="currentProperty.currentTransferRequest.next_step"  class="w-full" disabled/>
                <label class="font-poppins" style="font-weight: 300; font-size: small;">Next Step for Transfer</label>
            </FloatLabel>
        </div>
        <div v-else-if="currentProperty.currentTransferRequest.status === 'PC Rejected' " class="w-full flex flex-col justify-start items-start gap-4 bg-red-900/50 p-4 text-black shadow-slate-600 shadow-md">
            <FloatLabel variant="on" class="font-light w-full">
                <DatePicker v-model="currentProperty.currentTransferRequest.pc_request_approved_date" class="w-full" disabled/>
                <label class="font-poppins" style="font-weight: 300; font-size: small;">Rejected</label>
            </FloatLabel>
            <FloatLabel variant="on" class="font-light w-full">
                <InputText v-model="currentProperty.currentTransferRequest.pc_request_rejection_reason"  class="w-full" disabled/>
                <label class="font-poppins" style="font-weight: 300; font-size: small;">Reason for Rejection of Request</label>
            </FloatLabel>
        </div>
        <div v-else class="w-full flex flex-col justify-start items-start gap-4 bg-blue-900/50 p-4 text-black shadow-slate-600 shadow-md">
            <InputText value="Pending Approval from the Property Custodian"  class="w-full" disabled/>
        </div>
   </Dialog>

</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import Input from '../../Form/Input.vue';
    import Button from '../../Button.vue';
    import axios from '../../../axios/axios';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import Dialog from 'primevue/dialog';
    import { Notify,Loading, Report } from 'notiflix';
    import Select from 'primevue/select';
    import InputText from 'primevue/inputtext';
    import FloatLabel from 'primevue/floatlabel';
    import InputNumber from 'primevue/inputnumber';
    import DatePicker from 'primevue/datepicker';
    import { useAuthStore } from '../../../stores/authStore';

    const router = useRouter();
    const properties = ref([]);
    const users = ref([]);
    const authStore = useAuthStore();
    

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

    var transferRequest = ref({
        requested_by:authStore.user.user_id,
        transfer_to:null,
        transfer_type:null,
        date_requested:'',
        transfer_reason:'',
        property_id:0,
    })

    var currentPropertyModal = ref(null)

    var errors = ref({})

    var transferRequestModal = ref(false);
    var currentProperty = ref(false)

   onMounted(() => {
       fetchProperties();
       fetchUserSelection();
   });


   function fetchProperties(){
       Loading.dots('Loading Data, Please Wait...',{
           clickToClose:false,
           fontFamily:'Lexend Deca'
       });
       
       axios.get('property/user',{
           params:{
                page:pagination.value.page,
                keyword:searchKeyword.value
           }
       })
       .then((response)=>{
           properties.value = response.data.properties
           pagination.value.total = response.data.total
           console.log(response.data)
       })
       .catch((error)=>{
           Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
           console.log(error.response.data)
       })
       .finally(()=>{
           Loading.remove()
       })
   }

   function handleNavigation(path){
      router.push({path:path})
   }

   function clearTransferRequestForm(){
         transferRequest.value = {
              requested_by:null,
              transfer_to:null,
              transfer_type:null,
              date_requested:'',
              transfer_reason:'',
              property_id:0,
         }
         transferRequestModal.value = false
   }
   
   function openTransferRequestModal(property){
       transferRequest.value.property_id = property.id
       transferRequestModal.value = true
   }

   function openCurrentProperty(property){
       currentProperty.value = property
       currentPropertyModal.value = true
       console.log(property)
   }

   function sendRequest(){
        Loading.dots('Updating Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.post('property/transfer_request/create',{
            transfer_to : transferRequest.value.transfer_to?.user_id,
            property_id : transferRequest.value.property_id,
            requested_by : transferRequest.value.requested_by,
            transfer_type : transferRequest.value.transfer_type,
            transfer_reason : transferRequest.value.transfer_reason,
            date_requested : transferRequest.value.date_requested,
            status : 'Created Request for Transfer',
        })
        .then((response)=>{
            Notify.success('Property transfer request has been sent for approval.',{fontFamily:'Lexend Deca',timeout: 1500})
            clearTransferRequestForm()
            fetchProperties()
        })
        .catch((error)=>{
            errors.value = error.response.data.errors
            Notify.failure('Fill up fields first',{fontFamily:'Lexend Deca',timeout: 1500})
            console.log(error.response.data.errors)
        })
        .finally(()=>{
            Loading.remove()
        })
        // console.log(transferRequest.value.transfer_to.user_id)
   }

    function fetchUserSelection(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('user/selection',{
            params:{
                
            }
        })
        .then((response)=>{
            users.value = response.data.users
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }


</script>