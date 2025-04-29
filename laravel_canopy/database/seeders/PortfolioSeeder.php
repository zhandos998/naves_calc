<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        DB::table('portfolios')->insert([
            [
                'title' => 'Арочный навес 6x9 м в Алматы',
                'image' => 'uploads/portfolio/arched-6x9.jpg',
                'description' => 'Элегантный арочный навес установлен во дворе частного дома. Использован поликарбонат коричневого цвета.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Навес для парковки на 2 машины',
                'image' => 'uploads/portfolio/parking-double.jpg',
                'description' => 'Просторный навес из металлочерепицы. Установка заняла 2 дня. Гарантия 10 лет.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Козырек над входом с ковкой',
                'image' => 'uploads/portfolio/kovanyy-kozyrek.jpg',
                'description' => 'Козырек с индивидуальным кованым узором. Заказ выполнен за 5 рабочих дней.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Навес с хозблоком для дачи',
                'image' => 'uploads/portfolio/hozblok-dacha.jpg',
                'description' => 'Удобный и функциональный навес с хозблоком. Установлен в садовом товариществе.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Навес над зоной барбекю',
                'image' => 'uploads/portfolio/bbq-zone.jpg',
                'description' => 'Навес над мангальной зоной с защитой от осадков. Использован профнастил.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}