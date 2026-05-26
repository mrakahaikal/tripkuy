<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Spatie\Mjml\Mjml;

class TripCancelledEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Trip ' . $this->booking->trip->title . ' Dibatalkan',
        );
    }

    public function content(): Content
    {
        $mjml = view('mail.trip-cancelled', ['booking' => $this->booking->load('user', 'trip')])->render();
        $html = Mjml::new()->convert($mjml)->html();

        return new Content(htmlString: $html);
    }
}
