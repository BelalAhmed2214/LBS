<?php

namespace Tests\Feature\Library;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_authors_store(): void
    {
        $response = $this->postJson('/api/authors',[
            'name'=>'mhmdelsayed',
            'email'=>'mhmd@gmail.com'
        ]);

        $response->assertStatus(201);
    }
     public function test_authors_index(): void
    {
        $response = $this->getJson('/api/authors');

        $response->assertStatus(200);
    }
    public function test_authors_show(): void
    {

        $author = new Author();
        $author->name = 'OmarShaaban';
        $author->email = 'omar@gmail.com';
        $author->save();
        $response = $this->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name', 'email', 'created_at', 'updated_at'
        ]);
    }

    public function test_authors_update(): void
    {
        $author = new Author();
        $author->name = 'Alaa Hassan';
        $author->email = 'AlaaHassan@gmail.com';
        $author->save();

        $response = $this->putJson("/api/authors/{$author->id}", [
            'name' => 'Youssef Hassan',
            'email' => 'YoussefHassan@gmail.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                    'id' => $author->id,
                    'name' => 'Youssef Hassan',
                    'email' => 'YoussefHassan@gmail.com',
                 ]);
    }
   
    public function test_authors_delete(): void
    {
        $author = new Author();
        $author->name = 'Bahaa Sultan';
        $author->email = 'BahaaSultan@gmail.com';
        $author->save();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Author deleted successfully',
                 ]);
    }
}
