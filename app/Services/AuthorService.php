<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use App\Services\IResourceService;

class AuthorService implements IResourceService
{
    public function index(): Collection
    {
        $authors = Author::all();
        return $authors;
    }

    public function show(Author $author): ?Author
    {
        $existingAuthor = Author::find($author);
        if(!$existingAuthor){
            throw new \Exception("Failed to store author: Email address already exists", 400);
        }
        return $author;
    }
    
    public function store($data)
    {
        // Check if an author with the provided email already exists
        $existingAuthor = Author::where('email', $data['email'])->first();
        if ($existingAuthor){
            throw new \Exception("Failed to store author: Email address already exists", 400);
            
        }

        // If email does not exist, create a new author
        $author = new Author();
        $author->name = $data['name'];
        $author->email = $data['email'];
        $author->save();
        return $author;
        
    }

    public function update($data, Model $resource)
    {
         // Check if an author with the provided email already exists
         $existingAuthor = Author::where('email', $data['email'])->first();
         if ($existingAuthor){
             throw new \Exception("Failed to store author: Email address already exists", 400);
             
         }
            $resource->name = $data['name'];
            $resource->email = $data['email'];
            $resource->save();
            return $resource;
    }

    public function delete(Model $resource)
    {
        $existingAuthor = Author::find($resource);
        if(!$existingAuthor){
            throw new \Exception("Failed to store author: Email address already exists", 400);
        }
        $resource->delete();  
    }
}
