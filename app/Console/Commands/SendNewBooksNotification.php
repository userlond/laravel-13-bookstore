<?php

namespace App\Console\Commands;

use App\Jobs\SendNewBooksNotificationJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-new-books-notification')]
#[Description('Send daily digest about new books')]
class SendNewBooksNotification extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::now()->subDay();

        $query = User::query()
            ->whereHas('bookPendingNotifications', function ($query) {
                $query->whereNull('notified_at');
            })
            ->where(function ($query) use ($yesterday) {
                $query
                    ->whereNull('book_last_notified_at')
                    ->orWhere('book_last_notified_at', '<=', $yesterday);
            });

        $query
            ->lazyById(500)
            ->each(function (User $user) {
                dispatch(new SendNewBooksNotificationJob($user));
            });
    }
}
