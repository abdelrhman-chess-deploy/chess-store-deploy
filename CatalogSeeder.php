<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'boards' => [
                [
                    'name' => 'Royal Marble Chess Board',
                    'price' => 249.99,
                    'quantity' => 3,
                    'image' => '/products/marble-board.jpg',
                    'description' => 'Hand-carved from genuine white and black marble with a high-polish finish. A weighted, heirloom-grade board that anchors any study or lounge.',
                ],
                [
                    'name' => 'Grandmaster Walnut & Maple Tournament Chess Board',
                    'price' => 149.99,
                    'quantity' => 12,
                    'image' => '/products/walnut-board.jpg',
                    'description' => 'FIDE-sized tournament board in American walnut and hard maple with printed coordinates and a soft matte varnish built for long matches.',
                ],
                [
                    'name' => 'Handcrafted Acacia Wood Chess Board',
                    'price' => 89.99,
                    'quantity' => 20,
                    'image' => '/products/acacia-board.jpg',
                    'description' => 'Handcrafted from solid acacia with a satin finish that brings out the natural grain. A warm, durable board for everyday play and display.',
                ],
            ],
            'pieces' => [
                [
                    'name' => 'Heavy Brass & Charcoal Chrome Championship Pieces',
                    'price' => 320,
                    'quantity' => 3,
                    'image' => '/products/brass-pieces.jpg',
                    'description' => 'Triple-weighted solid brass pieces with a mirror-polished golden finish and felted billiard-cloth bases for silent, decisive moves. Extra queens included.',
                ],
                [
                    'name' => 'Staunton Boxwood & Gabon Ebony Pieces',
                    'price' => 189.99,
                    'quantity' => 8,
                    'image' => '/products/staunton-pieces.jpg',
                    'description' => 'Hand-carved Staunton set in graded boxwood and genuine Gabon ebony, weighted and felted for club and tournament play.',
                ],
                [
                    'name' => 'Imperial Gold & Silver Luxury Chess Pieces',
                    'price' => 450,
                    'quantity' => 2,
                    'image' => '/products/imperial-pieces.jpg',
                    'description' => 'Limited-edition luxury set with mirror gold and silver finishes over weighted metal cores. Sculpted detail worthy of a display cabinet.',
                ],
            ],
            'clocks' => [
                [
                    'name' => 'Retro Mechanical Analog Chess Clock',
                    'price' => 110,
                    'quantity' => 6,
                    'image' => '/products/analog-clock.jpg',
                    'description' => 'Fully mechanical wind-up chess clock with a quiet movement, clear red flags, and tactile buttons. No batteries, pure analog reliability.',
                ],
                [
                    'name' => 'Tempus Digital Tournament Clock',
                    'price' => 125,
                    'quantity' => 15,
                    'image' => '/products/digital-clock.jpg',
                    'description' => 'FIDE-compliant digital tournament clock with Fischer, delay, and increment modes, a high-contrast display, and precise touch levers.',
                ],
            ],
            'accessories' => [
                [
                    'name' => 'Royal Leather Chess Set Carrier Bag',
                    'price' => 95,
                    'quantity' => 10,
                    'image' => '/products/carrier-bag.jpg',
                    'description' => 'Full-grain leather carrier with solid brass hardware and a padded interior that keeps your set, board, and clock protected on the move.',
                ],
                [
                    'name' => 'Grandmaster Knight Badge Gold Suit Pin',
                    'price' => 25,
                    'quantity' => 50,
                    'image' => '/products/knight-pin.jpg',
                    'description' => 'Solid jeweler\'s brass knight pin plated in 18k gold with a secure butterfly clasp. A quiet nod to your obsession.',
                ],
                [
                    'name' => 'Deluxe Chess Pieces Storage Gift Box',
                    'price' => 19.99,
                    'quantity' => 40,
                    'image' => '/products/storage-box.jpg',
                    'description' => 'Matte-black gift box with a divided, cushioned tray that keeps 32 pieces organized and scratch-free. Storage and gift-ready presentation.',
                ],
            ],
        ];

        foreach ($catalog as $slug => $products) {
            $category = Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => ucfirst($slug),
                    'description' => 'Premium chess ' . $slug,
                ]
            );

            foreach ($products as $item) {
                Product::firstOrCreate(
                    ['slug' => Str::slug($item['name'])],
                    [
                        'category_id' => $category->id,
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'image' => $item['image'],
                        'status' => true,
                    ]
                );
            }
        }
    }
}
