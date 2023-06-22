<script setup>
import {computed, onMounted, onUnmounted, ref} from "vue";

const props = defineProps({
    text: {
        type: String,
        required: true,
        default: null
    },
    avatarSizePx: {
        type: Number,
        default: null
    }
})


const firstLetter = computed(() => {
    if (!props.text || props.text.trim().length < 1) {
        return ''
    }
    return props.text.trim().substring(0, 1).toUpperCase();
})

const avatar = ref(null)
const fontSizePixels = ref(16)


onMounted(() => {
    setFontSizePixels()
    window.addEventListener('resize', setFontSizePixels)
})

onUnmounted(() => {
    window.removeEventListener('resize', setFontSizePixels)
})

const setFontSizePixels = () => {
    if (props.avatarSizePx) {
        fontSizePixels.value = props.avatarSizePx / 2
        return
    }
    const avatarRefValue = avatar.value
    const avatarWidth = avatarRefValue.offsetWidth;
    const avatarHeight = avatarRefValue.offsetHeight;
    fontSizePixels.value = Math.min(avatarWidth / 2, avatarHeight / 2)
}
</script>

<template>
    <div :class="[avatarSizePx ? '' : 'h-full aspect-square']"
         :style="{height:avatarSizePx+'px', width:avatarSizePx+'px'}" ref="avatar">
        <div class="h-full w-full rounded-full flex justify-center items-center bg-gray-300">
          <span class="text-xs font-medium text-white" :style="{'font-size': fontSizePixels+'px'}">
            {{ firstLetter }}
          </span>
        </div>
    </div>
</template>


<style scoped>

</style>
