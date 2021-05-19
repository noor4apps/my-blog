<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        /* collect() - helpers.php
         * Create a collection from the given value.
         * @param  mixed  $value
         * @return \Illuminate\Support\Collection
         *  [3, 4, 5]
         *  {all:[3, 4, 5]}
         */

        /* modelKeys() - Eloquent\Collection method returns the primary keys for all models in the collection:
         * Get the array of primary keys.
         * @return array
         */

        $categories = collect(Category::all()->modelKeys());
        $users = collect(User::where('id', '>', 2)->get()->modelKeys());

        /*
         * string sentence($nbWords = 6, $variableNbWords = true) - Faker
         * array|string sentences($nb = 3, $asText = false) - Faker
         */

        /* function mt_rand ($min = 0, $max = null) {}
         * Generate a random value via the Mersenne Twister Random Number Generator
         * @link https://php.net/manual/en/function.mt-rand.php
         * @param int $min [optional]
         * Optional lowest value to be returned (default: 0)
         * @param int $max [optional]
         * Optional highest value to be returned (default: mt_getrandmax())
         * @return int A random integer value between min (or 0) and max (or mt_getrandmax, inclusive)

         * function rand ($min = 0, $max = null) {}
         * Generate a random integer
         * @link https://php.net/manual/en/function.rand.php
         * @param int $min [optional]
         * @param int $max [optional]
         * @return int A pseudo random value between min (or 0) and max (or getrandmax, inclusive).
         *
         * Both functions do the same thing, and both take the same parameters, so what is the difference between the two? Well, rand() is a basic randomisation function that is very quick but not very "random" - the numbers it generates are slightly more predictable. Mt_rand() on the other hand, is more complicated - the "mt" parts means Mersenne Twister, as that is the name of the randomisation algorithm it uses. Mt_rand() returns much more "random" numbers, but does so at the expense of some speed.
         */

        /* public function random($number = null) - Support/Collection
         * Get one or a specified number of items randomly from the collection.
         *
         * @param  int|null  $number
         * @return static|mixed
         *
         * @throws \InvalidArgumentException
         */

        for($i = 0; $i < 10; $i++) {
            Post::create([
                'title' => $faker->sentence(mt_rand(3, 6), true),
                'description' => $faker->paragraph,
                'status' => rand(0, 1),
                'comment_able' => rand(0, 1),
                'user_id' => $users->random(),
                'category_id' => $categories->random()
            ]);
        }
    }
}
