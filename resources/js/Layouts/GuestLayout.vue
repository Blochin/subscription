<script setup>
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <div class="min-h-screen bg-white text-black font-mono">
    <Head title="Subscription" />
    <main class="max-w-5xl mx-auto px-6 py-10">
      <slot />
    </main>
  </div>
</template>
