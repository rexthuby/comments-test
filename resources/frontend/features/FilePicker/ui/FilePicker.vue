<script setup>
import {computed, ref} from "vue";
import CancelButton from './CancelButton.vue';
import UploadButton from './UploadButton.vue'
import FileInput from "./FileInput.vue";

const props = defineProps({
    modelValue: {
        default: null,
    },
    accept: {
        type: [String, Array],
        default: null,
    },
});

const button = ref(null);

const input = ref(null);

const emit = defineEmits(["update:modelValue"]);

const file = ref(props.modelValue);

const removeFile = () => {
    file.value = null
    emit("update:modelValue", null)
}

const upload = (event) => {
    const value = event?.target?.files || event?.dataTransfer?.files;

    file.value = value[0];

    emit("update:modelValue", file.value);
}

const cansel = (event) => {
    emit("update:modelValue", null);
}

const buttonWidth = computed(() => {
    const but = button.value
    if (but == null) {
        return null
    }
    return but?.clientWidth
})

const buttonHeight = computed(() => {
    const but = button.value
    if (but == null) {
        return null
    }
    return but?.clientHeight
})

</script>

<template>
    <div class="flex items-stretch justify-start relative gap-1">
        <label class="inline-flex" ref="button">
            <slot>
                <UploadButton></UploadButton>
            </slot>
            <FileInput ref="input" @change="upload" @cansel="cansel" :accept="Array.isArray(accept) ? accept.join(','):accept"
                       :height-px="buttonHeight" :width-px="buttonWidth"
                       class="absolute top-0 left-0 opacity-0 outline-none cursor-pointer -z-1"></FileInput>
        </label>
        <div v-if="file" class="flex items-center gap-1">
      <span class="text-ellipsis line-clamp-1 bg-gray-100 py-0.5 px-2 rounded-r">
        {{ modelValue.name }}
      </span>
            <CancelButton padding-class="p-1" @click="removeFile">
            </CancelButton>
        </div>
    </div>
</template>
