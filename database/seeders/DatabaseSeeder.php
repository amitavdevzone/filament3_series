<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contact;
use App\Models\Deal;
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
        Contact::factory(25)->create(['user_id' => 2])
            ->each(function (Contact $contact) {
                Deal::factory(10)->create(['contact_id' => $contact->id]);
            });

        Carbon::now()->addDay();
        Contact::factory(10)->create(['user_id' => 1])
            ->each(function (Contact $contact) {
                Deal::factory(10)->create(['contact_id' => $contact->id]);
            });
    }
}
