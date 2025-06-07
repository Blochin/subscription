<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue'
import Box from '@/Components/Box/Box.vue'
import { router } from '@inertiajs/vue3'
import MainHeader from '@/Components/Header/MainHeader.vue'

defineOptions({ layout: BaseLayout })

const { subscriptionPlans, user } = defineProps({
  subscriptionPlans: Array,
  user: Object,
})

function getActiveSubscription(planId) {
  return user.active_subscriptions?.find(
    (sub) => sub.subscription_plan_id === planId && sub.status === 'active'
  )
}

function handleClick(plan) {
  const subscription = getActiveSubscription(plan.id)
  if (subscription) {
    router.visit(route('subscriptions.show', subscription.id))
  } else {
    router.visit(route('plans.show', plan.id))
  }
}

function getBoxColumns(plan) {
  return [
    {
      id: 'name',
      content: plan.name,
      size: 'medium',
    },
    {
      id: 'description',
      content: plan.description,
      size: 'small',
    },
    {
      id: 'price',
      content: plan.price.readable,
      size: 'large',
    },
  ]
}
</script>

<template>
  <div>
    <MainHeader>Plans</MainHeader>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
      <Box
        v-for="plan in subscriptionPlans"
        :key="plan.id"
        :rows="getBoxColumns(plan)"
        @click="() => handleClick(plan)"
      />
    </div>
  </div>
</template>

<style scoped></style>
