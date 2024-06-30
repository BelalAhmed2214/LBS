<?php
namespace App\Http\Controllers\Api;

use App\Models\Author;
use App\Services\AuthorService;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(): JsonResponse
    {
        try {
            $authors = $this->authorService->index();
            return response()->json($authors, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch authors'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreAuthorRequest $request): JsonResponse
    {
        try {
            $author = $this->authorService->store($request->validated());
            return response()->json($author, Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create author'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Author $author): JsonResponse
    {
        try {
            $author = $this->authorService->show($author);
            return response()->json($author, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch author'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateAuthorRequest $request, Author $author): JsonResponse
    {
        try {
            $author = $this->authorService->update($request->validated(), $author);
            return response()->json($author, Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update author'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Author $author): JsonResponse
    {
        try {
            $this->authorService->delete($author);
            return response()->json(['message' => 'Author deleted successfully'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete author'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
