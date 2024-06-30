<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use App\Services\IResourceService;

class BookService implements IResourceService
{
    public function index(): Collection
    {
        $books = Book::all();
        return $books;
    }

    public function show(Book $book): ?Book
    {
        return $book;
    }
    
    public function store($data)
    {
        
        $book = Book::where('isbn',$data['isbn'])->first();
        if ($book){
            throw new \Exception("This book is already exists, Enter another isbn", 400);
        }
    
            $book = new Book();
            $book->title = $data['title'];
            $book->isbn = $data['isbn'];
            $book->published_date = $data['published_date'];
            $book->author_id = $data['author_id'];
            $book->save();
            return $book;
        
    }

    public function update($data, Model $resource)
    {
    
        // $book = Book::find($resource->id); // Try to find the book by ID
        $existingbook = Book::where('isbn', $data['isbn'])->where('id', '==', $resource->id)->first();
        if($existingbook){
            throw new \Exception("This book is already exists", 400);

        }
        $book = Book::find($resource->id);
        if (!$book) {
            throw new \Exception('Book not found'); // Throw an exception if not found
        }

        $resource->title = $data['title'];
        $resource->isbn = $data['isbn'];
        $resource->published_date = $data['published_date'];
        $resource->author_id = $data['author_id'];
        $resource->save();
        return $resource;
        
    }

    public function delete(Model $resource)
    {
        $existingbook = Book::find($resource->id);
        if(!$existingbook){
            throw new \Exception('Book not found'); // Throw an exception if not found

        }
        $resource->delete();
    }
}
