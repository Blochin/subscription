<script setup>
defineProps({
  columns: {
    type: Array,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
})

function resolveValue(obj, path) {
  return path.split('.').reduce((acc, part) => acc?.[part], obj)
}
</script>
<template>
  <div v-if="rows && rows.length" class="p-6 border-4 border-black">
    <slot></slot>

    <table class="w-full table-auto border-collapse border border-black">
      <thead>
        <tr class="bg-gray-200">
          <th
            v-for="column in columns"
            :key="column.key"
            class="border border-black px-4 py-2 text-left"
          >
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, rowIndex) in rows" :key="row.id || rowIndex" class="hover:bg-gray-100">
          <td v-for="column in columns" :key="column.key" class="border border-black px-4 py-2">
            {{ resolveValue(row, column.key) }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
