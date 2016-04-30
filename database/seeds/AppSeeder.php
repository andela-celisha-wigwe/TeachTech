<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number = rand(100, 1000);
        factory(TeachTech\User::class)->create([
            'role' => 'diner',
            'email' => 'diner@localhost.com',
            'password' => bcrypt('password'),
        ]);
    }
}

$factory->define(TeachTech\User::class, function (Faker\Generator $faker) {
    // prevent uniquness violations
    $number = rand(100, 1000);

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'avatar' => $faker->url,
        'password' => bcrypt('teachtech'),
        'social_id' => "{$faker->word}_$number",
        'social_link' => 'facebook',
    ];
});

$factory->define(TeachTech\Video::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->sentence(rand(6, 10), true),
        'description'   => $faker->text(200),
        'category_id'   => rand(1, 5),
        'user_id'       => rand(1, 5),
    ];
});

$factory->define(TeachTech\Category::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->sentence(rand(6, 10), true),
    ];
});
