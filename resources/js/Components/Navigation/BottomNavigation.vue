<script setup>
import { router } from '@inertiajs/vue3'
import GenericButton from '@/Components/Button/GenericButton.vue'

defineProps({
  left: {
    type: Object,
    default: null,
  },
  right: {
    type: Object,
    default: null,
  },
})

function goTo(route) {
  router.visit(route)
}
</script>

<template>
  <div v-if="left || right" class="border-t border-gray-300 py-3 flex justify-between">
    <div>
      <GenericButton v-if="left" @click="goTo(left.route)">
        {{ left.name }}
      </GenericButton>
    </div>
    <div>
      <GenericButton v-if="right" @click="goTo(right.route)" variant="dark-grey">
        {{ right.name }}
      </GenericButton>
    </div>
  </div>
</template>
