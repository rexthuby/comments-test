<script setup>
import WhiteButton from "@/shared/ui/buttons/WhiteButton.vue";

defineProps({
  isReplyable: {
    type: Boolean,
    required:true,
    default: true
  }
})

const emit = defineEmits(['replies', 'cansel'])
</script>

<template>
  <div class="flex items-center">
    <WhiteButton v-if="isReplyable" class="rounded-lg" @click="emit('replies')" padding-class="py-1 px-2"><span class="text-size">Reply</span></WhiteButton>
    <WhiteButton v-else class="rounded-lg" @click="emit('cansel')" padding-class="py-1 px-2"><span class="text-size">Cansel</span></WhiteButton>
  </div>
</template>

<style scoped>
.text-size {
    font-size: 0.8rem;
    line-height: 0.9rem;
}
</style>
