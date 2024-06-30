<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Services\IResourceService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthorService implements IResourceService
{
    public function index(): Collection
    {
        return Author::all();
    }

    public function show(Author $author): ?Author
    {
        return $author;
    }
    
    public function store($data)
    {
        if (empty($data['name']) || empty($data['email'])) {
            throw new ValidationException("Name and email are required.");
        }

        return Author::create($data);
    }

    public function update($data, Model $author)
    {
        if (empty($data)) {
            throw new ValidationException("No data provided for update.");
        }

        $author->update($data);

        // Simulate email notification
        // if (isset($data['email'])) {
        //     Log::info("Email changed to: " . $data['email']);
        // }

        return $author;
    }

    public function delete(Model $author)
    {
        if (!$author->exists) {
            throw new ValidationException("Author not found.");
        }
        
        $author->delete();        
    }
}
