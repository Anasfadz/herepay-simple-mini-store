<script setup>
import { ref } from 'vue'
const props = defineProps({
  product: Object
})
const emit = defineEmits(['close','add'])
const qty = ref(1)

function close() { emit('close') }
function add() { emit('add', props.product, qty.value); emit('close') }
</script>

<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50" @click="close"></div>

    <div class="relative bg-white w-11/12 md:w-3/4 lg:w-2/3 rounded-lg shadow-lg overflow-hidden">
      <div class="flex">
        <div class="w-1/2 p-4">
          <img :src="product.image" alt="" class="w-full h-64 object-cover rounded" />
        </div>
        <div class="w-1/2 p-6">
          <div class="flex items-start justify-between">
            <h2 class="text-2xl font-bold">{{ product.name }}</h2>
            <button @click="close" class="text-gray-500">✕</button>
          </div>
          <p class="mt-2 text-gray-600">{{ product.description }}</p>

          <div class="mt-4">
            <div class="text-xl font-semibold">RM {{ product.price.toFixed(2) }}</div>
            <div class="mt-3 flex items-center gap-3">
              <label>Qty</label>
              <input type="number" v-model.number="qty" min="1" class="w-20 border rounded px-2 py-1" />
            </div>
            <div class="mt-4 flex gap-3">
              <button @click="add" class="bg-indigo-600 text-white px-4 py-2 rounded">Tambah ke troli</button>
              <button @click="close" class="px-4 py-2 border rounded">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</template>
