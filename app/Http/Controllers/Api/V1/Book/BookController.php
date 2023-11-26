<?php

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Book\StudentBookDetailResource;
use App\Http\Resources\V1\Book\StudentBookResource;
use App\Models\Book;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

/**
 * @group Library
 * @subgroup Books
 */
class BookController extends Controller
{
    private int $page = 1;

    private int $paginate = 15;


    /**
     * Display a listing of the resource.
     * @authenticated
     * @queryParam page int The page number for pagination. Example: 1
     * @queryParam n int The number of records per page. Example: 20
     * @param Request $request
     * @return JsonResponse
     */
    #[QueryParam('page', 'int', false)]
    #[QueryParam('n', 'int', false)]
    #[ResponseFromApiResource(StudentBookResource::class, Book::class, 200, '', true)]
    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', $this->page);
        $perPage = $request->input('n', $this->paginate);
        $perPage = min($perPage, 20);

        $offset = ($page - 1) * $perPage;

        $books = DB::select("SELECT * FROM books LIMIT :limit OFFSET :offset", [
            'limit' => $perPage,
            'offset' => $offset
        ]);

        $booksCollection = collect($books)->map(function ($item) {
            $book = new Book([
                'title' => $item->title,
                'description' => $item->description,
            ]);

            $book->id = $item->id;

            return $book;
        });

        $total = DB::table('books')->count();
        $totalPages = ceil($total / $perPage);

        $response = [
            'books' => StudentBookResource::collection($booksCollection),
            'total' => $total,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];

        return response()->json(['data' => $response]);
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
     * @throws AuthorizationException
     */
    #[ResponseFromApiResource(StudentBookDetailResource::class, Book::class, 200, '', true)]
    public function show(Book $book): JsonResponse
    {
        $this->authorize('view', $book);

        return StudentBookDetailResource::make($book)->response();
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
