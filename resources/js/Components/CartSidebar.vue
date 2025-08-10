<script setup>
import { watch } from 'vue'
const props = defineProps({
  open: Boolean,
  items: Object,
  subtotal: Number 
})
const emit = defineEmits(['close','remove','update-qty'])
watch(() => props.open, (v) => {
  if (v) document.body.style.overflow = 'hidden'
  else document.body.style.overflow = ''
})
function close() { emit('close') }
function remove(id) { emit('remove', id) }
function changeQty(id, e) { emit('update-qty', id, Number(e.target.value)) }
function checkout() {
  var ids = props.items.map(item => item.id)
  var quantities = props.items.map(item => item.qty)

  axios.post('api/payment', {
    items: ids,
    subtotal: props.subtotal,
    quantities: quantities
  })
  .then(res => {
    if (res.data.status) {
      console.log(res.data)
      emit('clear-cart')
      alert('Thank you for payment!')
    } else {
      alert('Payment failed, please try again.')
    }
  })
  .catch(err => {
    console.error(err)
    alert('Something went wrong!')
  })
}
</script>

<template>
  <transition name="slide">
    <aside v-if="open" class="fixed right-0 top-0 h-full w-full sm:w-96 bg-white shadow-lg z-50 p-4 overflow-auto">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Troli Anda ({{ items.length }})</h3>
        <button @click="close" class="text-gray-600">Tutup</button>
      </div>

      <div v-if="items.length === 0" class="text-gray-500 mt-8">
        Troli kosong — tambah barang dulu!
      </div>

      <div v-else class="space-y-4">
        <div v-for="it in items" :key="it.id" class="flex items-center gap-3 border-b pb-3">
          <img :src="it.image" class="w-16 h-16 object-cover rounded" />
          <div class="flex-1">
            <div class="font-semibold">{{ it.name }}</div>
            <div class="text-sm text-gray-500">RM {{ it.price.toFixed(2) }}</div>
            <div class="mt-2 flex items-center gap-2">
              <input type="number" :value="it.qty" min="1" @change="e => changeQty(it.id, e)"
                     class="w-20 border rounded px-2 py-1" />
              <button @click="() => remove(it.id)" class="text-red-600 text-sm">Buang</button>
            </div>
          </div>
        </div>

        <div class="pt-4">
          <div class="flex items-center justify-between font-bold text-lg">
            <span>Subtotal</span>
            <span>RM {{ subtotal.toFixed(2) }}</span>
          </div>
          <div class="mt-4">
            <button @click="checkout" class="w-full bg-green-600 text-white py-2 rounded font-semibold">
              Checkout
            </button>
          </div>
        </div>
      </div>
    </aside>
  </transition>
</template>

<style scoped>
.slide-enter-active, .slide-leave-active { transition: all .25s ease; }
.slide-enter-from { transform: translateX(200px); opacity: 0; }
.slide-enter-to { transform: translateX(0); opacity: 1; }
.slide-leave-from { transform: translateX(0); opacity: 1; }
.slide-leave-to { transform: translateX(200px); opacity: 0; }
</style>
