<script setup>
import { useAttrs } from 'vue'

defineProps({
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value),
  },
  variant: {
    type: String,
    default: 'grey',
    validator: (value) => ['grey', 'dark-grey', 'red'].includes(value),
  },
})

defineEmits(['click'])

const attrs = useAttrs()

const sizeClasses = {
  sm: 'text-sm px-3 py-1.5',
  md: 'text-base px-4 py-2',
  lg: 'text-lg px-6 py-3',
}

const variantClasses = {
  grey: 'bg-gray-300 text-black hover:bg-gray-400',
  'dark-grey': 'bg-black text-white hover:bg-gray-900',
  red: 'bg-red-600 text-white hover:bg-red-700',
}

const baseClasses = 'font-semibold transition'
</script>

<template>
  <button
    v-bind="attrs"
    @click="$emit('click')"
    :class="[baseClasses, sizeClasses[size], variantClasses[variant]]"
  >
    <slot />
  </button>
</template>
