<?php

namespace App\Http\Controllers\Api\V1\Client\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\QueryParam;

/**
 * @group Client
 * @subgroup Books
 */
class ClientBookController extends Controller
{

    private int $paginate = 10;

    /**
     * Display a listing of the resource.
     * @queryParam page int The page number for pagination. Example: 1
     * @queryParam n int The number of records per page. Example: 20
     * @return JsonResponse
     */
    #[QueryParam('page', 'int', false)]
    #[QueryParam('n', 'int', false)]
    public function index(): JsonResponse
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

        return response()->json([
            'books' => $books,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * @authenticated
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->errorResponse('Not Found.', 'Not Found', 404);
    }


    /**
     * Display the specified resource.
     * @authenticated
     * @param Book $book
     * @return JsonResponse
     */
    public function show(Book $book): JsonResponse
    {
        return $this->errorResponse('Not Found.', 'Not Found', 404);
    }


    /**
     * Update the specified resource in storage.
     * @authenticated
     * @param Request $request
     * @param Book $book
     * @return JsonResponse
     */
    public function update(Request $request, Book $book): JsonResponse
    {
        return $this->errorResponse('Not Found.', 'Not Found', 404);
    }


    /**
     * Remove the specified resource from storage.
     * @authenticated
     * @param Book $book
     * @return JsonResponse
     */
    public function destroy(Book $book): JsonResponse
    {
        return $this->errorResponse('Not Found.', 'Not Found', 404);
    }
}
