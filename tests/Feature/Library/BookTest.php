<?php

namespace Tests\Feature\Library;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_store(): void
    {
        $author = Author::create([
            'name' => 'Ali Kamal',
            'email' => 'ali.kamal@gmail.com',
        ]);

        $response = $this->postJson('/api/books', [
            'title' => 'War and Peace',
            'isbn' => '978-1400079988',
            'published_date' => '1869-01-01',
            'author_id' => $author->id,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'title', 'isbn', 'published_date', 'author_id', 'created_at', 'updated_at'
                 ]);
    }

    public function test_books_index(): void
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
    }

    public function test_books_show(): void
    {
        $author = Author::create([
            'name' => 'Sara Nabil',
            'email' => 'sara.nabil@gmail.com',
        ]);

        $book = Book::create([
            'title' => 'The Great Gatsby',
            'isbn' => '978-0743273565',
            'published_date' => '1925-04-10',
            'author_id' => $author->id,
        ]);

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id', 'title', 'isbn', 'published_date', 'author_id', 'created_at', 'updated_at'
                 ]);
    }

    public function test_books_update(): void
    {
        $author = Author::create([
            'name' => 'Khaled Youssef',
            'email' => 'khaled.youssef@gmail.com',
        ]);

        $book = Book::create([
            'title' => 'Brave New World',
            'isbn' => '978-0060850524',
            'published_date' => '1932-01-01',
            'author_id' => $author->id,
        ]);

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'The Catcher in the Rye',
            'isbn' => '978-0316769488',
            'published_date' => '1951-07-16',
            'author_id' => $author->id,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $book->id,
                     'title' => 'The Catcher in the Rye',
                     'isbn' => '978-0316769488',
                     'published_date' => '1951-07-16',
                     'author_id' => $author->id,
                 ]);
    }

    public function test_books_delete(): void
    {
        $author = Author::create([
            'name' => 'Nour El-Din',
            'email' => 'nour.eldin@gmail.com',
        ]);

        $book = Book::create([
            'title' => 'Anna Karenina',
            'isbn' => '978-0143035008',
            'published_date' => '1877-01-01',
            'author_id' => $author->id,
        ]);

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Book deleted successfully',
                 ]);
    }
}
