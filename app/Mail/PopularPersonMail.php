<?php

namespace App\Mail;

use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PopularPersonMail extends Mailable
{
    use Queueable, SerializesModels;

    public Person $person;

    /**
     * Create a new message instance.
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A person is liked by more than 50 users!',
        );
    }

    /**
     * Email content / view
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.popular_person',
            with: [
                'person' => $this->person,
            ],
        );
    }

    /**
     * Attachments (none needed).
     */
    public function attachments(): array
    {
        return [];
    }
}
