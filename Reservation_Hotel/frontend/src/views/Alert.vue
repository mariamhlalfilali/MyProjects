<template>
  <div v-if="message" :class="['p-2 rounded mb-3 text-center', typeClass]" style="box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    {{ message }}
  </div>
</template>

<script setup>
import { defineProps, computed } from "vue"

const props = defineProps({
  message: String,
  type: { type: String, default: "success" } 
})

const typeClass = computed(() => {
  if (props.type === "error") return "text-white" + " bg-red-500" 
  return "text-orange-700" + " bg-orange-100"
})
</script>