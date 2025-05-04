<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\About;
use App\Models\Contact;
use App\Models\Vacancy;
use App\Models\Review;
use App\Models\Portfolio;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            ['name' => 'Администратор', 'slug' => 'admin'],
            ['name' => 'User', 'slug' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $admin = Role::where('slug','admin')->first();
        $user = Role::where('slug', 'user')->first();

        // $user1 = new User();
        // $user1->name = 'Admin';
        // $user1->email = 'admin@admin.com';
        // $user1->password = bcrypt('123456');
        // $user1->save();
        // $user1->roles()->attach($admin);

        // $user2 = new User();
        // $user2->name = 'User';
        // $user2->email = 'user@admin.com';
        // $user2->password = bcrypt('123456');
        // $user2->save();
        // $user2->roles()->attach($user);

        $user2 = new User();
        $user2->name = 'Zhandos';
        $user2->email = 'zhandos998@gmail.com';
        $user2->phone = '77473186847';
        $user2->password = bcrypt('123456789');
        $user2->email_verified_at = "2025-04-26 21:10:43";
        $user2->save();
        $user2->roles()->attach($admin);

        About::create([
            'content' => 'Мы создаем качественные навесы для вашего дома и бизнеса. Наш опыт — гарантия надежности!',
        ]);
        Contact::create([
            'phone' => '+7 (777) 123-45-67',
            'email' => 'info@supercanopy.kz',
            'address' => 'г. Алматы, ул. Абая 123',
        ]);
        // Vacancy::create([
        //     'title' => 'Менеджер по продажам',
        //     'description' => 'Ищем активного менеджера для работы с клиентами. Опыт приветствуется.',
        // ]);
        // Review::create([
        //     'name' => 'Иван Иванов',
        //     'content' => 'Очень доволен качеством навеса! Все сделали в срок, рекомендую!',
        // ]);
        // Portfolio::create([
        //     'title' => 'Навес для частного дома',
        //     'image' => 'uploads/portfolio/house-canopy.jpg', // Пока просто строка
        //     'description' => 'Элегантный навес для автомобиля, выполненный из металлоконструкций.',
        // ]);




    }
}
