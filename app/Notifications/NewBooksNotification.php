<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class NewBooksNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected readonly Collection $books)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Новинки от ваших любимых авторов!')
            ->line('За последние сутки вышли новые книги:');

        foreach ($this->books as $book) {
            /** @var Book $book */
            $mail->line(sprintf('«%s» — Авторы: %s', $book->name, $book->authors->pluck('name')->join(', ')));
        }

        return $mail->action('Читать новинки', url('/'));
    }
}
