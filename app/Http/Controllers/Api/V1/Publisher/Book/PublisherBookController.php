<?php

namespace App\Http\Controllers\Api\V1\Publisher\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Publisher\Auth\Book\PublisherBookStoreRequest;
use App\Http\Resources\V1\Publisher\Book\PublisherBookDetailResource;
use App\Http\Resources\V1\Publisher\Book\PublisherBookResource;
use App\Http\Services\Publisher\PublisherBookService;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Publisher
 * @subgroup Books
 */
class PublisherBookController extends Controller
{

    private int $paginate = 10;


    public function __construct(private readonly PublisherBookService $publisherBookService)
    {
    }


    /**
     * Display a listing of the resource.
     * @authenticated
     * @queryParam page int Example: 1
     * @queryParam sort string the field by which you need to sort. Available fields: <b>id, title, description
     * </b> Example: id
     * @queryParam search string the field by which you search. Search by title and description
     * @queryParam n number of records per page. Example: 20
     * @return JsonResponse
     */
    #[QueryParam('n', 'int', false)]
    #[QueryParam('sort', 'string', false)]
    #[QueryParam('search', 'string', false)]
    #[ResponseFromApiResource(PublisherBookResource::class, Book::class, 200, '', true)]
    public function index(): JsonResponse
    {
        $perPage = $this->paginate;

        if (request()->has('n') && is_numeric(request('n'))) {
            $perPage = min((int)request('n'), 200);
        }

        /** @var Publisher $publisher */
        $publisher = auth()->user();

        // Here I use QueryBuilder
        /** @var Collection $books */
        $books = QueryBuilder::for($publisher->books())
            ->defaultSort('-id')
            ->allowedSorts([
                AllowedSort::field('id', 'id'),
                AllowedSort::field('title', 'title'),
                AllowedSort::field('description', 'description'),
            ])
            ->scopes('Search')
            ->paginate($perPage);

        return PublisherBookResource::collection($books)->response();
    }


    /**
     * Store a newly created resource in storage.
     * @authenticated
     * @param PublisherBookStoreRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    #[ResponseFromApiResource(PublisherBookDetailResource::class, Book::class, 200, '', true)]
    public function store(PublisherBookStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Book::class);

        /** @var Publisher $publisher */
        $publisher = auth()->user();

        $book = $this->publisherBookService->createBook($publisher, $request->validated());

        return PublisherBookDetailResource::make($book)->response();
    }


    /**
     * Display the specified resource.
     * @authenticated
     * @param Book $book
     * @return JsonResponse
     * @throws AuthorizationException
     */
    #[ResponseFromApiResource(PublisherBookDetailResource::class, Book::class, 200, '', true)]
    public function show(Book $book): JsonResponse
    {
        $this->authorize('view', $book);

        return PublisherBookDetailResource::make($book)->response();
    }


    /**
     * Update the specified resource in storage.
     * @authenticated
     * @param PublisherBookStoreRequest $request
     * @param Book $book
     * @return JsonResponse
     * @throws AuthorizationException
     */
    #[ResponseFromApiResource(PublisherBookDetailResource::class, Book::class, 200, '', true)]
    public function update(PublisherBookStoreRequest $request, Book $book): JsonResponse
    {
        $this->authorize('update', $book);

        $book = $this->publisherBookService->updateBook($book, $request->validated());

        return PublisherBookDetailResource::make($book)->response();
    }


    /**
     * Remove the specified resource from storage.
     * @authenticated
     * @param Book $book
     * @return JsonResponse
     * @throws AuthorizationException
     */
    #[Response([
        'message' => 'Book deleted successfully.',
        'context' => 'Book deleted'
    ], 200)]
    public function destroy(Book $book): JsonResponse
    {
        $this->authorize('delete', $book);

        $this->publisherBookService->deleteBook($book);

        return response()->json([
            'message' => __("publisher.book.operations.destroy.success.message"),
            'context' => __("publisher.book.operations.destroy.success.context"),
        ]);
    }
}
