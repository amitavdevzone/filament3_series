<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Amitav Roy',
            'email' => 'reachme@amitavroy.com',
            'password' => bcrypt('Password@123'),
        ]);

        User::factory()->create([
            'name' => 'Jhon Doe',
            'email' => 'jho.doe@gmail.com',
            'password' => bcrypt('Password@123'),
        ]);

        Carbon::now()->subDay();
        Customer::factory(25)->create(['user_id' => 2]);

        Carbon::now()->addDay();
        Customer::factory(10)->create(['user_id' => 1]);
    }
}
