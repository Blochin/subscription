<script setup>
import { router } from '@inertiajs/vue3'
import MainHeader from '@/Components/Header/MainHeader.vue'
import Box from '@/Components/Box/Box.vue'
import BaseLayout from '@/Layouts/BaseLayout.vue'
import SubHeader from '@/Components/Header/SubHeader.vue'
import GenericTable from '@/Components/Table/GenericTable.vue'
import BottomNavigation from '@/Components/Navigation/BottomNavigation.vue'
import GenericButton from '@/Components/Button/GenericButton.vue'

defineOptions({ layout: BaseLayout })

const { subscription } = defineProps({
  subscription: Object,
  payment_methods: Array,
})

function cancel() {
  router.post(route('subscriptions.cancel', subscription.id))
}

function pay() {
  router.post(route('payments.store'), {
    subscription_id: subscription.id,
  })
}
</script>

<template>
  <div class="space-y-8">
    <MainHeader> Subscription Details</MainHeader>
    <Box
      :rows="[
        {
          id: 'status',
          key: 'Status: ',
          content: subscription.status,
          size: 'small',
        },
      ]"
    />
    <Box
      border-style="border-dashed"
      :rows="[
        {
          id: 'name',
          key: 'Name: ',
          content: subscription.subscription_plan.name,
          size: 'small',
        },
        {
          id: 'description',
          key: 'Description: ',
          content: subscription.subscription_plan.description,
          size: 'small',
        },
        {
          id: 'price',
          key: 'Price: ',
          content: subscription.subscription_plan.price.readable,
          size: 'small',
        },
      ]"
    >
      <SubHeader>Plan Info</SubHeader>
    </Box>
    <GenericTable
      :columns="[
        { label: 'Date', key: 'updated_at' },
        { label: 'Amount', key: 'amount.readable' },
        { label: 'Status', key: 'status' },
      ]"
      :rows="subscription.payments"
    >
      <SubHeader>Payments</SubHeader>
    </GenericTable>
    <div v-if="subscription.status === 'pending'" class="flex justify-end gap-4 mt-6">
      <GenericButton @click="cancel" type="button" variant="red">Cancel</GenericButton>
      <GenericButton type="submit" variant="dark-grey" @click="pay">Pay</GenericButton>
    </div>

    <BottomNavigation
      :left="{ name: 'All Plans', route: route('plans.index') }"
      :right="{
        name: 'Plan detail',
        route: route('plans.show', subscription.subscription_plan.id),
      }"
    />
  </div>
</template>
