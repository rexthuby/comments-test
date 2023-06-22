<script setup>
import VueEasyLightbox from "vue-easy-lightbox";
import {ref} from "vue";

const props = defineProps({
    imageSrc: {
        type: String,
        required: true,
    }
})

const imageIndex = ref(0)
const isImageVisible = ref(false)
</script>

<template>
    <div class="h-20" @click="isImageVisible = !isImageVisible">
        <img :src="imageSrc" class="h-full" :alt="imageSrc">
    </div>
    <VueEasyLightbox
        :visible="isImageVisible"
        :imgs="imageSrc"
        :index="imageIndex"
        @hide="isImageVisible = false"
    ></VueEasyLightbox>
</template>

<style scoped>

</style>
