<script setup>
import {useSlots} from "vue";

defineProps({
    title: {
        type: String,
        required: false,
    },
});

const slots = useSlots()
</script>

<template>
    <section class="flex items-center flex-wrap p-4 gap-4">
        <slot name="additional-left"></slot>
        <div class="flex items-center justify-start">
            <div class="text-2xl leading-tight">
                {{ title }}
            </div>
        </div>
        <slot name="additional-right"></slot>
    </section>
</template>
