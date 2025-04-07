<template>
    <AuthenticatedPage pageTitle="Downloadable Forms">
       <div class="w-full min-h-[90%] flex flex-col justify-start items-center gap-4">

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <!-- <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[25%]">Article</span>
                   <span class="min-w-[20%]">End User/s</span>
                   <span class="min-w-[15%]">Cost</span>
                   <span class="min-w-[10%]">Acquisition Date</span>
                   <span class="min-w-[20%]">Actions</span>
               </div>
               
               <div v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black">
                   <span class="min-w-[10%]">{{ property.property_no }}</span>
                   <span class="min-w-[25%] text-xs">{{ property.particulars }}</span>
                   <span class="min-w-[20%] text-xs">{{ property.user_name }}</span>
                   <span class="min-w-[15%] text-xs">{{ property.unit_cost }}</span>
                   <span class="min-w-[10%]">{{ property.user.issuance_date }}</span>
                   <div class="min-w-[20%] flex justify-center items-center gap-2">
                      <span title="Update Delivery"><Icon icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                       <span title="Print IAR"><Icon icon="material-symbols:print-rounded" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span>
                   </div>
               </div> -->
           </div>

       </div>

   </AuthenticatedPage>

   <!-- <Dialog v-model:visible="addPropertyModal" modal header="Add Property" :style="{ width: '100rem',  fontFamily: 'Lexend Deca' }" @hide="clearAddPropertyForm">
       <div class="w-full flex flex-col justify-start items-start gap-4 bg-gray-200 p-4 text-black">
            <div class="w-full flex justify-start items-start gap-4">
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="text" label="Property Number" :errorMessage="errors.property_no ? errors.property_no[0] : ''" v-model="property.property_no"/>
                </div>
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="number" label="Unit Cost" :errorMessage="errors.unit_cost ? errors.unit_cost[0] : ''" v-model="property.unit_cost"/>
                </div>
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="text" label="Remarks" :errorMessage="errors.remarks ? errors.remarks[0] : ''" v-model="property.remarks"/>
                </div>
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="date" label="Acquisition Date" :errorMessage="errors.acquisition_date ? errors.acquisition_date[0] : ''" v-model="property.acquisition_date"/>
                </div>
            </div>
            <div class="w-full flex justify-start items-start gap-4">
                <Select v-model="property.measurement_unit" :options="measurements" :invalid="errors.measurement_unit ? true : false" filter optionLabel="name" placeholder="Select Measurement" class="w-1/3 font-lexend translate-y-1/2">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>
                <Select v-model="property.status" :options="statuses" :invalid="errors.status ? true : false" filter optionLabel="name" placeholder="Select Status" class="w-1/3 font-lexend translate-y-1/2">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>
                <Select v-model="property.end_user" :options="end_users" :invalid="errors.end_user ? true : false" filter optionLabel="full_name" placeholder="Select End User" class="w-1/3 font-lexend translate-y-1/2">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.full_name }}</div>
                        </div>
                    </template>
                </Select>
            </div>
            <div class="w-full flex justify-start items-start pt-4">
                <TextArea v-model="property.particulars" label="Description/Particulars" :errorMessage="errors.particulars ? errors.particulars[0] : '' "/>
            </div>
            <div class="w-full flex justify-end items-start p-4">
                <Button @click="save" text="Submit" buttonType="create" class="translate-y-2.5"/>
            </div>
       </div>
   </Dialog> -->

</template>

<script setup>
   import { ref,onMounted } from 'vue';
   import Dialog from 'primevue/dialog';
   import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';


</script>