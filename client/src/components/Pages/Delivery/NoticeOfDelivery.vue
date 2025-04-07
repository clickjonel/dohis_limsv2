<template>

    <AuthenticatedPage v-if="!preview" pageTitle="Notice of Delivery to COA">
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">
 
             <div class="w-full flex justify-between items-center p-2 gap-4">
                <Button @click="iarSelectionForm = true" buttonType="info" text="Add IAR"/>
                <Button @click="preview = true" buttonType="default" text="Generate NOD"/>
             </div>
 
             <div class="w-full flex justify-start items-start gap-4 px-2">
                <span v-for="iar in iarNumbers" class="px-4 py-2 bg-gray-300 shadow-md shadow-slate-600">{{ iar }}</span>
             </div>
            
 
         </div>
    </AuthenticatedPage>

    <!-- preview -->
    <div v-if="preview" class="w-full min-h-screen flex flex-col justify-start items-center gap-4 px-2 pt-6 pb-2">
        <div id="header" class="w-full flex justify-between items-center p-2 gap-4">
            <Button @click="preview = false" buttonType="info" text="Close Preview"/>
            <Button @click="print"  buttonType="default" text="Print"/>
        </div>

        <div class="flex justify-center items-center gap-2">
            <div class="flex w-20 h-20">
                <img src="../../../assets/doh_logo.png" class="size-full" alt="">
            </div>
            <div class="flex flex-col justify-start items-start font-noto gap-0 text-xs uppercase">
                <span class="font-bold">Republic of the Philippines</span>
                <span class="font-bold">Department of Health</span>
                <span class="font-bold">Center for Health Development</span>
                <span>Cordillera Administrative Region</span>
                <span>Baguio City</span>
            </div>
        </div>

        <div class="w-full flex flex-col justify-start items-start outline divide-y font-lexend text-sm font-light">
            <div class="w-full flex justify-start items-start divide-x">
                <div class="max-w-[50%] min-w-[50%] flex justify-start items-stretch divide-x">
                    <span class="min-w-[50%] text-left pl-1">NOD Control Number</span>
                    <span class="min-w-[50%] text-left pl-1"><input type="text" class="w-full outline-none"></span>
                </div>
                <div class="max-w-[50%] min-w-[50%] flex justify-start items-stretch divide-x">
                    <span class="min-w-[50%] text-left pl-1">Date Prepared</span>
                    <span class="min-w-[50%] text-left pl-1">{{ date }}</span>
                </div>
            </div>

            <div class="w-full flex justify-start items-start divide-x">
                <div class="max-w-[50%] min-w-[50%] flex flex-col justify-start items-stretch">
                    <span class="min-w-[50%] text-left text-xs italic font-noto p-1">To:</span>
                    <div class="min-w-[50%] flex flex-col justify-start items-stretch">
                        <span class="min-w-[50%] text-center underline font-semibold uppercase">Tracey B. Camacho</span>
                        <span class="min-w-[50%] text-center text-xs">Audit Team Leader/State Auditor IV</span>
                        <span class="min-w-[50%] text-center text-xs font-medium uppercase">Resident COA Auditor</span>
                    </div>
                </div>
                <div class="max-w-[50%] min-w-[50%] flex flex-col justify-start items-stretch">
                    <span class="min-w-[50%] text-left text-xs italic font-noto p-1">From:</span>
                    <div class="min-w-[50%] flex flex-col justify-start items-stretch">
                        <span class="min-w-[50%] text-center underline font-semibold uppercase">Ferdinand M. Benbenen MD, DPCP, MHA, FPSMS</span>
                        <span class="min-w-[50%] text-center text-xs">Director IV</span>
                    </div>
                </div>
            </div>

            <span class="w-full bg-gray-400 text-center font-medium uppercase">I. Details of Delivery</span>

            <div class="w-full flex justify-start items-stretch divide-x text-xs font-lexend break-words text-center">
                <span class="max-w-[5%] min-w-[5%] w-[5%] text-center">No.</span>
                <span class="max-w-[20%] min-w-[20%]">Item Description</span>
                <span class="max-w-[10%] min-w-[10%]">Source/Supplier</span>
                <span class="max-w-[10%] min-w-[10%]">Delivery Date</span>
                <span class="max-w-[10%] min-w-[10%]">DR/SI/CI No.</span>
                <span class="max-w-[10%] min-w-[10%]">Date of DR/SI</span>
                <span class="max-w-[10%] min-w-[10%]">PO / Contract No.</span>
                <span class="max-w-[10%] min-w-[10%]">Date of PO/Contract</span>
                <span class="max-w-[10%] min-w-[10%]">Amount(PHP)</span>
            </div>

            <div class="w-full flex flex-col justify-start items-start text-xs divide-y">
                <div v-for="(item,index) in items" v-bind:key="item.id" class="w-full flex justify-start items-stretch divide-x text-[10px] font-lexend break-words text-left">
                    <span class="max-w-[5%] min-w-[5%] text-center">{{ index+1 }}</span>
                    <span class="max-w-[20%] min-w-[20%]" v-html="item.description.replace(/\n/g, '<br>')"></span>
                    <span class="max-w-[10%] min-w-[10%]">{{ item.source_name }}</span>
                    <span class="max-w-[10%] min-w-[10%]" v-html="item.delivery_dates"></span>
                    <span class="max-w-[10%] min-w-[10%]" v-html="item.dr_si_nos"></span>
                    <span class="max-w-[10%] min-w-[10%]" v-html="item.dr_si_dates"></span>
                    <span class="max-w-[10%] min-w-[10%]">{{ item.contract_no }}</span>
                    <span class="max-w-[10%] min-w-[10%]">{{ item.contract_date }}</span>
                    <span class="max-w-[10%] min-w-[10%]">{{ item.unit_cost * item.quantity }}</span>
                </div>
            </div>

            <span class="w-full bg-gray-400 text-center font-medium uppercase">II. Attachments</span>

            <div class="w-full flex justify-start items-stretch divide-x text-xs font-lexend break-words text-center">
                <div class="w-1/3 flex justify-center items-center p-2 gap-2">
                    <span>Sales Invoice</span>
                    <input type="checkbox">
                </div>
                <div class="w-1/3 flex justify-center items-center p-2 gap-2">
                    <span>Delivery Receipt</span>
                    <input type="checkbox">
                </div>
                <div class="w-1/3 flex justify-center items-center p-2 gap-2">
                    <span>Purchase Order/Contract</span>
                    <input type="checkbox">
                </div>
            </div>

            <div class="w-full flex justify-start items-stretch divide-x text-xs font-lexend break-words text-center">
                <div class="w-1/2 flex justify-center items-center p-2 gap-2">
                    <span>Others</span>
                    <input type="checkbox">
                </div>
                <div class="w-1/4 flex justify-center items-center p-2 gap-2">
                    <span>Place of Delivery</span>
                </div>
                <div class="w-1/4 flex justify-center items-center p-2 gap-2">
                    <span>DOH-CHD-CAR, BGHMC Compound, Baguio City</span>
                </div>
            </div>

            <div class="w-full flex justify-start items-stretch divide-x text-xs font-lexend break-words text-center">
               <span class="w-1/2">Prepared by</span>
               <span class="w-1/2">Checked by</span>
            </div>

            <div class="w-full flex justify-start items-stretch divide-x text-xs font-lexend break-words text-center">
                <div class="w-1/2 flex flex-col justify-center items-center p-2">
                    <span class="underline uppercase font-medium">Irene G. Oyawon</span>
                    <span class="text-xs">Administrative Assistant V</span>
                </div>
                <div class="w-1/2 flex flex-col justify-center items-center p-2">
                    <span class="underline uppercase font-medium">Felina S. Carlos</span>
                    <span class="text-xs">Administrative Officer V</span>
                </div>
            </div>


        </div>

    </div>
 
    <Dialog v-model:visible="iarSelectionForm" modal header="Set IAR/s to Include in Notice" :style="{ width: '25rem' }" class="font-lexend" @hide="iar_no = ''">
        <hr>
        
        <Input v-model="iar_no" label="IAR Number" type="text"/>

        <div class="flex justify-end gap-2 pt-2 text-sm">
            <Button @click="iarSelectionForm = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="checkIARifExists" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

 </template>
 
 <script setup> 
     import { ref,onMounted } from 'vue';
     import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
     import Button from '../../Button.vue';
     import axios from '../../../axios/axios';
     import { Notify,Loading, Report } from 'notiflix';
     import { useRouter } from 'vue-router';
     import Dialog from 'primevue/dialog';
     import Input from '../../Form/Input.vue';
     import InputMask from 'primevue/inputmask';
 
     const router = useRouter();

     var items = ref([]);
     var iar_no = ref('');
     var iarNumbers = ref([]);

     var iarSelectionForm = ref(false)
     var preview = ref(false);

     const date = new Date().toISOString().split('T')[0];

     function checkIARifExists(){
        Loading.dots('Loading Data, Please Wait...', {
            clickToClose: false
        });

        axios.get('delivery/exists/iar',{
            params: {
                iar_no: iar_no.value
            }
        }).then(response => {
            if(response.data.status){
                items.value.push(...response.data.delivery);
                iarNumbers.value.push(iar_no.value);
                iarSelectionForm.value = false;
                console.log(response.data.delivery);
            }
            else{
               Notify.failure('IAR Number does not exist');
            }
        }).catch(error => {
            console.log(error);
        })
        .finally(() => {
            Loading.remove();
        });
     }

     function print(){
        window.print();
     }
 
 </script>


<style scoped>
    @media print{
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .header-button {
            display: none;
        }
        #header {
            display: none;
        }
    }
</style>