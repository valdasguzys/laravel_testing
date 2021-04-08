<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function book_can_be_added() 
    {
        // given
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 9780840700551, 'title' => 'Holy Bible' ];
        // when
        $response = $this->post('/books', $bookData);
        // then
        // $response->assertStatus(200);
        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/' . $bookData['isbn']);
    }

    /**
     * @test
     * @return void
     */
    public function title_is_required_to_create_a_book()
    {
        //given 
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 1234567891234, 'title' => ''];
        // when / then
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectExceptionMessage('The given data was invalid.');
        $response = $this->post('/books', $bookData);

        //then
        // $responce->assertStatus(200);
        // $books = Book::all();
        // $this->assertEquals(1, $books->count());
    }

    /** @test */
    public function title_is_required_to_create_book() 
    {
        // given
        $bookData = ['isbn' => 9780840700551, 'title' => '' ];
        // when
        $response = $this->post('/books', $bookData);
        // then
        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');
        $this->assertCount(0, Book::all());
    }

    /** @test */
    public function book_can_be_updated() 
    {
        // given
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 1234567891234, 'title' => 'Holy Bible'];
        $this->post('/books', $bookData);

        // when
        $updatedBookData = ['isbn' => 1234567891234, 'title' => 'Anything' ];
        $response = $this->put('/books/' . $bookData['isbn'], $updatedBookData);
     
        // then 
        // $response->assertStatus(200);
        $this->assertCount(1, Book::all());
        $this->assertEquals($updatedBookData['isbn'], Book::first()->isbn);
        $this->assertEquals($updatedBookData['title'], Book::first()->title);
        $response->assertRedirect('/books/' . $bookData['isbn']);
    }

    /** @test */
    public function book_can_be_deleted() {
        // given
        $this->withoutExceptionHandling();
        $bookData = ['isbn' => 1234567891234, 'title' => 'Holy Bible'];
        $this->post('/books', $bookData);

        // when
        $response = $this->delete('/books/' . $bookData['isbn']);
     
        // then 
        $response->assertStatus(302);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books/');

    }

}
