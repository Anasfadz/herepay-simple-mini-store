<script setup>
defineProps({
  product: Object
})
const emit = defineEmits(['view','add'])
function view() { emit('view', product) }
function add() { emit('add', product, 1) }
</script>

<template>
  <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-md transition">
    <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
      <img :src="product.image" alt="" class="object-cover h-full w-full" />
    </div>
    <div class="p-4">
      <h3 class="font-semibold text-lg truncate">{{ product.name }}</h3>
      <p class="text-sm text-gray-500 mt-1">{{ product.short_description }}</p>
      <div class="mt-3 flex items-center justify-between">
        <div class="text-indigo-600 font-bold">RM {{ product.price.toFixed(2) }}</div>
        <div class="flex gap-2">
          <button @click="$emit('add', product)" class="bg-green-500 text-white px-3 py-1 rounded">Tambah</button>
        </div>
      </div>
    </div>
  </div>
</template>
