<script setup>
import ColorfulButton from "@/shared/ui/buttons/ColorfulButton.vue";
import {ArrowUpTrayIcon} from "@heroicons/vue/24/outline";
</script>

<template>
  <ColorfulButton :bg-color="'blue'" padding-class="py-2 px-3">
    <div class="flex items-center">
      <ArrowUpTrayIcon class="h-6 w-6"></ArrowUpTrayIcon>
      <span>Upload</span></div>
  </ColorfulButton>
</template>

<style scoped>

</style>
