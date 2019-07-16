<?php

use Illuminate\Database\Seeder;
use \Faker\Factory;
use App\Models\Enemy;

class EnemySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Enemy::truncate();
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            Enemy::create([
                'name' => $faker->name,
                'type' => $faker->randomElement(Enemy::ENEMY_TYPES),
                'lvl' => $i,
                'attack' => $i * 20,
                'heatpoint' => $i * 20,
            ]);
        }
    }
}
