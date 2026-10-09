<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = User::factory()->count(50)->create();
        $authors = Author::all();

        $subscribers->each(function (User $subscriber) use ($authors) {
            $subscriber->authorsSubscribedOn()->attach($authors->random(rand(0, 3)));
        });
    }
}
