<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue'
import { router } from '@inertiajs/vue3'
import MainHeader from '@/Components/Header/MainHeader.vue'
import Box from '@/Components/Box/Box.vue'
import BottomNavigation from '@/Components/Navigation/BottomNavigation.vue'
import GenericButton from '@/Components/Button/GenericButton.vue'

const { subscriptionPlan, user } = defineProps({
  subscriptionPlan: Object,
  user: Object,
})

defineOptions({ layout: BaseLayout })

function createSubscription() {
  router.post(route('subscriptions.store'), {
    subscription_plan_id: subscriptionPlan.id,
  })
}

function getActiveSubscription(planId) {
  return user.active_subscriptions?.find(
    (sub) => sub.subscription_plan_id === planId && sub.status === 'active'
  )
}

const activeSubscription = getActiveSubscription(subscriptionPlan.id)

function goToSubscription(subscription) {
  router.visit(route('subscriptions.show', subscription.id))
}
</script>

<template>
  <div class="mx-auto py-10 space-y-8">
    <MainHeader>Plan detail</MainHeader>

    <Box
      :rows="[
        { id: 'amount', key: 'Amount: ', content: subscriptionPlan.price.readable, size: 'small' },
        { id: 'plan', key: 'Plan: ', content: subscriptionPlan.name, size: 'small' },
      ]"
    />

    <div class="flex justify-end gap-4 mt-6">
      <GenericButton
        v-if="!activeSubscription"
        type="button"
        @click="createSubscription()"
        variant="dark-grey"
        >Buy
      </GenericButton>

      <GenericButton
        v-else
        type="button"
        @click="goToSubscription(activeSubscription)"
        variant="dark-grey"
        >View Active Subscription
      </GenericButton>
    </div>

    <BottomNavigation :left="{ name: 'All Plans', route: route('plans.index') }" />
  </div>
</template>
