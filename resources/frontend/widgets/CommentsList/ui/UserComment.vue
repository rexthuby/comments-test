<script setup>
import CommentHeader from "@/entities/Comment/ui/CommentHeader.vue";
import CommentFooter from "@/entities/Comment/ui/CommentFooter.vue";
import CommentForm from "@/features/CommentForm/ui/CommentForm.vue";
import {ref} from "vue";
import CommentBody from "./CommentBody.vue";

const props = defineProps({
  id: {
    type: Number,
    required: true,
  },
  username: {
    type: String,
    required: true
  },
  commentsText: {
    type: String,
    required: true
  },
  createdAt: {
    type: String,
    required: true
  },
  depth: {
    type: Number,
    required: true
  },
  fileName: {
    type: String,
    required: false,
    default: null
  }
})

const isReplyActive = ref(false)
</script>

<template>
  <div :style="{paddingLeft: depth*2.5+'%'}">
    <CommentHeader :date="createdAt" :username="username"></CommentHeader>
    <CommentBody :file-name="fileName" :comments-text="commentsText" class="pb-2"></CommentBody>
    <CommentFooter :is-replyable="!isReplyActive"
                   @cansel="isReplyActive = false"
                   @replies="isReplyActive = true" class="pb-2"></CommentFooter>
    <CommentForm v-if="isReplyActive" :reply-to="id"></CommentForm>
  </div>
</template>

<style scoped>

</style>
