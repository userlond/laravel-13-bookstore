<?php

namespace App\Observers;

use App\Events\BookPublished;
use App\Models\Book;

class BookObserver
{
    public function updated(Book $book): void
    {
        if ($book->wasChanged('is_published') && $book->is_published) {
            BookPublished::dispatch($book);
        }
    }
}
