<script setup>
import { getCurrentInstance } from 'vue'

defineProps({
  rows: {
    type: Array,
    required: true,
  },
  borderStyle: {
    type: String,
    default: 'border-solid',
    validator: (value) =>
      ['border-solid', 'border-dashed', 'border-dotted', 'border-double', 'border-none'].includes(
        value
      ),
  },
})

const emit = defineEmits(['click'])

const instance = getCurrentInstance()
const clickable = !!instance?.vnode.props?.onClick

function handleClick() {
  if (clickable) emit('click')
}

const sizeMap = {
  small: 'text-sm leading-snug',
  medium: 'text-2xl font-bold uppercase',
  large: 'text-3xl font-black',
}
</script>

<template>
  <div
    :class="[
      'p-6 border-4 border-black font-mono',
      borderStyle,
      clickable && 'cursor-pointer transition hover:bg-black hover:text-white',
    ]"
    @click="handleClick"
  >
    <slot></slot>
    <p v-for="row in rows" :key="row.id" :class="sizeMap[row.size]">
      <span class="font-bold">{{ row.key }}</span
      >{{ row.content }}
    </p>
  </div>
</template>

<style scoped></style>
