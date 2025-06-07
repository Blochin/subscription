<script setup>
import { computed, ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import MainHeader from '@/Components/Header/MainHeader.vue'
import Box from '@/Components/Box/Box.vue'
import BottomNavigation from '@/Components/Navigation/BottomNavigation.vue'
import GenericButton from '@/Components/Button/GenericButton.vue'

defineOptions({ layout: BaseLayout })

const { payment, payment_methods } = defineProps({
  payment: Object,
  payment_methods: Array,
})

const form = useForm({
  card_number: null,
  expiration: null,
  cvv: null,
  webhook_name: 'payments.process',
  payment_token: null,
})

const selectedMethodId = ref('new')

watch(selectedMethodId, (val) => {
  if (val === 'new') {
    form.payment_token = null
  } else {
    const selected = payment_methods.find((pm) => pm.id === val)
    form.payment_token = selected.payment_token
    form.card_number = null
    form.expiration = null
    form.cvv = null
  }
})

const isNewCard = computed(() => selectedMethodId.value === 'new')

function submit() {
  form.post(route('payments.pay', payment.id), {
    preserveScroll: true,
    onSuccess: () => {
      Inertia.visit(route('payments.show', payment.id))
    },
  })
}

function cancelPayment() {
  Inertia.post(route('payments.cancel', payment.id))
}
</script>

<template>
  <div class="mx-auto py-10 space-y-8">
    <MainHeader>Payment Detail</MainHeader>

    <Box
      :rows="[
        {
          id: 'amount',
          key: 'Amount: ',
          content: payment.amount.readable,
          size: 'small',
        },
        {
          id: 'plan',
          key: 'Plan: ',
          content: payment.subscription.subscription_plan.name,
          size: 'small',
        },
        {
          id: 'status',
          key: 'Status: ',
          content: payment.status,
          size: 'small',
        },
      ]"
    >
    </Box>

    <form
      v-if="payment.status === 'pending'"
      @submit.prevent="submit"
      class="p-6 border-4 border-dashed border-black space-y-6"
    >
      <div>
        <label class="block font-semibold mb-1">Payment Method</label>
        <select v-model="selectedMethodId" class="w-full border px-4 py-2">
          <option value="new">➕ Add new payment method</option>
          <option v-for="method in payment_methods" :key="method.id" :value="method.id">
            {{ method.card_number }}
          </option>
        </select>
      </div>

      <div v-if="isNewCard" class="space-y-4">
        <div>
          <label class="block font-semibold mb-1">Card Number</label>
          <input
            v-model="form.card_number"
            type="text"
            placeholder="1234 5678 9012 3456"
            class="w-full border px-4 py-2"
            :class="{ 'border-red-500': form.errors.card_number }"
          />
          <span v-if="form.errors.card_number" class="text-red-600 text-sm">
            {{ form.errors.card_number }}
          </span>
        </div>

        <div class="flex gap-4">
          <div class="flex-1">
            <label class="block font-semibold mb-1">Expiration</label>
            <input
              v-model="form.expiration"
              type="text"
              placeholder="MM/YY"
              class="w-full border px-4 py-2"
              :class="{ 'border-red-500': form.errors.expiration }"
            />
            <span v-if="form.errors.expiration" class="text-red-600 text-sm">
              {{ form.errors.expiration }}
            </span>
          </div>

          <div class="flex-1">
            <label class="block font-semibold mb-1">CVV</label>
            <input
              v-model="form.cvv"
              type="text"
              placeholder="123"
              class="w-full border px-4 py-2"
              :class="{ 'border-red-500': form.errors.cvv }"
            />
            <span v-if="form.errors.cvv" class="text-red-600 text-sm">
              {{ form.errors.cvv }}
            </span>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-4 mt-6">
        <GenericButton type="button" @click="cancelPayment" variant="red"> Cancel </GenericButton>
        <GenericButton type="submit" :disabled="form.processing" variant="dark-grey">
          Pay
        </GenericButton>
      </div>
    </form>
    <BottomNavigation
      :left="{ name: 'All Plans', route: route('plans.index') }"
      :right="{
        name: 'Subscription detail',
        route: route('subscriptions.show', payment.subscription.id),
      }"
    />
  </div>
</template>
