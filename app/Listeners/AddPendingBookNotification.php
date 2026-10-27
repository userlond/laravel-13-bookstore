<?php

namespace App\Listeners;

use App\Events\BookPublished;
use App\Models\Subscription;
use DB;
use Illuminate\Support\Collection;

class AddPendingBookNotification
{
    /**
     * Handle the event.
     */
    public function handle(BookPublished $event): void
    {
        $book = $event->book;

        DB::table('subscriptions')
            ->whereIn('author_id', $book->authors->pluck('id'))
            ->select(['id', 'user_id'])
            ->chunkById(500, function (Collection $subscriptions) use ($book) {
                /** @var Subscription $subscription */
                $insertData = $subscriptions->map(fn ($subscription) => [
                    'user_id' => $subscription->user_id,
                    'book_id' => $book->id,
                ])->toArray();

                DB::table('book_pending_notifications')->insertOrIgnore($insertData);
            });
    }
}
