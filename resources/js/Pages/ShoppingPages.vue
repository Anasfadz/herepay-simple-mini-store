<script setup>
import ProductCard from '@/Components/ProductCard.vue'
import ProductModal from '@/Components/ProductModal.vue'
import CartSidebar from '@/Components/CartSidebar.vue'
import HeaderBar from '@/Components/Header.vue'
import FooterBar from '@/Components/Footer.vue'
import { ref, computed, onMounted } from 'vue'

const products = ref([])

onMounted(async () => {
  try {
    const res = await fetch('http://localhost:8000/api/products')
    const data = await res.json()

    // Map API data ke format yang kau nak
    products.value = data.map(item => ({
      id: item.id,
      name: item.name,
      short_description: item.short_description,
      description: item.description,
      price: parseFloat(item.price), // convert string ke number
      image: item.image
    }))
  } catch (err) {
    console.error('Error fetch products:', err)
  }
})

const selected = ref(null)
const showModal = ref(false)

const cart = ref([])
const cartOpen = ref(false)

function openProduct(p) {
  selected.value = p
  showModal.value = true
}

function addToCart(product, qty = 1) {
  const idx = cart.value.findIndex(i => i.id === product.id)
  if (idx === -1) {
    cart.value.push({ ...product, qty })
  } else {
    cart.value[idx].qty += qty
  }
  cartOpen.value = true
}

function removeFromCart(productId) {
  cart.value = cart.value.filter(i => i.id !== productId)
}

function updateQty(productId, qty) {
  const item = cart.value.find(i => i.id === productId)
  if (item) item.qty = Math.max(1, qty)
}

const subtotal = computed(() =>
  cart.value.reduce((s, i) => s + (i.price * i.qty), 0)
)
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <HeaderBar :cart-count="cart.length" @toggle-cart="cartOpen = !cartOpen" />

    <main class="container mx-auto px-4 py-8 flex-1">
      <!-- Hero -->
      <section class="mb-8 rounded-lg bg-gradient-to-r from-indigo-500 to-pink-500 text-white p-8 shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
          <div>
            <h1 class="text-3xl font-extrabold">Pasar Online</h1>
            <p class="mt-2 opacity-90">Barang terpilih, penghantaran cepat. Klik produk untuk detail.</p>
          </div>
          <div class="mt-4 md:mt-0">
            <button @click="cartOpen = true"
                    class="bg-white text-indigo-600 font-semibold px-4 py-2 rounded shadow">
              Buka Troli ({{ cart.length }})
            </button>
          </div>
        </div>
      </section>

      <!-- Products grid -->
      <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <ProductCard
            v-for="p in products"
            :key="p.id"
            :product="p"
            @add="addToCart"
          />
        </div>
      </section>
    </main>

    <FooterBar />

    <!-- Product modal -->
    <ProductModal
      v-if="showModal"
      :product="selected"
      @add="addToCart"
    />

    <!-- Cart sidebar -->
    <CartSidebar
      :open="cartOpen"
      :items="cart"
      :subtotal="subtotal"
      @close="cartOpen = false"
      @remove="removeFromCart"
      @update-qty="updateQty"
      @clear-cart="cart = []" 
    />
  </div>
</template>
