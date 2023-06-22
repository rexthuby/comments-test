<script setup>
import {supportedFileExtension, txt} from "@/entities/Comment/consts/supportedFileExtension.js";
import {computed, onMounted} from "vue";
import ImageViewer from "@/features/ImageViewer/ui/ImageViewer.vue";
import TxtViewer from "@/features/TxtViewer/ui/TxtViewer.vue";
import {publicFileUrl} from "@/shared/consts/config.js";

const props = defineProps({
    commentsText: {
        type: String,
        required: true
    },
    fileName: {
        type: String,
        required: false,
        default: null
    }
})

const isShowFile = computed(() => {
    if (props.fileName && fileExtension && supportedFileExtension.includes((fileExtension.value))){
        return true
    }
    return false
})

const fileExtension = computed(() => {
    const lastDotIndex = props.fileName.lastIndexOf(".");
    if (lastDotIndex !== -1) {
        const extension = props.fileName.substring(lastDotIndex)
        return extension;
    } else {
        return null
    }
})
</script>

<template>
    <div>
        <div>{{ commentsText }}</div>
        <div v-if="isShowFile">
            <div v-if="fileExtension !== txt">
                <ImageViewer :image-src="publicFileUrl+'/'+fileName"></ImageViewer>
            </div>
            <div v-else-if="fileExtension === txt">
                <TxtViewer :file-url="publicFileUrl+'/'+fileName"></TxtViewer>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
