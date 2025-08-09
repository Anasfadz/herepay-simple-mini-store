<script setup>
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  cartCount: { type: Number, default: 0 },
  canLogin: { type: Boolean, default: false },
  canRegister: { type: Boolean, default: false },
})
const emit = defineEmits(['toggle-cart'])
</script>

<template>
  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <div class="text-indigo-600 font-bold text-xl">LOGO</div>
      </div>

      <div class="flex items-center gap-4">
        <!-- CART ICON -->
        <button @click="$emit('toggle-cart')" class="relative">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6.4A1 1 0 0 0 6.8 21h10.4a1 1 0 0 0 .99-.86L19 13M7 13H5.4" />
          </svg>
          <span v-if="cartCount" class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-1">
            {{ cartCount }}
          </span>
        </button>

        <!-- <a href="/login" class="hover:text-indigo-600">Login</a>
        <a href="/register" class="hover:text-indigo-600">Register</a> -->

        <a href="/login" class="hover:text-indigo-600">👤</a>
      </div>
    </div>
  </header>
</template>
