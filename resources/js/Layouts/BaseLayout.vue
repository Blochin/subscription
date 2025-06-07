<script setup>
import { Head, router } from '@inertiajs/vue3'
import GenericButton from '@/Components/Button/GenericButton.vue'

function logout() {
  router.post(route('logout'))
}
</script>

<template>
  <div class="min-h-screen bg-white text-black font-mono">
    <Head title="Subscription" />

    <main class="max-w-5xl mx-auto px-6 py-10">
      <div class="mx-auto flex justify-end">
        <GenericButton @click="logout" variant="red" size="sm"> Logout </GenericButton>
      </div>
      <slot />
    </main>
  </div>
</template>
