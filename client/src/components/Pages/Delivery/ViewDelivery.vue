<template>

    <AuthenticatedPage>
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 overflow-y-scroll font-poppins p-4">
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="w-full text-left font-semibold text-3xl">Delivery Details</span>
                <div class="w-full grid grid-cols-4">
                    <span>IAR Details</span>
                    <span>PO/PTR Details</span>
                    <span>Invoices Details</span>
                    <span>Receipts Details</span>
                </div>
                
            </div>
         </div>
    </AuthenticatedPage>

 </template>
 
 <script setup> 
     import { ref,onMounted } from 'vue';
     import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
     import Select from 'primevue/select';
     import Input from '../../Form/Input.vue';
     import Button from '../../Button.vue';
     import Dialog from 'primevue/dialog';
     import TextArea from '../../TextArea.vue';
     import { useRouter } from 'vue-router';
     import useApi from '../../../composables/api_calls';

     onMounted(()=>{
        console.log('asd')
     })
 


 
 </script>