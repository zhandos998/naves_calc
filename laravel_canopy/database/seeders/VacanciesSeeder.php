<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacanciesSeeder extends Seeder
{
    public function run()
    {
        DB::table('vacancies')->insert([
            [
                'title' => 'Менеджер по продажам',
                'description' => 'Ищем активного и целеустремленного менеджера по продажам навесов и конструкций. Опыт в продажах приветствуется. Обучение за счет компании.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Монтажник металлоконструкций',
                'description' => 'Требуются монтажники навесов и козырьков. Опыт работы с металлоконструкциями желателен. Работа на выезде, своевременная оплата.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Дизайнер-проектировщик',
                'description' => 'Вакансия для проектировщика навесов и козырьков. Навыки работы в AutoCAD или SketchUp обязательны. Возможность удалённой работы.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Маркетолог',
                'description' => 'Ищем специалиста по маркетингу для продвижения сайта и услуг компании. Продвижение в соцсетях, контекстная реклама, разработка акций.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Логист',
                'description' => 'Требуется логист для координации доставки материалов и оборудования на объекты клиентов. Опыт работы приветствуется.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
