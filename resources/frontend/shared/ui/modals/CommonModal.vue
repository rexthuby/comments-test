<script setup>
import {VueFinalModal} from 'vue-final-modal'

defineProps({
  modelValue: {
    type: Boolean,
    required: true
  }
})

const emit = defineEmits(['update:modelValue', 'close'])
</script>

<template>
  <VueFinalModal
      class="flex justify-center items-center"
      content-class="flex flex-col max-w-xl mx-4 p-4 bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg space-y-2"
      :model-value="modelValue"
      @update:model-value="val => emit('update:modelValue', val)">
    <slot/>
    <button class="mt-1 ml-auto px-2 border rounded-lg" @click="emit('close')">
      Close
    </button>
  </VueFinalModal>
</template>