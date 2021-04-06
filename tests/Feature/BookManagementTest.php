<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @return void
     */
    public function book_can_be_added()
    {
        //given 
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 1234567891234, 'title' => 'Holy Bible'];
        // when
        $responce = $this->post('/books', $bookData);
        //then
        $responce->assertStatus(200);
        $books = Book::all();
        $this->assertEquals(1, $books->count());

    }
}
