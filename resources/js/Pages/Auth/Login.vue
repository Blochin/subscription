<script setup>
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import MainHeader from '@/Components/Header/MainHeader.vue'
import GenericButton from '@/Components/Button/GenericButton.vue'

defineOptions({ layout: GuestLayout })

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('login'), {
    preserveScroll: true,
  })
}
</script>

<template>
  <div class="max-w-md mx-auto py-20 space-y-10">
    <MainHeader>Login</MainHeader>

    <form @submit.prevent="submit" class="space-y-6 border-4 border-dashed border-black p-6">
      <div>
        <label class="block font-semibold mb-1">Email</label>
        <input
          v-model="form.email"
          type="email"
          placeholder="you@example.com"
          class="w-full border px-4 py-2"
          :class="{ 'border-red-500': form.errors.email }"
        />
        <span v-if="form.errors.email" class="text-red-600 text-sm">
          {{ form.errors.email }}
        </span>
      </div>

      <div>
        <label class="block font-semibold mb-1">Password</label>
        <input
          v-model="form.password"
          type="password"
          placeholder="password"
          class="w-full border px-4 py-2"
          :class="{ 'border-red-500': form.errors.password }"
        />
        <span v-if="form.errors.password" class="text-red-600 text-sm">
          {{ form.errors.password }}
        </span>
      </div>

      <div class="flex justify-end">
        <GenericButton type="submit" :disabled="form.processing" variant="dark-grey"
          >Log in
        </GenericButton>
      </div>
    </form>
  </div>
</template>

<style scoped></style>
