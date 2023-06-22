<script setup>

const props = defineProps({
  heightPx:{
    type:Number,
    default:false,
  },
  widthPx:{
    type:Number,
    default:false,
  },
});
</script>

<template>
  <input type="file"
         :style="{height:heightPx ? heightPx+'px' : '100%', width:widthPx ? widthPx+'px' : '100%'}"/>
</template>

<style scoped>

</style>
