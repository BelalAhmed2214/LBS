<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\BookService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try{
            $books = $this->bookService->index();
            return response()->json($books, 200);

        } catch(\Exception $e){
            return response()->json(['error' => 'Failed to fetch books', 'message' => $e->getMessage()], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        try {
            $book = $this->bookService->store($request->validated());
            return response()->json($book, 201);
        } catch (\Exception $e) {
            $status = $e->getCode() === 400 ? 400 : 500;
            return response()->json(['error' => 'Failed to store Book', 'message' => $e->getMessage()], $status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            return response()->json($book, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch book', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            $updatedBook = $this->bookService->update($request->validated(), $book);
            return response()->json($updatedBook, 200);
        } catch (\Exception $e) {
            $status = $e->getCode() === 400 ? 400 : 500;
            return response()->json(['error' => 'Failed to update book', 'message' => $e->getMessage()], $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $this->bookService->delete($book);
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete book', 'message' => $e->getMessage()], 500);
        }
    }
}
