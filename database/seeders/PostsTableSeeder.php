<?php

namespace Database\seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
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

        /* public static function random($array, $number = null)
         * Get one or a specified number of random values from an array.
         */
        $posts = [];
        $days = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28'];
        $months  = ['01', '02', '03', '04', '05', '06'];

        for($i = 0; $i < 1000; $i++) {
            $post_date = "2021-" . Arr::random($months) . "-" . Arr::random($days) . " 01:01:01"; // "2021-05-10 01:01:01"
            $post_title = $faker->sentence(mt_rand(3, 6), true);
            $posts[] = [
                'title' => $post_title,
                'slug' => Str::slug($post_title),
                'description' => $faker->paragraph,
                'status' => rand(0, 1),
                'comment_able' => rand(0, 1),
                'user_id' => $users->random(),
                'category_id' => $categories->random(),
                'created_at' => $post_date,
                'updated_at' => $post_date,
            ];
        }

        /* function array_chunk(array $input, $size, $preserve_keys = null) { }
         * Split an array into chunks
         * @link https://php.net/manual/en/function.array-chunk.php
         * @param array $input
         * The array to work on
         * @param int $size
         * The size of each chunk
         * @param bool $preserve_keys [optional]
         * When set to true keys will be preserved. Default is false which will reindex the chunk numerically
         * @return array a multidimensional numerically indexed array, starting with zero,
         * with each dimension containing size elements.
         */
        $chunks = array_chunk($posts, 100);
        foreach ($chunks as $chunk) {
            Post::insert($chunk);
        }
    }
}
