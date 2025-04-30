<template>
    <AuthenticatedPage pageTitle="Property Transfer Requests">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[15%]">Requested By</span>
                    <span class="min-w-[15%]">Transfer To</span>
                    <span class="min-w-[10%]">Date</span>
                    <span class="min-w-[25%]">Reason</span>
                    <span class="min-w-[10%]">Status</span>
                    <span class="min-w-[10%]">Action</span>
               </div>
               
               <div v-for="request in requests" v-bind:key="request.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-xs bg-white/50 hover:bg-emerald-400 text-black">
                    <span class="min-w-[10%]">{{ request.property.property_no }}</span>
                    <span class="min-w-[15%]">{{ request.requested_by.full_name }}</span>
                    <span class="min-w-[15%]">{{ request.transfer_to.full_name }}</span>
                    <span class="min-w-[10%]">{{ request.date_requested }}</span>
                    <span class="min-w-[25%]">{{ request.transfer_reason }}</span>
                    <span class="min-w-[10%] max-w-[10%]">{{ request.status }}</span>
                    <!-- if request is created and waiting for approval of the property custodian -->
                    <div v-if="store.hasRole('property_custodian') || store.hasRole('superadmin') && request.pc_request_approved === null" class="w-full flex justify-start items-center gap-2 text-[10px]">
                        <span @click="confirmApprovalOfPC(request.id)" class="p-1 bg-emerald-900 text-white shadow-md shadow-slate-600 cursor-pointer">Approve Request</span>
                        <span @click="confirmRejectionOfPC(request.id)" class="p-1 bg-red-900 text-white shadow-md shadow-slate-600 cursor-pointer">Reject Request</span>
                    </div>

                    <!-- if request is rejected by the property custodian -->
                    <div v-if="request.status === 'PC Rejected'" class="w-full flex justify-start items-center gap-2 text-xs">
                        <span class="w-full p-1 bg-red-900 text-white shadow-md shadow-slate-600 cursor-pointer">Request Rejected</span>
                    </div>

                    <!-- if request is approved by property custodian and needs approval/rejection of division head -->
                    <div v-if="store.hasRole('division_chief-approve_ptr') | store.hasRole('superadmin') && request.status === 'PC Approved'" class="w-full flex justify-start items-center gap-2 text-[10px]">
                        <span  @click="confirmApprovalOfDC(request.id)" class="p-1 bg-emerald-900 text-white shadow-md shadow-slate-600 cursor-pointer">Approve Transfer</span>
                        <span  @click="confirmRejectionOfDC(request.id)" class="p-1 bg-red-900 text-white shadow-md shadow-slate-600 cursor-pointer">Reject Transfer</span>
                    </div>

                   
               </div>
           </div>

       </div>

       <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchRequests"/>

   </AuthenticatedPage>

   <Dialog v-model:visible="actionRequestModal" modal header="Action Property Transfer Request" :style="{ width: '50rem',  fontFamily: 'Lexend Deca' }">
       <div class="w-full flex flex-col justify-start items-start gap-4 bg-gray-200 p-4 text-black">
            <div class="w-full flex justify-start items-start p-4 gap-4">
                <Button  text="Approve Request" buttonType="create" class="translate-y-2.5"/>
                <Button  text="Reject Request" buttonType="delete" class="translate-y-2.5"/>
            </div>
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
    import { Notify,Loading, Report, Confirm } from 'notiflix';
    import Select from 'primevue/select';
    import InputText from 'primevue/inputtext';
    import FloatLabel from 'primevue/floatlabel';
    import InputNumber from 'primevue/inputnumber';
    import DatePicker from 'primevue/datepicker';
    import { useAuthStore } from '../../../stores/authStore';

    const router = useRouter();
    const requests = ref([]);
    const store = useAuthStore();
    

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

    var actionRequestModal = ref(false)

   onMounted(() => {
       fetchRequests();
   });


   function fetchRequests(){
       Loading.dots('Loading Data, Please Wait...',{
           clickToClose:false,
           fontFamily:'Lexend Deca'
       });
       
       axios.get('property/transfer_requests',{
           params:{
                page:pagination.value.page,
                keyword:searchKeyword.value
           }
       })
       .then((response)=>{
           requests.value = response.data.transfer_requests
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



    // Confirm functions
    function confirmApprovalOfPC(request_id){
        Confirm.show(
                'Confirm Approval(Custodian)',
                'Confirm Approval of the Property Transfer Request?',
                'Approve',
                'Cancel',
            () => {
                // approveRequestByPC(request_id)
            },
            () => {
                
            },
            {
                fontFamily: 'Lexend Deca',
            },
        );
    }

    function confirmRejectionOfPC(request_id){
        Confirm.prompt(
            'Confirm Reject(Custodian)',
            'Are you sure to reject this transfer request? Please provide a reason.',
            'Enter Reason',
            'Submit',
            'Cancel',
            (reason) => {
                if(reason === '' || reason === 'Enter Reason'){
                    Notify.failure('Please provide a reason for rejection.',() => {},{fontFamily:'Lexend Deca'})
                }
                else{

                }
            },
            () => {
                
            },
            {
                fontFamily:'Lexend Deca',
            },
        );
    }


    function confirmApprovalOfDC(request_id){
        Confirm.show(
            'Confirm Approval(MSD Chief)',
                'Confirm Approval of the Property Transfer Request?',
                'Approve',
                'Cancel',
            () => {
                // approveRequestByPC(request_id)
            },
            () => {
                
            },
            {
                fontFamily: 'Lexend Deca',
            },
        );
    }

    function confirmRejectionOfDC(request_id,reason){
        Confirm.prompt(
            'Confirm Rejection(MSD Chief)',
            'Are you sure to reject this transfer request? Please provide a reason.',
            'Enter Reason',
            'Submit',
            'Cancel',
            (reason) => {
                if(reason === '' || reason === 'Enter Reason'){
                    Notify.failure('Please provide a reason for rejection.',() => {},{fontFamily:'Lexend Deca'})
                }
                else{

                }
            },
            () => {
                
            },
            {
                fontFamily:'Lexend Deca',
            },
        );
    }


    // Approve functions
    // function approveRequestByPC(request_id){
    //     Loading.dots('Approving Request, Please Wait...',{
    //         clickToClose:false,
    //         fontFamily:'Lexend Deca'
    //     });
        
    //     axios.post('property/transfer_request/approve',{
    //         request_id:request_id
    //     })
    //     .then((response)=>{
    //         Notify.success('Property Transfer Request Approved Successfully.',() => {},{fontFamily:'Lexend Deca'})
    //         fetchRequests()
    //     })
    //     .catch((error)=>{
    //         Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
    //         console.log(error.response.data)
    //     })
    //     .finally(()=>{
    //         Loading.remove()
    //     })
    // }

    // function approveRequestByDC(request_id){
       
    // }

    //Reject functions
    // function rejectRequestByPC(request_id){
    //     Loading.dots('Approving Request, Please Wait...',{
    //         clickToClose:false,
    //         fontFamily:'Lexend Deca'
    //     });
        
    //     axios.post('property/transfer_request/reject',{
    //         request_id:request_id,
    //         reason:reason
    //     })
    //     .then((response)=>{
    //         Notify.success('Property Transfer Request Approved Successfully.',() => {},{fontFamily:'Lexend Deca'})
    //         fetchRequests()
    //     })
    //     .catch((error)=>{
    //         Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
    //         console.log(error.response.data)
    //     })
    //     .finally(()=>{
    //         Loading.remove()
    //     })
    //}

</script>