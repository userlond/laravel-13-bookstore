<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::factory()->count(10)->create();

        Book::factory()->count(500)->create()->each(function (Book $book) use ($authors) {
            $bookAuthors = $authors->random(rand(1, 5));

            $book->authors()->attach($bookAuthors);
        });
    }
}
