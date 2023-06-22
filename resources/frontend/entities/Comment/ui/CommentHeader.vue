<script setup>
import UserAvatar from "@/entities/User/ui/UserAvatar.vue";
import {computed} from "vue";
import moment from "moment";
const props = defineProps({
  date:{
    type:String,
    required:true,
  },
  username:{
    type:String,
    required:true
  },
})

const preparedDate = computed(()=>{
  return moment(props.date).fromNow();
})
</script>

<template>
<div class="bg-gray-100 px-2 py-1 flex items-center gap-2">
  <UserAvatar :text="username" :avatar-size-px="40"></UserAvatar>
  <span class="font-bold">{{username}}</span>
  <span>{{preparedDate}}</span>
</div>
</template>

<style scoped>

</style>
