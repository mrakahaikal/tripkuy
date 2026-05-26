<?php

namespace App\Actions\Bookings;

use App\Mail\BookingCreatedEmail;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CreateBookingAction
{
    /**
     * @param  array{
     *     participant_count: int,
     *     notes: string|null,
     *     participants: array<int, array{
     *         name: string,
     *         id_number: string,
     *         date_of_birth: string,
     *         gender: string,
     *         phone: string|null,
     *         emergency_contact_name: string|null,
     *         emergency_contact_phone: string|null,
     *     }>,
     * } $data
     */
    public function execute(User $user, Trip $trip, array $data): Booking
    {
        $availableSlots = $trip->availableSlots();

        if ($availableSlots < $data['participant_count']) {
            throw ValidationException::withMessages([
                'participant_count' => "Slot tersedia hanya {$availableSlots} orang.",
            ]);
        }

        $booking = DB::transaction(function () use ($user, $trip, $data): Booking {
            $booking = Booking::create([
                'booking_code'      => $this->generateUniqueCode(),
                'user_id'           => $user->id,
                'trip_id'           => $trip->id,
                'participant_count' => $data['participant_count'],
                'total_price'       => $trip->price * $data['participant_count'],
                'status'            => 'pending',
                'notes'             => $data['notes'] ?? null,
                'payment_deadline'  => now()->addHours(24),
            ]);

            foreach ($data['participants'] as $participant) {
                $booking->participants()->create($participant);
            }

            return $booking;
        });

        Mail::to($user)->send(new BookingCreatedEmail($booking));

        return $booking;
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = 'TRK-' . now()->format('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
