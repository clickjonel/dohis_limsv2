<template>
    <button class="flex justify-start items-center pr-4 pl-3 py-2 gap-2 font-lexend cursor-pointer shadow-slate-600 shadow-md" :class="mappedButton.classes">
        <Icon :icon="props.icon ?? mappedButton.icon" />
        <span>{{ props.text }}</span>
    </button>
</template>

<script setup>
    import { computed } from 'vue'
    import { Icon } from '@iconify/vue/dist/iconify.js';

    const props = defineProps({
        buttonType:{
            type:String,
            default:'info'
        },
        text:{
            type:String,
            default:'Button'
        },
        icon:{
            type:String
        }
    });

    const buttons = {
        create: {
            classes: 'bg-emerald-900 text-white hover:bg-emerald-800',
            icon: 'material-symbols:add-rounded',
        },
        update: {
            classes: 'bg-blue-900 text-white hover:bg-blue-800',
            icon: 'material-symbols:edit-square',
        },
        delete: {
            classes: 'bg-rose-900 text-white hover:bg-rose-800',
            icon: 'material-symbols:warning',
        },
        info: {
            classes: 'bg-blue-600 text-white hover:bg-blue-500',
            icon: 'material-symbols:check-circle',
        },
        warning: {
            classes: 'bg-amber-900 text-white hover:bg-amber-800',
            icon: 'material-symbols:check-circle',
        },
        navigation: {
            classes: 'bg-[#4C7B8B] text-white hover:bg-blue-800',
            icon: 'mynaui:navigation-one-solid',
        },
        default: {
            classes: 'bg-gray-500 text-white hover:bg-gray-400',
            icon: 'mdi:gear-box',
        },
    };

    const mappedButton = computed(() => buttons[props.buttonType] || buttons.default);

</script>