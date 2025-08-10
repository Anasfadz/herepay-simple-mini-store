<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Product List
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Senarai Produk</h2>
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Gambar</th>
                                    <th class="border px-4 py-2 text-left">Nama</th>
                                    <th class="border px-4 py-2 text-left">Deskripsi Ringkas</th>
                                    <th class="border px-4 py-2 text-left">Harga (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-4 py-2">
                                        <img src="https://vibiznews.com/wp-content/uploads/2021/03/coffee.jpg" alt="Kopi Arabica" class="w-20 h-20 object-cover rounded">
                                    </td>
                                    <td class="border px-4 py-2 font-medium">Kopi Arabica</td>
                                    <td class="border px-4 py-2">Kopi premium dari Brazil</td>
                                    <td class="border px-4 py-2">25.50</td>
                                </tr>
                                <tr>
                                    <td class="border px-4 py-2">
                                        <img src="https://res.cloudinary.com/dk0z4ums3/image/upload/v1617593508/attached_image/memetik-manfaat-teh-hijau-untuk-kesehatan.jpg" alt="Teh Hijau Jepun" class="w-20 h-20 object-cover rounded">
                                    </td>
                                    <td class="border px-4 py-2 font-medium">Teh Hijau Jepun</td>
                                    <td class="border px-4 py-2">Matcha organik</td>
                                    <td class="border px-4 py-2">18.00</td>
                                </tr>
                                <tr>
                                    <td class="border px-4 py-2">
                                        <img src="https://resepichenom.com/images/recipes/Biskut_Double_Chocolate_Chips.jpg" alt="Biskut Coklat" class="w-20 h-20 object-cover rounded">
                                    </td>
                                    <td class="border px-4 py-2 font-medium">Biskut Coklat</td>
                                    <td class="border px-4 py-2">Biskut rangup berintikan coklat</td>
                                    <td class="border px-4 py-2">12.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>