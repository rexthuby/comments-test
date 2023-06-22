<script setup>
import UserComment from "./UserComment.vue";

defineProps({
  comments: {
    type: Array,
    required: true,
  }
})
</script>

<template>
  <div v-for="comment in comments">
    <UserComment class="mb-2" :id="comment.id" :depth="comment.depth" :comments-text="comment.body" :file-name="comment.file"
                 :created-at="comment.created_at" :username="comment.username"></UserComment>
    <CommentsList :comments="comment.replies" v-if="comment.replies.length"></CommentsList>
  </div>
</template>

<style scoped>

</style>
