<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RealisticBookingSeeder extends Seeder
{
    public function run(): void
    {
        $trips = Trip::all();
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            $users = User::factory(10)->create(['role' => 'user']);
        }

        foreach ($trips as $trip) {
            // Create some past bookings (confirmed and reviewed)
            $this->createPastBookings($trip, $users);

            // Create some current bookings (pending or confirmed)
            $this->createCurrentBookings($trip, $users);
        }
    }

    private function createPastBookings(Trip $trip, $users): void
    {
        // 3-5 past bookings per trip
        $count = rand(3, 5);

        for ($i = 0; $i < $count; $i++) {
            $user = $users->random();
            $participantCount = rand(1, 4);

            $booking = Booking::create([
                'booking_code' => 'TRK-'.now()->subMonths(1)->format('Ymd').'-'.strtoupper(Str::random(6)),
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'participant_count' => $participantCount,
                'total_price' => $trip->price * $participantCount,
                'status' => 'confirmed',
                'notes' => rand(0, 1) ? 'Past booking notes' : null,
                'confirmed_at' => now()->subMonths(1),
                'created_at' => now()->subMonths(1)->subDays(2),
            ]);

            // Create participants
            Participant::factory($participantCount)->create([
                'booking_id' => $booking->id,
            ]);

            // Create verified payment
            Payment::factory()->verified()->create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'paid_at' => $booking->created_at->addHour(),
                'verified_at' => $booking->created_at->addHours(2),
            ]);

            // Create review
            Review::create([
                'trip_id' => $trip->id,
                'user_id' => $user->id,
                'booking_id' => $booking->id,
                'rating' => rand(4, 5),
                'comment' => $this->getRandomReviewComment(),
                'created_at' => now()->subDays(rand(1, 20)),
            ]);
        }
    }

    private function createCurrentBookings(Trip $trip, $users): void
    {
        // 2-3 current bookings
        $count = rand(2, 3);

        for ($i = 0; $i < $count; $i++) {
            $user = $users->random();
            $participantCount = rand(1, 2);
            $status = rand(0, 1) ? 'pending' : 'confirmed';

            $booking = Booking::create([
                'booking_code' => 'TRK-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'participant_count' => $participantCount,
                'total_price' => $trip->price * $participantCount,
                'status' => $status,
                'confirmed_at' => $status === 'confirmed' ? now()->subDay() : null,
                'created_at' => now()->subDays(2),
            ]);

            Participant::factory($participantCount)->create([
                'booking_id' => $booking->id,
            ]);

            if ($status === 'confirmed' || rand(0, 1)) {
                Payment::factory()->state([
                    'status' => $status === 'confirmed' ? 'verified' : 'pending',
                    'verified_at' => $status === 'confirmed' ? now()->subDay() : null,
                ])->create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_price,
                ]);
            }
        }
    }

    private function getRandomReviewComment(): string
    {
        $comments = [
            'Pengalaman yang luar biasa! Guide sangat membantu dan ramah.',
            'Pemandangannya indah sekali, tidak menyesal ikut trip ini.',
            'Fasilitas lengkap dan itinerary teratur dengan baik.',
            'Sangat direkomendasikan untuk yang ingin liburan tanpa ribet.',
            'Bromo saat sunrise benar-benar magis. Terima kasih TripKuy!',
            'Makanan enak, penginapan nyaman, dan teman-teman baru yang seru.',
            'Semuanya berjalan lancar dari awal sampai akhir. Mantap!',
            'Guide lokalnya sangat berwawasan luas tentang sejarah tempat ini.',
            'Raja Ampat memang surga dunia. Pelayanan di kapal sangat memuaskan.',
            'Pendakian yang menantang tapi sepadan dengan hasilnya. Tim porter sangat hebat.',
        ];

        return $comments[array_rand($comments)];
    }
}
