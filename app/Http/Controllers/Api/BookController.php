<?php
namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        try {
            $books = $this->bookService->index();
            return response()->json($books, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch books'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $book = $this->bookService->store($request->validated());
            return response()->json($book, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Book $book)
    {
        try {
            $book = $this->bookService->show($book);
            return response()->json($book, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $book = $this->bookService->update($request->validated(), $book);
            return response()->json($book, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Book $book)
    {
        try {
            $this->bookService->delete($book);
            return response()->json(['message' => 'Book deleted successfully'], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete book'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
