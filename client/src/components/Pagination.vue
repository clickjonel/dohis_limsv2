<template>
     <!-- Pagination -->
     <div class="w-full min-h-[5%] flex justify-between items-center p-2 font-lexend gap-2 border-y">
        <div class="">
            <span class="font-light text-sm font-poppins">{{ props.total }} total entries</span>
        </div>
        <div class="h-full flex justify-start items-center gap-4">
            <Icon @click="goToFirstPage" icon="ri:arrow-left-double-fill" class="rounded-full text-xl border cursor-pointer hover:bg-gray-900 hover:text-white shadow-md shadow-slate-600"/>

            <Icon @click="goToPreviousPage" icon="mingcute:left-fill" class="rounded-full text-xl border cursor-pointer hover:bg-gray-900 hover:text-white shadow-md shadow-slate-600"/>

            <div class="flex justify-center items-center gap-2 font-lexend text-xs font-medium ">
                <span class="size-10 flex justify-center items-center rounded-full bg-blue-900 text-white shadow-md shadow-slate-600">{{ currentPage }}</span>
            </div>

            <Icon @click="goToNextPage" icon="mingcute:right-fill" class="rounded-full text-xl border cursor-pointer hover:bg-gray-900 hover:text-white shadow-md shadow-slate-600"/>

            <Icon @click="goToLastPage" icon="ri:arrow-right-double-fill" class="rounded-full text-xl border cursor-pointer hover:bg-gray-900 hover:text-white shadow-md shadow-slate-600"/>
        </div>
        <div class="">
            <span class="font-light text-sm font-poppins">Showing Page {{ currentPage }} of {{ totalPages }}</span>
        </div>
     </div>
</template>

<script setup>
    import { ref,computed } from 'vue';
    import { Icon } from '@iconify/vue/dist/iconify.js';

    const props = defineProps({
        total:Number
    })

    const emit = defineEmits(['fetchPage'])

    const totalPages = computed(() => Math.ceil(props.total / 15));

    var currentPage = defineModel()

    function goToPreviousPage(){
        if(currentPage.value > 1){
            currentPage.value -= 1
            emit('fetchPage','asdasda')
        }
    }

    function goToNextPage(){
        if(currentPage.value < totalPages.value){
            currentPage.value += 1
            emit('fetchPage',currentPage+1)
        }
    }

    function goToLastPage(){
        currentPage.value = totalPages.value
        emit('fetchPage',totalPages.value)
    }

    function goToFirstPage(){
        currentPage.value = 1
        emit('fetchPage',1)
    }

</script>