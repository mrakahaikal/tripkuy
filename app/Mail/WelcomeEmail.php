<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Spatie\Mjml\Mjml;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang di TripKuy, ' . $this->user->name . '!',
        );
    }

    public function content(): Content
    {
        $mjml = view('mail.welcome', ['user' => $this->user])->render();
        $html = Mjml::new()->convert($mjml)->html();

        return new Content(htmlString: $html);
    }
}
