<script setup>
import { computed } from 'vue'

const props = defineProps({
  show: Boolean,
  type: {
    type: String,
    default: 'success',
  },
  title: String,
  message: String,
})

const bgColor = computed(() =>
  props.type === 'success'
    ? 'bg-green-50 border-green-200'
    : 'bg-red-50 border-red-200'
)

const textColor = computed(() =>
  props.type === 'success'
    ? 'text-green-700'
    : 'text-red-700'
)

const icon = computed(() =>
  props.type === 'success' ? '✓' : '✕'
)
</script>

<template>
  <transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0 translate-y-2"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100 translate-y-0"
    leave-to-class="opacity-0 translate-y-2"
  >
    <div
      v-if="show"
      class="fixed top-6 right-6 w-80 rounded-lg border shadow-lg p-4"
      :class="bgColor"
    >
      <div class="flex items-start gap-3">
        <div
          class="w-6 h-6 flex items-center justify-center rounded-full text-white text-sm font-bold"
          :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
        >
          {{ icon }}
        </div>

        <div>
          <div class="font-semibold" :class="textColor">
            {{ title }}
          </div>
          <div class="text-sm mt-1 text-slate-600">
            {{ message }}
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>