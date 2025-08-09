<script setup>
import { ref, reactive, onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'

const products = ref([])

const showModal = ref(false)
const isEditMode = ref(false)
const form = reactive({
  id: null,
  sku: '',
  name: '',
  short_description: '',
  description: '',
  price: '',
  quantity: '',
  image: ''
})

onMounted(async () => {
  try {
    const res = await fetch('http://localhost:8000/api/products')
    const data = await res.json()

    products.value = data.map(item => ({
      id: item.id,
      sku: item.sku || '',
      name: item.name,
      short_description: item.short_description,
      description: item.description || '',
      price: parseFloat(item.price),
      quantity: parseInt(item.quantity),
      image: item.image
    }))
  } catch (err) {
    console.error('Error fetch products:', err)
  }
})

function resetForm() {
  form.id = null
  form.sku = ''
  form.name = ''
  form.short_description = ''
  form.description = ''
  form.price = ''
  form.quantity = ''
  form.image = ''
}

function openAddModal() {
  resetForm()
  isEditMode.value = false
  showModal.value = true
}

function openEditModal(product) {
  form.id = product.id
  form.sku = product.sku
  form.name = product.name
  form.short_description = product.short_description
  form.description = product.description || ''
  form.price = product.price
  form.quantity = product.quantity
  form.image = product.image
  isEditMode.value = true
  showModal.value = true
}

function closeModal() {
  showModal.value = false
}

async function saveProduct() {
  console.log('Form data hendak dihantar:', { ...form })

  if (
    !form.sku ||
    !form.name ||
    !form.short_description ||
    !form.description ||
    !form.price ||
    form.quantity === '' || // quantity boleh 0 jadi kena check strict
    !form.image
  ) {
    alert('Sila lengkapkan semua medan')
    return
  }

  try {
    if (isEditMode.value) {
      const res = await axios.put(`http://localhost:8000/api/products/${form.id}`, {
        sku: form.sku,
        name: form.name,
        short_description: form.short_description,
        description: form.description,
        price: parseFloat(form.price),
        quantity: parseInt(form.quantity),
        image: form.image,
        variants: null
      })

      const idx = products.value.findIndex(p => p.id === form.id)
      if (idx !== -1) {
        products.value[idx] = res.data
      }

      alert('Produk berjaya dikemaskini')
    } else {
      const res = await axios.post('http://localhost:8000/api/products', {
        sku: form.sku,
        name: form.name,
        short_description: form.short_description,
        description: form.description,
        price: parseFloat(form.price),
        quantity: parseInt(form.quantity),
        image: form.image,
        variants: null
      })

      products.value.push(res.data)
      alert('Produk berjaya ditambah')
    }

    closeModal()
  } catch (error) {
    console.error(error)
    alert('Ralat berlaku: ' + (error.response?.data?.message || error.message))
  }
}

async function handleDelete(id) {
  const confirmed = confirm('Anda pasti mahu padam produk ini?')
  if (!confirmed) return

  try {
    await axios.delete(`http://localhost:8000/api/products/${id}`)
    products.value = products.value.filter(p => p.id !== id)
    alert('Produk berjaya dipadam')
  } catch (error) {
    console.error(error)
    alert('Ralat berlaku: ' + (error.response?.data?.message || error.message))
  }
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Product List
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-bold">Senarai Produk</h2>
              <button
                @click="openAddModal"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
              >
                Add
              </button>
            </div>

            <table class="min-w-full border border-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="border px-4 py-2 text-left">No.</th>
                  <th class="border px-4 py-2 text-left">SKU</th>
                  <th class="border px-4 py-2 text-left">Gambar</th>
                  <th class="border px-4 py-2 text-left">Nama</th>
                  <th class="border px-4 py-2 text-left">Deskripsi Ringkas</th>
                  <th class="border px-4 py-2 text-left">Harga (RM)</th>
                  <th class="border px-4 py-2 text-left">Quantity</th>
                  <th class="border px-4 py-2 text-left">Tindakan</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in products" :key="product.id">
                  <td class="border px-4 py-2">{{ index + 1 }}</td>
                  <td class="border px-4 py-2 font-mono">{{ product.sku }}</td>
                  <td class="border px-4 py-2">
                    <img
                      :src="product.image"
                      :alt="product.name"
                      class="w-20 h-20 object-cover rounded"
                    />
                  </td>
                  <td class="border px-4 py-2 font-medium">{{ product.name }}</td>
                  <td class="border px-4 py-2">{{ product.short_description }}</td>
                  <td class="border px-4 py-2">{{ product.price.toFixed(2) }}</td>
                  <td class="border px-4 py-2 text-center">{{ product.quantity }}</td>
                  <td class="border px-4 py-2 space-x-2">
                    <button
                      @click="openEditModal(product)"
                      class="bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500"
                    >
                      Edit
                    </button>
                    <button
                      @click="handleDelete(product.id)"
                      class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <div v-if="products.length === 0" class="mt-4 text-center text-gray-500">
              Tiada produk untuk dipaparkan.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg w-96 p-6 relative">
        <h3 class="text-lg font-bold mb-4">
          {{ isEditMode ? 'Edit Produk' : 'Tambah Produk' }}
        </h3>

        <form
          @submit.prevent="saveProduct"
          class="space-y-4"
        >
          <div>
            <label class="block mb-1 font-semibold">SKU</label>
            <input
              v-model="form.sku"
              type="text"
              class="w-full border border-gray-300 rounded px-3 py-2 font-mono"
              required
            />
          </div>

          <div>
            <label class="block mb-1 font-semibold">Nama</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full border border-gray-300 rounded px-3 py-2"
              required
            />
          </div>

          <div>
            <label class="block mb-1 font-semibold">Deskripsi Ringkas</label>
            <input
              v-model="form.short_description"
              type="text"
              class="w-full border border-gray-300 rounded px-3 py-2"
              required
            />
          </div>

          <div>
            <label class="block mb-1 font-semibold">Deskripsi</label>
            <input
              v-model="form.description"
              type="text"
              class="w-full border border-gray-300 rounded px-3 py-2"
              required
            />
          </div>

          <div>
            <label class="block mb-1 font-semibold">Harga (RM)</label>
            <input
              v-model.number="form.price"
              type="number"
              step="0.01"
              min="0"
              class="w-full border border-gray-300 rounded px-3 py-2"
              required
            />
          </div>

          <div>
            <label class="block mb-1 font-semibold">Quantity</label>
            <input
              v-model.number="form.quantity"
              type="number"
              min="0"
              class="w-full border border-gray-300 rounded px-3 py-2"
              required
            />
          </div>

          <div>
            <label class="block mb-1 font-semibold">URL Gambar</label>
            <input
              v-model="form.image"
              type="text"
              class="w-full border border-gray-300 rounded px-3 py-2"
              required
            />
          </div>

          <div class="flex justify-end space-x-2 pt-4">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 border rounded hover:bg-gray-100"
            >
              Batal
            </button>
            <button
              type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
