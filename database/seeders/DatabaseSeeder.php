<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Categories
        Category::factory(rand(1, 3))->create();

        // Seed Authors
        Author::factory(rand(1, 10))->create();

        // Seed Students
        for($i = 0; $i < 10; $i++){
            Student::factory()->create([
                'email' => 'student' . $i . '@gmail.com',
            ]);
        }

        $categories = Category::all();
        $authors = Author::all();

        // Seed Books
        Book::factory(rand(20, 40))->make()->each(function ($book) use ($categories, $authors) {
            $book->category_id = $categories->random()->id;
            $book->author_id = $authors->random()->id;
            $book->save();
        });
    }
}
