<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\NewBooksNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

#[Tries(3)]
class SendNewBooksNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $user = User::where('id', $this->user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $now = now();
            $yesterday = $now->copy()->subDay();
            if ($user->book_last_notified_at && $user->book_last_notified_at->gt($yesterday)) {
                return;
            }

            $pendingNotifications = $user->bookPendingNotifications
                ->whereNull('notified_at')
                ->load('book.authors');

            if ($pendingNotifications->isEmpty()) {
                return;
            }

            $books = $pendingNotifications->pluck('book');

            $user->notify(new NewBooksNotification($books));

            $user
                ->bookPendingNotifications()
                ->whereIn('id', $pendingNotifications->pluck('id'))
                ->update(['notified_at' => $now]);

            $user->update(['book_last_notified_at' => $now]);
        });
    }
}
