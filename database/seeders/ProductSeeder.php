<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Men's collection
            [
                'name' => 'Noir Absolu',
                'category' => 'men',
                'concentration' => 'Eau de Parfum',
                'size_ml' => 100,
                'price_cents' => 9800000,
                'stock' => 24,
                'top_notes' => 'Bergamot, Black Pepper',
                'heart_notes' => 'Leather, Cedarwood',
                'base_notes' => 'Amber, Oud',
                'featured' => true,
                'description' => 'A commanding, smoky signature built on leather and oud — for the man who enters a room before he speaks.',
            ],
            [
                'name' => 'Onyx Steel',
                'category' => 'men',
                'concentration' => 'Eau de Toilette',
                'size_ml' => 100,
                'price_cents' => 7500000,
                'stock' => 30,
                'top_notes' => 'Grapefruit, Mint',
                'heart_notes' => 'Sage, Vetiver',
                'base_notes' => 'Musk, Ambroxan',
                'featured' => false,
                'description' => 'Sharp and metallic-fresh, Onyx Steel channels cool confidence with a clean, modern edge.',
            ],
            [
                'name' => 'Cedar & Smoke',
                'category' => 'men',
                'concentration' => 'Eau de Parfum',
                'size_ml' => 75,
                'price_cents' => 8500000,
                'stock' => 18,
                'top_notes' => 'Cardamom, Pink Pepper',
                'heart_notes' => 'Cedarwood, Tobacco Leaf',
                'base_notes' => 'Smoked Vanilla, Sandalwood',
                'featured' => false,
                'description' => 'Warm tobacco and smoked vanilla wrapped in cedar — an evening scent with quiet intensity.',
            ],
            [
                'name' => 'Blue Marine',
                'category' => 'men',
                'concentration' => 'Eau de Toilette',
                'size_ml' => 100,
                'price_cents' => 6500000,
                'stock' => 35,
                'top_notes' => 'Sea Salt, Bergamot',
                'heart_notes' => 'Marine Accord, Geranium',
                'base_notes' => 'Driftwood, White Musk',
                'featured' => false,
                'description' => 'An open-water freshness for daylight hours — crisp, clean, and endlessly wearable.',
            ],

            // Women's collection
            [
                'name' => 'Rose Élysée',
                'category' => 'women',
                'concentration' => 'Eau de Parfum',
                'size_ml' => 100,
                'price_cents' => 10500000,
                'stock' => 22,
                'top_notes' => 'Pink Pepper, Bergamot',
                'heart_notes' => 'Turkish Rose, Peony',
                'base_notes' => 'White Musk, Sandalwood',
                'featured' => true,
                'description' => 'A luminous rose at its heart, softened by musk — timeless, romantic, unmistakably elegant.',
            ],
            [
                'name' => 'Velour Vanille',
                'category' => 'women',
                'concentration' => 'Eau de Parfum',
                'size_ml' => 75,
                'price_cents' => 9500000,
                'stock' => 20,
                'top_notes' => 'Mandarin, Saffron',
                'heart_notes' => 'Jasmine, Orchid',
                'base_notes' => 'Vanilla Bourbon, Tonka Bean',
                'featured' => true,
                'description' => 'Gourmand and radiant, Velour Vanille wraps jasmine in warm vanilla for a scent that lingers on skin.',
            ],
            [
                'name' => 'Jardin Blanc',
                'category' => 'women',
                'concentration' => 'Eau de Toilette',
                'size_ml' => 100,
                'price_cents' => 7200000,
                'stock' => 28,
                'top_notes' => 'Green Fig, Citrus Blossom',
                'heart_notes' => 'Jasmine Sambac, Lily of the Valley',
                'base_notes' => 'Cedarwood, White Musk',
                'featured' => false,
                'description' => 'A sun-lit white-floral garden captured in a bottle — fresh, feminine, effortless.',
            ],
            [
                'name' => 'Amber Nuit',
                'category' => 'women',
                'concentration' => 'Parfum',
                'size_ml' => 50,
                'price_cents' => 11800000,
                'stock' => 14,
                'top_notes' => 'Blackcurrant, Plum',
                'heart_notes' => 'Amber, Iris',
                'base_notes' => 'Patchouli, Vanilla',
                'featured' => false,
                'description' => 'Deep amber and dark fruit for after dark — sensual, rich, and long-lasting.',
            ],

            // Unisex collection
            [
                'name' => 'Santal Mirage',
                'category' => 'unisex',
                'concentration' => 'Eau de Parfum',
                'size_ml' => 100,
                'price_cents' => 11200000,
                'stock' => 20,
                'top_notes' => 'Cardamom, Bergamot',
                'heart_notes' => 'Sandalwood, Rose',
                'base_notes' => 'Musk, Amber',
                'featured' => true,
                'description' => 'Creamy sandalwood at its core, balanced between warmth and restraint — a modern classic for everyone.',
            ],
            [
                'name' => 'Neutral Skin',
                'category' => 'unisex',
                'concentration' => 'Eau de Parfum',
                'size_ml' => 100,
                'price_cents' => 8800000,
                'stock' => 26,
                'top_notes' => 'White Tea, Citrus',
                'heart_notes' => 'Iris, Ambrette',
                'base_notes' => 'Musk, Cashmeran',
                'featured' => false,
                'description' => 'A "skin scent" designed to feel like you, only more so — soft musk with barely-there warmth.',
            ],
            [
                'name' => 'Oud Infini',
                'category' => 'unisex',
                'concentration' => 'Parfum',
                'size_ml' => 50,
                'price_cents' => 15500000,
                'stock' => 10,
                'top_notes' => 'Saffron, Rose',
                'heart_notes' => 'Oud, Leather',
                'base_notes' => 'Amber, Patchouli',
                'featured' => true,
                'description' => 'The house\'s most opulent creation — rare oud layered with saffron and leather for a truly statement scent.',
            ],
            [
                'name' => 'Green Bergamot',
                'category' => 'unisex',
                'concentration' => 'Eau de Toilette',
                'size_ml' => 100,
                'price_cents' => 5800000,
                'stock' => 32,
                'top_notes' => 'Bergamot, Basil',
                'heart_notes' => 'Green Tea, Fig Leaf',
                'base_notes' => 'Vetiver, White Musk',
                'featured' => false,
                'description' => 'Bright and herbaceous, an everyday fresh scent that suits any wardrobe, any season.',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'category' => $product['category'],
                'description' => $product['description'],
                'concentration' => $product['concentration'],
                'size_ml' => $product['size_ml'],
                'top_notes' => $product['top_notes'],
                'heart_notes' => $product['heart_notes'],
                'base_notes' => $product['base_notes'],
                'featured' => $product['featured'],
                'price_cents' => $product['price_cents'],
                'image' => null,
                'stock' => $product['stock'],
            ]);
        }
    }
}
