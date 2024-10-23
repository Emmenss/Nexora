<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $datamail;

    public function __construct($datamail)
    {
        $this->datamail = $datamail;
    }

    // public function build()
    // {
    //     return $this->view('emails.test_email')
    //                 ->subject($this->datamail['title'])
    //                 ->with('datamail', $this->datamail);
    // }

   

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test_email',
        );
    }

//     public function build()
// {
//     return $this->subject('Notification de votre application')
//                 ->view('emails.test_email'); // Utilise le chemin complet ici
// }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
