<template>

    <div class="w-full min-h-screen h-screen bg-gray-400/10 backdrop-blur-sm flex flex-col justify-start items-start p-4 gap-4">
        <span class="w-full text-5xl font-black font-noto border-b">{{ props.pageTitle }}</span>

        <slot></slot>

    </div>

</template>

<script setup>

    const props = defineProps({
        pageTitle:String
    })

</script>