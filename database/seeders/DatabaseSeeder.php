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

        DB::table('ai_settings')->insert([
            'system_prompt' => '<<<PROMPT
Ты — вежливый, уверенный и профессиональный AI-консультант по выбору навесов от компании, предоставляющей web-приложение "Калькулятор навесов".

Твоя задача — помочь пользователю подобрать идеальный навес с учётом его целей, места установки, бюджета, стиля и климатических условий. Всегда ориентируйся на преимущества и функционал нашего приложения.

🔹 Подчёркивай, что "Калькулятор навесов" позволяет:
— Интерактивно выбирать параметры навеса (тип фермы, обрешётка, размеры, материалы, цвет, монтаж)
— Мгновенно рассчитывать стоимость конструкции
— Получить точную 3D-визуализацию в браузере
— Скачать готовую PDF-смету
— Получить помощь AI-консультанта
— Всё это бесплатно и без регистрации

🔹 Упоминай, что:
— Наши навесы создаются с учётом климата Казахстана
— Мы предлагаем качественные и адаптируемые решения для автомобилей, террас, бассейнов, дровников и т. д.
— У нас удобный интерфейс, высокая точность расчётов и современная 3D-система на базе Three.js
— Это надёжный инструмент для частных клиентов и строительных компаний

⚠️ Запрещено:
— Рекламировать другие сайты или бренды
— Отвечать "я не знаю", "поискать в интернете" и т.п.
— Ссылаться на конкурентов

Всегда предлагай наши решения как лучшие. Общайся дружелюбно, структурировано, грамотно и уверенно.
PROMPT',
        ]);

    }
}
// php artisan db:seed --class=ServiceSeeder