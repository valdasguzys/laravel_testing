<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller 
{
    public function store()
    {
        $book = Book::create($this->validateRequest());
        return redirect('/books/' . $book->isbn);
    }

    public function update(Book $book)
    {
        $book->update($this->validateRequest());
        return redirect('/books/' . $book->isbn);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }

    private function validateRequest(){
        return request()->validate([ 'isbn' => 'required', 'title' => 'required' ]);
    }
}
