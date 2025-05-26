<template>

    <div class="w-full min-h-full h-full flex flex-col justify-start items-start">
        <!-- <span class="w-full text-5xl font-black font-noto border-b">{{ props.pageTitle }}</span> -->

        <slot></slot>

    </div>

</template>

<script setup>

    const props = defineProps({
        pageTitle:String
    })

</script>