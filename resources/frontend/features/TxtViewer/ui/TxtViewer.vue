<script setup>
import {DocumentIcon} from "@heroicons/vue/24/outline/index.js";
import ModalTxt from "@/shared/ui/modals/CommonModal.vue";
import {ref} from "vue";
import BasicSpinner from "@/shared/ui/spinners/BasicSpinner.vue";
import mime2ext from "mime2ext";

const props = defineProps({
    fileUrl: {
        type: String,
        required: true,
    }
})

const showTxt = ref(false)
const text = ref(null)

const openFileTxt = async () => {
    showTxt.value = true
    if (!text.value) {
        const fetchResp = await fetch(props.fileUrl)
        const blob = await fetchResp.blob()
        const extension = mime2ext(blob.type)
        const file = new File([blob], 'text' + '.' + extension, {type: blob.type})
        setTextFromFile(file)
    }
}

const close = () => {
    showTxt.value = false
}

const setTextFromFile = (file) => {
    let reader = new FileReader()
    reader.onload = (e) => {
        text.value = e.target.result
    }
    reader.readAsText(file)
}

</script>

<template>
    <div>
        <DocumentIcon class="h-8" @click="openFileTxt"></DocumentIcon>
        <ModalTxt v-model="showTxt" @close="close">
            <div class="w-full">
                <BasicSpinner v-if="!text"></BasicSpinner>
                <div v-else>{{ text }}</div>
            </div>
        </ModalTxt>
    </div>
</template>

<style scoped>

</style>
