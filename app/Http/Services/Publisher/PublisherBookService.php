<?php

namespace App\Http\Services\Publisher;


use App\Contracts\Interfaces\HasBooksInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Log;


class PublisherBookService
{
    /**
     * Create a new book.
     *
     * @param HasBooksInterface $publisher
     * @param array $data
     * @return Book
     */
    public function createBook(HasBooksInterface $publisher, array $data): Book
    {
        /** @var Book $book */
        $book = $publisher->books()->create($data);

        // Add authors
        $book->authors()->sync($data['author_ids']);

        Log::info('Publisher created a book.', ['book_id' => $book->id]);
        return $book;
    }


    /**
     * Update the book.
     *
     * @param Book $book
     * @param array $data
     * @return Book
     */
    public function updateBook(Book $book, array $data): Book
    {
        Log::info('Publisher updated a book.', ['book_id' => $book->id]);
        $book->update($data);

        // Update authors
        $book->authors()->sync($data['author_ids']);

        return $book->fresh();
    }


    /**
     * Delete the book.
     *
     * @param Book $book
     * @return void
     */
    public function deleteBook(Book $book): void
    {
        Log::info('Publisher deleted a book.', ['book_id' => $book->id]);
        $book->delete();
    }
}
