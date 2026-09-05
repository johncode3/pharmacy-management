<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Staff Accounts
        User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@pharmacy.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Lead Pharmacist',
            'email' => 'pharmacist@pharmacy.com',
            'password' => Hash::make('123456'),
            'role' => 'pharmacist',
        ]);

        User::create([
            'name' => 'POS Cashier',
            'email' => 'cashier@pharmacy.com',
            'password' => Hash::make('123456'),
            'role' => 'cashier',
        ]);

        // 2. Create Master Categories
        $painkillers = Category::create([
            'name' => 'Painkillers & Fever',
            'description' => 'Analgesics and antipyretics for pain relief and fever reduction',
        ]);

        $antibiotics = Category::create([
            'name' => 'Antibiotics',
            'description' => 'Prescription antibacterial medications',
        ]);

        $vitamins = Category::create([
            'name' => 'Vitamins & Supplements',
            'description' => 'Dietary supplements and immune system boosters',
        ]);

        $syrups = Category::create([
            'name' => 'Cough & Cold Syrups',
            'description' => 'Liquid formulations for respiratory relief and cough',
        ]);

        $skincare = Category::create([
            'name' => 'Skin Care & Antiseptics',
            'description' => 'Topical creams, ointments, and antiseptic solutions',
        ]);

        // 3. Create 25 Realistic Medicines
        $medicines = [
            // --- Painkillers (Category 1) ---
            [
                'category_id' => $painkillers->id,
                'name' => 'Panadol Extra 500mg',
                'generic_name' => 'Paracetamol + Caffeine',
                'barcode' => 'MED-10001',
                'price' => 2.50,
                'cost' => 1.20,
                'stock_quantity' => 150,
                'expiry_date' => Carbon::now()->addMonths(18),
            ],
            [
                'category_id' => $painkillers->id,
                'name' => 'Ibuprofen 400mg',
                'generic_name' => 'Ibuprofen',
                'barcode' => 'MED-10002',
                'price' => 3.20,
                'cost' => 1.60,
                'stock_quantity' => 80,
                'expiry_date' => Carbon::now()->addMonths(12),
            ],
            [
                'category_id' => $painkillers->id,
                'name' => 'Aspirin Cardio 100mg',
                'generic_name' => 'Acetylsalicylic Acid',
                'barcode' => 'MED-10003',
                'price' => 4.50,
                'cost' => 2.80,
                'stock_quantity' => 60,
                'expiry_date' => Carbon::now()->addMonths(9),
            ],
            [
                'category_id' => $painkillers->id,
                'name' => 'Voltaren Emulgel 50g',
                'generic_name' => 'Diclofenac Diethylammonium',
                'barcode' => 'MED-10004',
                'price' => 6.80,
                'cost' => 4.20,
                'stock_quantity' => 25,
                'expiry_date' => Carbon::now()->addMonths(15),
            ],
            [
                'category_id' => $painkillers->id,
                'name' => 'Tramadol 50mg Capsules',
                'generic_name' => 'Tramadol Hydrochloride',
                'barcode' => 'MED-10005',
                'price' => 5.50,
                'cost' => 3.00,
                'stock_quantity' => 5,
                'expiry_date' => Carbon::now()->addMonths(10),
            ],

            // --- Antibiotics (Category 2) ---
            [
                'category_id' => $antibiotics->id,
                'name' => 'Amoxicillin 500mg',
                'generic_name' => 'Amoxicillin Trihydrate',
                'barcode' => 'MED-20001',
                'price' => 5.00,
                'cost' => 2.90,
                'stock_quantity' => 8,
                'expiry_date' => Carbon::now()->addMonths(6),
            ],
            [
                'category_id' => $antibiotics->id,
                'name' => 'Augmentin 625mg',
                'generic_name' => 'Amoxicillin + Clavulanate Potassium',
                'barcode' => 'MED-20002',
                'price' => 12.50,
                'cost' => 8.00,
                'stock_quantity' => 45,
                'expiry_date' => Carbon::now()->addYear(),
            ],
            [
                'category_id' => $antibiotics->id,
                'name' => 'Azithromycin 250mg',
                'generic_name' => 'Azithromycin Dihydrate',
                'barcode' => 'MED-20003',
                'price' => 8.20,
                'cost' => 4.50,
                'stock_quantity' => 30,
                'expiry_date' => Carbon::now()->addMonths(11),
            ],
            [
                'category_id' => $antibiotics->id,
                'name' => 'Ciprofloxacin 500mg',
                'generic_name' => 'Ciprofloxacin HCl',
                'barcode' => 'MED-20004',
                'price' => 7.00,
                'cost' => 3.80,
                'stock_quantity' => 14,
                'expiry_date' => Carbon::now()->addDays(20),
            ],
            [
                'category_id' => $antibiotics->id,
                'name' => 'Cephalexin 500mg',
                'generic_name' => 'Cefalexin Monohydrate',
                'barcode' => 'MED-20005',
                'price' => 6.50,
                'cost' => 3.50,
                'stock_quantity' => 40,
                'expiry_date' => Carbon::now()->addMonths(14),
            ],

            // --- Vitamins & Supplements (Category 3) ---
            [
                'category_id' => $vitamins->id,
                'name' => 'Berocca Performance 15s',
                'generic_name' => 'Multivitamins + Minerals + Zinc',
                'barcode' => 'MED-30001',
                'price' => 9.50,
                'cost' => 6.00,
                'stock_quantity' => 70,
                'expiry_date' => Carbon::now()->addMonths(20),
            ],
            [
                'category_id' => $vitamins->id,
                'name' => 'Vitamin C 1000mg Effervescent',
                'generic_name' => 'Ascorbic Acid',
                'barcode' => 'MED-30002',
                'price' => 4.20,
                'cost' => 2.40,
                'stock_quantity' => 100,
                'expiry_date' => Carbon::now()->addYear(),
            ],
            [
                'category_id' => $vitamins->id,
                'name' => 'Centrum Silver Adults 60s',
                'generic_name' => 'Complete Multivitamin Formula',
                'barcode' => 'MED-30003',
                'price' => 18.00,
                'cost' => 12.00,
                'stock_quantity' => 4,
                'expiry_date' => Carbon::now()->addMonths(16),
            ],
            [
                'category_id' => $vitamins->id,
                'name' => 'Blackmores Fish Oil 1000mg',
                'generic_name' => 'Omega-3 Marine Triglycerides',
                'barcode' => 'MED-30004',
                'price' => 14.50,
                'cost' => 9.20,
                'stock_quantity' => 55,
                'expiry_date' => Carbon::now()->addMonths(13),
            ],
            [
                'category_id' => $vitamins->id,
                'name' => 'Zinc Gluconate 50mg',
                'generic_name' => 'Zinc Gluconate',
                'barcode' => 'MED-30005',
                'price' => 5.20,
                'cost' => 3.00,
                'stock_quantity' => 90,
                'expiry_date' => Carbon::now()->addMonths(22),
            ],

            // --- Syrups (Category 4) ---
            [
                'category_id' => $syrups->id,
                'name' => 'Prospan Cough Syrup 100ml',
                'generic_name' => 'Dried Ivy Leaf Extract',
                'barcode' => 'MED-40001',
                'price' => 7.80,
                'cost' => 4.80,
                'stock_quantity' => 50,
                'expiry_date' => Carbon::now()->addMonths(14),
            ],
            [
                'category_id' => $syrups->id,
                'name' => 'Benadryl Cough Formula 100ml',
                'generic_name' => 'Diphenhydramine HCl',
                'barcode' => 'MED-40002',
                'price' => 4.50,
                'cost' => 2.50,
                'stock_quantity' => 35,
                'expiry_date' => Carbon::now()->addMonths(8),
            ],
            [
                'category_id' => $syrups->id,
                'name' => 'Tussidex Dry Cough 100ml',
                'generic_name' => 'Dextromethorphan HBr',
                'barcode' => 'MED-40003',
                'price' => 3.80,
                'cost' => 2.00,
                'stock_quantity' => 15,
                'expiry_date' => Carbon::now()->subDays(5),
            ],
            [
                'category_id' => $syrups->id,
                'name' => 'Actifed Cold Syrup 100ml',
                'generic_name' => 'Pseudoephedrine + Triprolidine',
                'barcode' => 'MED-40004',
                'price' => 5.20,
                'cost' => 3.10,
                'stock_quantity' => 28,
                'expiry_date' => Carbon::now()->addMonths(7),
            ],
            [
                'category_id' => $syrups->id,
                'name' => 'Gaviscon Double Action 150ml',
                'generic_name' => 'Sodium Alginate + Calcium Carbonate',
                'barcode' => 'MED-40005',
                'price' => 8.50,
                'cost' => 5.20,
                'stock_quantity' => 32,
                'expiry_date' => Carbon::now()->addMonths(18),
            ],

            // --- Skin Care & Topicals (Category 5) ---
            [
                'category_id' => $skincare->id,
                'name' => 'Betadine Antiseptic Ointment 20g',
                'generic_name' => 'Povidone Iodine 10%',
                'barcode' => 'MED-50001',
                'price' => 3.50,
                'cost' => 1.80,
                'stock_quantity' => 65,
                'expiry_date' => Carbon::now()->addMonths(24),
            ],
            [
                'category_id' => $skincare->id,
                'name' => 'Bepanthen Ointment 30g',
                'generic_name' => 'Dexpanthenol 5%',
                'barcode' => 'MED-50002',
                'price' => 5.50,
                'cost' => 3.20,
                'stock_quantity' => 40,
                'expiry_date' => Carbon::now()->addMonths(16),
            ],
            [
                'category_id' => $skincare->id,
                'name' => 'Hydrocortisone 1% Cream 15g',
                'generic_name' => 'Hydrocortisone',
                'barcode' => 'MED-50003',
                'price' => 4.00,
                'cost' => 2.10,
                'stock_quantity' => 7,
                'expiry_date' => Carbon::now()->addMonths(8),
            ],
            [
                'category_id' => $skincare->id,
                'name' => 'Clotrimazole 1% Antifungal 20g',
                'generic_name' => 'Clotrimazole',
                'barcode' => 'MED-50004',
                'price' => 3.80,
                'cost' => 1.90,
                'stock_quantity' => 50,
                'expiry_date' => Carbon::now()->addMonths(19),
            ],
            [
                'category_id' => $skincare->id,
                'name' => 'Counterpain Analgesic Balm 60g',
                'generic_name' => 'Methyl Salicylate + Menthol',
                'barcode' => 'MED-50005',
                'price' => 4.80,
                'cost' => 2.70,
                'stock_quantity' => 48,
                'expiry_date' => Carbon::now()->addMonths(21),
            ],
        ];

        // Insert and assign dynamic business status
        foreach ($medicines as $med) {
            $expiry = $med['expiry_date'];
            if ($expiry->isPast() || $expiry->isToday()) {
                $med['status'] = 'Expired';
            } elseif ($med['stock_quantity'] <= 10) {
                $med['status'] = 'Low Stock';
            } else {
                $med['status'] = 'Available';
            }
            Medicine::create($med);
        }
    }
}