<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            CommoditiesSeeder::class,
            ServiceSeeder::class,
            PortfolioSeeder::class,
            ReviewsSeeder::class,
            VacanciesSeeder::class,

        ]);

        DB::table('canopy_pricing_settings')->insert([
            'base_price_per_m2' => 3000,
            'materials_coef' => 1.2,
            'consumables_coef' => 0.2,
            'manufacturing_coef' => 1.1,
            'installation_coef' => 0.9,
            'delivery_price' => 8000,
            'discount_amount' => 32400,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }
}
// php artisan db:seed --class=ServiceSeeder