<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            ['name' => 'Администратор', 'slug' => 'admin'],
            ['name' => 'Мастер', 'slug' => 'master'],
            ['name' => 'User', 'slug' => 'user'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $admin = Role::where('slug','admin')->first();
        $user = Role::where('slug', 'user')->first();

        $user1 = new User();
        $user1->name = 'Admin';
        $user1->email = 'admin@admin.com';
        $user1->password = bcrypt('123456');
        $user1->save();
        $user1->roles()->attach($admin);

        $user2 = new User();
        $user2->name = 'User';
        $user2->email = 'user@admin.com';
        $user2->password = bcrypt('123456');
        $user2->save();
        $user2->roles()->attach($user);
    }
}
