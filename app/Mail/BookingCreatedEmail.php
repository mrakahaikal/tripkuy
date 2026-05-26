<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Spatie\Mjml\Mjml;

class BookingCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Berhasil — ' . $this->booking->booking_code,
        );
    }

    public function content(): Content
    {
        $mjml = view('mail.booking-created', ['booking' => $this->booking->load('user', 'trip')])->render();
        $html = Mjml::new()->convert($mjml)->html();

        return new Content(htmlString: $html);
    }
}
