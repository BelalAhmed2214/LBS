<?php
namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class BookService implements IResourceService
{
    public function index()
    {
        return Book::all();
    }

    public function store($data)
    {
        return Book::create($data);
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update($data, Model $book)
    {
        $book->update($data);
        return $book;
    }

    public function delete(Model $book)
    {
        if (!$book->exists) {
            throw new ValidationException("Book Not Found.");
        }
        $book->delete();
        
    }
}
