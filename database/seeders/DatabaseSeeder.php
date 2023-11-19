<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
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
        // Create 25 contacts with an owner_id of 2.
        $contacts = Contact::factory(25)->create(['owner_id' => 2]);

        $companies = Company::factory(25)->create(['owner_id' => 2]);

        // Associate companies with contacts in a many-to-many relationship.
        $contacts->each(function (Contact $contact) use ($companies) {
            $contact->companies()->attach($companies->random(rand(5, 25)));
        });

        // Create 10 deals for each contact.
        $contacts->each(function (Contact $contact) {
            Deal::factory(10)->create([
                'contact_id' => $contact->id,
            ]);
        });

        Carbon::now()->addDay();
        // Create 25 contacts with an owner_id of 2.
        $contacts = Contact::factory(25)->create(['owner_id' => 1]);

        $companies = Company::factory(25)->create(['owner_id' => 1]);

        // Associate companies with contacts in a many-to-many relationship.
        $contacts->each(function (Contact $contact) use ($companies) {
            $contact->companies()->attach($companies->random(rand(5, 25)));
        });

        // Create 10 deals for each contact.
        $contacts->each(function (Contact $contact) {
            Deal::factory(10)->create(['contact_id' => $contact->id]);
        });
    }
}
