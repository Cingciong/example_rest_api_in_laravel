<?php

namespace Database\Seeders;

use App\Models\ApiResponse;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Pet;
use App\Models\Order;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder

{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('migrate:fresh');
        User::create([
            'id' => 1,
            'firstName' => 'test',
            'lastName' => 'test',
            'phone' => '123456789',
            'email' => 'test@test.pl',
            'password' => bcrypt('test'),
            'username' => 'test',
        ]);
        User::factory(200)->create();
        Tag::factory(50)->create();
        Category::factory(50)->create();
        Pet::factory(500)->create();
        Order::factory(300)->create();
        Pet::all()->each(function (Pet $pet) {
            $tagIds = Tag::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $pet->tags()->attach($tagIds);
        });
        DB::table('api_key')->insert([
            'id' => 1,
            'key' => 'test',
        ]);

        ApiResponse::create([
            'code' => 200,
            'type' => 'success',
            'message' => 'Successful operation',
        ]);
        ApiResponse::create([
            'code' => 400,
            'type' => 'error',
            'message' => 'Error ID supplied',
        ]);

        ApiResponse::create([
            'code' => 404,
            'type' => 'error',
            'message' => 'Object not found',
        ]);

        ApiResponse::create([
            'code' => 405,
            'type' => 'error',
            'message' => 'Invalid input',
        ]);
    }
}
