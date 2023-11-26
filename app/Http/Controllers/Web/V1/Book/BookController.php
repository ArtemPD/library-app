<?php

namespace App\Http\Controllers\Web\V1\Book;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Knuckles\Scribe\Attributes\QueryParam;

/**
 * @group Library
 * @subgroup Books
 */
class BookController extends Controller
{
    private int $paginate = 10;


    /**
     * Display a listing of the resource.
     * @queryParam page int The page number for pagination. Example: 1
     * @queryParam n int The number of records per page. Example: 20
     * @return View
     */
    #[QueryParam('page', 'int', false)]
    #[QueryParam('n', 'int', false)]
    public function index(): View
    {
        $page = request()->input('page', 1);
        $perPage = request()->input('n', $this->paginate);
        $perPage = min($perPage, 20);

        $offset = ($page - 1) * $perPage;

        $books = DB::table('books')
            ->leftJoin('author_book', 'books.id', '=', 'author_book.book_id')
            ->leftJoin('authors', 'author_book.author_id', '=', 'authors.id')
            ->leftJoin('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->select(
                'books.id',
                'books.title',
                'books.description',
                'books.created_at',
                'books.updated_at',
                DB::raw('string_agg(distinct authors.first_name, \', \') as authors'),
                'publishers.title as publisher'
            )
            ->groupBy(
                'books.id',
                'books.title',
                'books.description',
                'books.created_at',
                'books.updated_at',
                'publishers.title'
            )
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $total = DB::table('books')->count();
        $totalPages = ceil($total / $perPage);

        return view('books.index', compact('books', 'totalPages', 'page'));
    }
}
