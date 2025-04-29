<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('reviews')->insert([
            [
                'name' => 'Александр Петров',
                'content' => 'Огромное спасибо команде SuperCanopy! Заказал навес — приехали, замерили, через пару дней уже установили. Все очень аккуратно и профессионально.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Мария Иванова',
                'content' => 'Устанавливали козырек над крыльцом. Все понравилось — быстро, красиво и недорого. Рекомендую!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Айдос Ермеков',
                'content' => 'Сделали отличный навес для машины. Работают слаженно, без задержек. Материалы качественные. 5 из 5!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Светлана Нурсеитова',
                'content' => 'Заказали навес с хозблоком на дачу. Все на высшем уровне — от консультации до установки. Спасибо!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Владимир С.',
                'content' => 'Давно искал надежную компанию для установки навеса — и не пожалел. Отличный сервис, адекватные цены.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}