<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Authors
        Author::factory(rand(5, 20))->create();

        //Seed Publishers
        for ($i = 0; $i < 10; $i++) {
            Publisher::factory()->create([
                'email' => 'publisher' . $i . '@gmail.com',
            ]);
        }

        // Seed Books with Authors and Publisher
        Book::factory(rand(30, 60))->create()->each(function ($book) {
            /** @var Collection $authors */
            $authors = Author::query()->inRandomOrder()->take(rand(1, 3))->pluck('id');
            $book->authors()->attach($authors);

            /** @var Publisher $publisher */
            $publisher = Publisher::query()->inRandomOrder()->first();
            $book->publisher()->associate($publisher)->save();
        });
    }
}
