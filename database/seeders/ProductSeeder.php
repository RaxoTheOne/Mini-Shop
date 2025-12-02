<?php

namespace Database\Seeders;

use App\Models\Category;
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
        // Kategorien holen (über Slug)
        $elektronik = Category::where('slug', 'elektronik')->first();
        $kleidung = Category::where('slug', 'kleidung')->first();
        $buecher = Category::where('slug', 'buecher')->first();
        $sport = Category::where('slug', 'sport-freizeit')->first();

        // Prüfe ob alle Kategorien gefunden wurden
        if (!$elektronik || !$kleidung || !$buecher || !$sport) {
            dd([
                'elektronik' => $elektronik?->name,
                'kleidung' => $kleidung?->name,
                'buecher' => $buecher?->name,
                'sport' => $sport?->name,
            ]);
        }

        $products = [
            // Elektronik
            [
                'category_id' => $elektronik->id,
                'name' => 'Laptop Dell XPS 15',
                'description' => 'Leistungsstarker Laptop mit 16GB RAM, 512GB SSD und Intel Core i7 Prozessor. Perfekt für Arbeit und Gaming.',
                'price' => 1299.99,
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'iPhone 15 Pro',
                'description' => 'Das neueste iPhone mit fortschrittlicher Kamera und A17 Pro Chip. 256GB Speicher.',
                'price' => 1149.00,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Sony WH-1000XM5 Kopfhörer',
                'description' => 'Noise-Cancelling Kopfhörer mit exzellenter Klangqualität und langer Akkulaufzeit.',
                'price' => 399.99,
                'stock' => 20,
                'is_active' => true,
            ],

            // Kleidung
            [
                'category_id' => $kleidung->id,
                'name' => 'Baumwoll T-Shirt',
                'description' => 'Bequemes T-Shirt aus 100% Bio-Baumwolle. In verschiedenen Farben erhältlich.',
                'price' => 24.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $kleidung->id,
                'name' => 'Jeans Classic Fit',
                'description' => 'Klassische Jeans im modernen Schnitt. Sehr bequem und langlebig.',
                'price' => 79.99,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $kleidung->id,
                'name' => 'Winterjacke',
                'description' => 'Warme Winterjacke mit wasserabweisender Oberfläche. Perfekt für kalte Tage.',
                'price' => 149.99,
                'stock' => 25,
                'is_active' => true,
            ],

            // Bücher
            [
                'category_id' => $buecher->id,
                'name' => 'Der Herr der Ringe',
                'description' => 'Das epische Fantasy-Epos von J.R.R. Tolkien. Ungekürzte Ausgabe.',
                'price' => 29.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_id' => $buecher->id,
                'name' => 'Programmieren lernen mit PHP',
                'description' => 'Ein praktischer Leitfaden für Anfänger, um PHP von Grund auf zu erlernen.',
                'price' => 34.99,
                'stock' => 35,
                'is_active' => true,
            ],
            [
                'category_id' => $buecher->id,
                'name' => 'Kochbuch: Mediterrane Küche',
                'description' => 'Über 100 Rezepte aus der mediterranen Küche mit wunderschönen Fotos.',
                'price' => 39.99,
                'stock' => 20,
                'is_active' => true,
            ],

            // Sport & Freizeit
            [
                'category_id' => $sport->id,
                'name' => 'Yoga-Matte Premium',
                'description' => 'Rutschfeste Yoga-Matte mit extra Dämpfung. Ideal für alle Yoga-Übungen.',
                'price' => 49.99,
                'stock' => 45,
                'is_active' => true,
            ],
            [
                'category_id' => $sport->id,
                'name' => 'Laufschuhe Sport Pro',
                'description' => 'Professionelle Laufschuhe mit Dämpfung und Atmungsaktivität. Für alle Laufstile.',
                'price' => 119.99,
                'stock' => 28,
                'is_active' => true,
            ],
            [
                'category_id' => $sport->id,
                'name' => 'Fahrradhelm Sicher',
                'description' => 'Leichter und sicherer Fahrradhelm mit Belüftung. Erfüllt alle Sicherheitsstandards.',
                'price' => 59.99,
                'stock' => 32,
                'is_active' => true,
            ],

            // Weitere Elektronik-Produkte
            [
                'category_id' => $elektronik->id,
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Flaggschiff-Smartphone mit 256GB Speicher, 200MP Kamera und S Pen.',
                'price' => 1249.00,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Apple AirPods Pro 2',
                'description' => 'Noise-Cancelling Earbuds mit Spatial Audio und MagSafe Ladecase.',
                'price' => 279.00,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'iPad Air 11"',
                'description' => 'Leistungsstarkes Tablet mit M2 Chip, 256GB Speicher und Apple Pencil Support.',
                'price' => 799.00,
                'stock' => 18,
                'is_active' => true,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Logitech MX Master 3S',
                'description' => 'Ergonomische Maus für Produktivität mit präziser Tracking-Technologie.',
                'price' => 99.99,
                'stock' => 30,
                'is_active' => true,
            ],

            // Weitere Kleidungsstücke
            [
                'category_id' => $kleidung->id,
                'name' => 'Kapuzenpullover Basic',
                'description' => 'Bequemer Kapuzenpullover aus weicher Baumwolle. Perfekt für den Alltag.',
                'price' => 49.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_id' => $kleidung->id,
                'name' => 'Sneaker Classic',
                'description' => 'Zeitlose Sneaker im klassischen Design. Bequem und vielseitig einsetzbar.',
                'price' => 89.99,
                'stock' => 35,
                'is_active' => true,
            ],
            [
                'category_id' => $kleidung->id,
                'name' => 'Wollmütze',
                'description' => 'Warme Mütze aus 100% Merinowolle. Ideal für kalte Wintertage.',
                'price' => 29.99,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $kleidung->id,
                'name' => 'Sportshorts',
                'description' => 'Atmungsaktive Sportshorts mit elastischem Bund. Perfekt für Training und Sport.',
                'price' => 34.99,
                'stock' => 45,
                'is_active' => true,
            ],

            // Weitere Bücher
            [
                'category_id' => $buecher->id,
                'name' => 'Harry Potter - Gesamtausgabe',
                'description' => 'Alle 7 Bände der Harry Potter Reihe in einer schönen Box.',
                'price' => 89.99,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $buecher->id,
                'name' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'description' => 'Ein Klassiker für jeden Softwareentwickler. Lerne sauberen Code zu schreiben.',
                'price' => 42.99,
                'stock' => 28,
                'is_active' => true,
            ],
            [
                'category_id' => $buecher->id,
                'name' => 'Die Kunst des Krieges',
                'description' => 'Das berühmte Strategiebuch von Sun Tzu. Zeitlos und aktuell.',
                'price' => 12.99,
                'stock' => 60,
                'is_active' => true,
            ],
            [
                'category_id' => $buecher->id,
                'name' => 'Laravel: The Framework Guide',
                'description' => 'Umfassender Leitfaden für die Laravel PHP-Framework Entwicklung.',
                'price' => 49.99,
                'stock' => 22,
                'is_active' => true,
            ],

            // Weitere Sport-Artikel
            [
                'category_id' => $sport->id,
                'name' => 'Dumbbells Set 2x10kg',
                'description' => 'Hantelset mit verstellbaren Gewichten. Ideal für Heimtraining.',
                'price' => 79.99,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $sport->id,
                'name' => 'Wasserdichte Sportuhr',
                'description' => 'Robuste Sportuhr mit GPS, Herzfrequenzmesser und vielen Sportmodi.',
                'price' => 199.99,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $sport->id,
                'name' => 'Yoga-Block Set (2 Stück)',
                'description' => 'Hochwertige Yoga-Blöcke aus Kork. Unterstützen bei verschiedenen Yoga-Positionen.',
                'price' => 24.99,
                'stock' => 38,
                'is_active' => true,
            ],
            [
                'category_id' => $sport->id,
                'name' => 'Fitnessmatte Premium',
                'description' => 'Extra dicke Fitnessmatte mit rutschfester Oberfläche. Ideal für Yoga und Pilates.',
                'price' => 39.99,
                'stock' => 42,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'image' => $product['image'] ?? null,
                'is_active' => $product['is_active'],
            ]);
        }
    }
}