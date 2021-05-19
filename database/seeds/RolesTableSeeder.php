<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'System Administrator', 'allowed_route' => 'admin']);
        $editorRole = Role::create(['name' => 'editor', 'display_name' => 'Supervisor', 'description' => 'System Supervisor', 'allowed_route' => 'admin']);
        $userRole = Role::create(['name' => 'user', 'display_name' => 'User', 'description' => 'Normal User', 'allowed_route' => null]);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@my-blog.com',
            'mobile' => '963900000001',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('11111111'),
            'status' => 1
        ]);

        /* $user->roles()->attach($roleId);
           Alias to eloquent many-to-many relation's attach() method.
        */
        $admin->attachRole($adminRole);

        $editor = User::create([
            'name' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@my-blog.com',
            'mobile' => '963900000002',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('11111111'),
            'status' => 1
        ]);
        $editor->attachRole($editorRole);

        $user1 = User::create(['name' => 'Muhammad Noor', 'username' => 'Muhammad', 'email' => 'Muhammad@my-blog.com', 'mobile' => '963900000003', 'email_verified_at' => Carbon::now(), 'password' => bcrypt('11111111'), 'status' => 1]);
        $user1->attachRole($userRole);

        $user2 = User::create(['name' => 'Ali Jamal', 'username' => 'Ali', 'email' => 'ali@my-blog.com', 'mobile' => '963900000004', 'email_verified_at' => Carbon::now(), 'password' => bcrypt('11111111'), 'status' => 1]);
        $user2->attachRole($userRole);

        $user3 = User::create(['name' => 'Siraj jar', 'username' => 'Siraj', 'email' => 'siraj@my-blog.com', 'mobile' => '963900000005', 'email_verified_at' => Carbon::now(), 'password' => bcrypt('11111111'), 'status' => 1]);
        $user3->attachRole($userRole);

        /* function random_int ($min, $max) {}
         * Generates cryptographically secure pseudo-random integers
         * @link https://php.net/manual/en/function.random-int.php
         * @param int $min The lowest value to be returned, which must be PHP_INT_MIN or higher.
         * @param int $max The highest value to be returned, which must be less than or equal to PHP_INT_MAX.
         * @return int Returns a cryptographically secure random integer in the range min to max, inclusive.
         * @since 7.0
         * @throws Exception if it was not possible to gather sufficient entropy.
         */
        for ($i = 0; $i < 10; $i++){
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->email,
                'mobile' => '9639' . random_int(10000000, 99999999),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('11111111'),
                'status' => 1
            ]);
            $user->attachRole($userRole);
        }
    }
}
