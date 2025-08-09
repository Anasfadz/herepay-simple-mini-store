<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'sku' => 'KOPI-001',
                'name' => 'Kopi Arabica',
                'short_description' => 'Kopi premium dari Brazil',
                'description' => 'Kopi Arabica segar, rasa padu dan wangi.',
                'price' => 25.50,
                'image' => 'https://vibiznews.com/wp-content/uploads/2021/03/coffee.jpg',
                'variants' => [
                    'size' => ['Small', 'Medium', 'Large'],
                    'packaging' => ['Bag', 'Tin']
                ],
                'quantity' => 20,
            ],
            [
                'sku' => 'TEH-001',
                'name' => 'Teh Hijau Jepun',
                'short_description' => 'Matcha organik',
                'description' => 'Teh hijau matcha asli dari Kyoto.',
                'price' => 18.00,
                'image' => 'https://res.cloudinary.com/dk0z4ums3/image/upload/v1617593508/attached_image/memetik-manfaat-teh-hijau-untuk-kesehatan.jpg',
                'variants' => [
                    'size' => ['Small', 'Medium', 'Large'],
                    'packaging' => ['Box', 'Tin']
                ],
                'quantity' => 15,
            ],
            [
                'sku' => 'BIS-001',
                'name' => 'Biskut Coklat',
                'short_description' => 'Biskut rangup berintikan coklat',
                'description' => 'Biskut home-made coklat chip, sedap dimakan panas.',
                'price' => 12.00,
                'image' => 'https://resepichenom.com/images/recipes/Biskut_Double_Chocolate_Chips.jpg',
                'variants' => [
                    'size' => ['Small', 'Medium', 'Large'],
                    'packaging' => ['Plastic', 'Box']
                ],
                'quantity' => 30,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}