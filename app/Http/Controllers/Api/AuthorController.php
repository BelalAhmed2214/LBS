<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Illuminate\Http\JsonResponse;
use App\Services\AuthorService;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $authors = $this->authorService->index();
            return response()->json($authors, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch authors', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        try {
            $author = $this->authorService->store($request->validated());
            return response()->json($author, 201);
        } catch (\Exception $e) {
            $status = $e->getCode() === 400 ? 400 : 500;
            return response()->json(['error' => 'Failed to store author', 'message' => $e->getMessage()], $status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author): JsonResponse
    {
        try {
            $specificAuthor = $this->authorService->show($author);
            return response()->json($specificAuthor, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch author', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author): JsonResponse
    {
        try {
            $updatedAuthor = $this->authorService->update($request->validated(), $author);
            
            return response()->json($updatedAuthor, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update author', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): JsonResponse
    {
        try {
            $this->authorService->delete($author);
            return response()->json(['message' => 'Author deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete author', 'message' => $e->getMessage()], 500);
        }
    }
}
