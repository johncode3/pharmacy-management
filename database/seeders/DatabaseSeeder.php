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

        $antibiotics = Category::create(['name' => 'Antibiotics', 'description' => 'Prescription antibacterial medications']);
        $painkillers = Category::create(['name' => 'Painkillers', 'description' => 'Pain relief and fever reduction drugs']);
        $vitamins = Category::create(['name' => 'Vitamins & Supplements', 'description' => 'Daily dietary supplements and immune boosters']);
        $syrups = Category::create(['name' => 'Cough & Syrups', 'description' => 'Liquid syrups for cold, cough, and throat']);
        $skincare = Category::create(['name' => 'Skin Care', 'description' => 'Topical creams and antiseptic ointments']);

        Medicine::create([
            'category_id' => $painkillers->id,
            'name' => 'Paracetamol 500mg',
            'generic_name' => 'Acetaminophen',
            'barcode' => 'MED-10001',
            'price' => 2.50,
            'cost' => 1.20,
            'stock_quantity' => 100,
            'expiry_date' => Carbon::now()->addYear(),
            'status' => 'Available',
        ]);

        Medicine::create([
            'category_id' => $antibiotics->id,
            'name' => 'Amoxicillin 500mg',
            'generic_name' => 'Amoxicillin Trihydrate',
            'barcode' => 'MED-10002',
            'price' => 5.00,
            'cost' => 3.00,
            'stock_quantity' => 8,
            'expiry_date' => Carbon::now()->addMonths(6),
            'status' => 'Low Stock',
        ]);

        Medicine::create([
            'category_id' => $vitamins->id,
            'name' => 'Vitamin C 1000mg Effervescent',
            'generic_name' => 'Ascorbic Acid',
            'barcode' => 'MED-10003',
            'price' => 4.20,
            'cost' => 2.50,
            'stock_quantity' => 25,
            'expiry_date' => Carbon::now()->addDays(15),
            'status' => 'Available',
        ]);

        Medicine::create([
            'category_id' => $syrups->id,
            'name' => 'Tussidex Cough Syrup 100ml',
            'generic_name' => 'Dextromethorphan',
            'barcode' => 'MED-10004',
            'price' => 3.80,
            'cost' => 2.00,
            'stock_quantity' => 15,
            'expiry_date' => Carbon::now()->subDays(5),
            'status' => 'Expired',
        ]);
    }
}