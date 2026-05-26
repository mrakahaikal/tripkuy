<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Trip;
use App\Models\TripItinerary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TripSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = $this->createCategories();
        $this->createTrips($categories);
    }

    /** @return array<string, Category> */
    private function createCategories(): array
    {
        $data = [
            ['name' => 'Petualangan',      'icon' => 'zap',      'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Alam & Pegunungan', 'icon' => 'mountain',  'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Pantai & Bahari',  'icon' => 'waves',     'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Budaya & Sejarah', 'icon' => 'landmark',  'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Religi',           'icon' => 'star',      'image' => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?auto=format&fit=crop&w=800&q=80'],
        ];

        $categories = [];
        foreach ($data as $item) {
            $categories[$item['name']] = Category::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                ['name' => $item['name'], 'icon' => $item['icon'], 'image' => $item['image']],
            );
        }

        return $categories;
    }

    /** @param array<string, Category> $categories */
    private function createTrips(array $categories): void
    {
        $trips = [
            [
                'category' => 'Alam & Pegunungan',
                'title' => 'Open Trip Bromo Sunrise',
                'destination' => 'Bromo, Jawa Timur',
                'departure_city' => 'Surabaya',
                'start_date' => now()->addDays(14),
                'duration_days' => 2,
                'price' => 450_000,
                'quota' => 20,
                'min_participants' => 8,
                'cover_image' => 'https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?auto=format&fit=crop&w=1200&q=80',
                'meeting_point' => 'Terminal Bungurasih, Surabaya',
                'description' => 'Nikmati pesona Gunung Bromo saat sunrise yang memukau. Trip ini akan membawa Anda menyaksikan lautan pasir yang luas, kawah aktif Bromo, serta pemandangan matahari terbit yang spektakuler dari Penanjakan.',
                'includes' => ['Transportasi PP', 'Jeep Bromo', 'Guide lokal', 'Tiket wisata', 'Sarapan hari ke-2'],
                'excludes' => ['Penginapan hari ke-1', 'Makan malam', 'Pengeluaran pribadi', 'Asuransi perjalanan'],
                'itineraries' => [
                    ['day' => 1, 'title' => 'Berangkat dari Surabaya', 'description' => 'Kumpul di Terminal Bungurasih pukul 22.00. Perjalanan menuju Cemoro Lawang ditempuh ±5 jam. Istirahat di penginapan.'],
                    ['day' => 2, 'title' => 'Sunrise Bromo & Perjalanan Pulang', 'description' => 'Pukul 03.00 berangkat ke Penanjakan menggunakan Jeep. Menyaksikan sunrise dan mengunjungi kawah Bromo. Sarapan, lalu kembali ke Surabaya.'],
                ],
            ],
            [
                'category' => 'Pantai & Bahari',
                'title' => 'Open Trip Raja Ampat Explorer',
                'destination' => 'Raja Ampat, Papua Barat',
                'departure_city' => 'Jakarta',
                'start_date' => now()->addDays(30),
                'duration_days' => 5,
                'price' => 4_500_000,
                'quota' => 15,
                'min_participants' => 8,
                'cover_image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f90f6?auto=format&fit=crop&w=1200&q=80',
                'meeting_point' => 'Bandara Domine Eduard Osok, Sorong',
                'description' => 'Jelajahi keindahan bawah laut Raja Ampat yang diakui sebagai salah satu spot diving terbaik di dunia. Saksikan terumbu karang yang berwarna-warni, ikan-ikan tropis, dan panorama pulau-pulau kecil yang eksotis.',
                'includes' => ['Kapal phinisi PP', 'Akomodasi di kapal', 'Makan 3x sehari', 'Snorkeling equipment', 'Guide lokal', 'Tiket masuk kawasan Raja Ampat'],
                'excludes' => ['Tiket pesawat ke Sorong', 'Diving equipment', 'Asuransi perjalanan', 'Pengeluaran pribadi'],
                'itineraries' => [
                    ['day' => 1, 'title' => 'Tiba di Sorong & Boarding', 'description' => 'Penjemputan di Bandara Sorong. Transfer ke pelabuhan dan naik kapal phinisi. Briefing dan makan malam di atas kapal.'],
                    ['day' => 2, 'title' => 'Misool & Pulau Fam', 'description' => 'Snorkeling di Pulau Misool yang terkenal dengan terumbu karang dan schooling fish. Sore hari mengunjungi Pulau Fam.'],
                    ['day' => 3, 'title' => 'Wayag & Piaynemo', 'description' => 'Trekking ke puncak Wayag untuk melihat gugusan pulau dari ketinggian. Sore hari ke Piaynemo, landmark ikonik Raja Ampat.'],
                    ['day' => 4, 'title' => 'Arborek & Pasir Timbul', 'description' => 'Kunjungan ke Desa Arborek dan melihat pasir timbul yang hanya muncul saat surut. Snorkeling terakhir di spot rahasia.'],
                    ['day' => 5, 'title' => 'Kembali ke Sorong', 'description' => 'Pagi hari kembali ke Sorong. Transfer ke bandara untuk penerbangan pulang.'],
                ],
            ],
            [
                'category' => 'Pantai & Bahari',
                'title' => 'Open Trip Labuan Bajo & Komodo',
                'destination' => 'Labuan Bajo, NTT',
                'departure_city' => 'Bali',
                'start_date' => now()->addDays(21),
                'duration_days' => 4,
                'price' => 2_800_000,
                'quota' => 18,
                'min_participants' => 8,
                'cover_image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?auto=format&fit=crop&w=1200&q=80',
                'meeting_point' => 'Bandara Komodo, Labuan Bajo',
                'description' => 'Petualangan seru melihat Komodo di habitat aslinya, snorkeling di spot terbaik, dan menikmati sunset di Bukit Cinta. Trip impian bagi pecinta alam dan bahari.',
                'includes' => ['Kapal wisata', 'Akomodasi 3 malam', 'Makan selama trip', 'Tiket Taman Nasional Komodo', 'Guide ranger', 'Snorkeling gear'],
                'excludes' => ['Tiket pesawat ke Labuan Bajo', 'Airport tax', 'Pengeluaran pribadi', 'Asuransi'],
                'itineraries' => [
                    ['day' => 1, 'title' => 'Tiba di Labuan Bajo', 'description' => 'Penjemputan di bandara. Check-in penginapan. Malam hari menikmati sunset di Bukit Cinta dan seafood dinner di dermaga.'],
                    ['day' => 2, 'title' => 'Pulau Komodo & Pink Beach', 'description' => 'Trekking di Pulau Komodo melihat komodo liar bersama ranger. Siang hari ke Pink Beach untuk snorkeling dan berjemur.'],
                    ['day' => 3, 'title' => 'Pulau Rinca & Manta Point', 'description' => 'Trekking Pulau Rinca, populasi komodo terbanyak. Sore hari ke Manta Point untuk berenang bersama pari manta.'],
                    ['day' => 4, 'title' => 'Pulau Padar & Kepulangan', 'description' => 'Sunrise trek ke Pulau Padar, pemandangan terbaik di Flores. Siang hari kembali ke Labuan Bajo dan transfer ke bandara.'],
                ],
            ],
            [
                'category' => 'Budaya & Sejarah',
                'title' => 'Open Trip Jogja Heritage',
                'destination' => 'Yogyakarta',
                'departure_city' => 'Jakarta',
                'start_date' => now()->addDays(7),
                'duration_days' => 3,
                'price' => 650_000,
                'quota' => 25,
                'min_participants' => 10,
                'cover_image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=80',
                'meeting_point' => 'Stasiun Tugu, Yogyakarta',
                'description' => 'Jelajahi kekayaan budaya Yogyakarta mulai dari Keraton, Borobudur, Prambanan, hingga kawasan seni Kotagede. Cocok untuk Anda yang ingin mengenal lebih dalam warisan budaya Jawa.',
                'includes' => ['Transportasi lokal', 'Guide berlisensi', 'Tiket masuk wisata', 'Makan 2x sehari', 'Batik workshop'],
                'excludes' => ['Tiket kereta/bus ke Jogja', 'Penginapan', 'Makan malam', 'Oleh-oleh'],
                'itineraries' => [
                    ['day' => 1, 'title' => 'Keraton & Malioboro', 'description' => 'Kunjungan ke Keraton Yogyakarta, Museum Sonobudoyo, dan Tamansari. Sore hari jalan-jalan di Malioboro.'],
                    ['day' => 2, 'title' => 'Borobudur & Prambanan', 'description' => 'Pagi hari ke Candi Borobudur, warisan budaya UNESCO. Siang hari ke Candi Prambanan. Sore hari Batik Workshop.'],
                    ['day' => 3, 'title' => 'Kotagede & Kepulangan', 'description' => 'Pagi hari mengunjungi kawasan pengrajin perak Kotagede dan pasar Beringharjo. Siang hari kembali ke stasiun.'],
                ],
            ],
            [
                'category' => 'Petualangan',
                'title' => 'Open Trip Rinjani Summit Attack',
                'destination' => 'Gunung Rinjani, Lombok',
                'departure_city' => 'Mataram',
                'start_date' => now()->addDays(45),
                'duration_days' => 4,
                'price' => 1_800_000,
                'quota' => 12,
                'min_participants' => 6,
                'cover_image' => 'https://images.unsplash.com/photo-1623916945674-98448a39151c?auto=format&fit=crop&w=1200&q=80',
                'meeting_point' => 'Desa Senaru, Lombok Utara',
                'description' => 'Taklukkan puncak Rinjani (3.726 mdpl), gunung berapi tertinggi kedua di Indonesia. Saksikan keindahan Danau Segara Anak, air terjun Sendang Gile, dan panorama Lombok dari ketinggian.',
                'includes' => ['Porter', 'Guide bersertifikat', 'Tenda & sleeping bag', 'Makan selama pendakian', 'Tiket masuk TNGR', 'P3K'],
                'excludes' => ['Transportasi ke Senaru', 'Penginapan hari pertama', 'Pengeluaran pribadi', 'Asuransi jiwa'],
                'itineraries' => [
                    ['day' => 1, 'title' => 'Senaru → Pos 3 (2.000 mdpl)', 'description' => 'Briefing dan registrasi. Pendakian dimulai dari Senaru (601 mdpl) melewati hutan tropis menuju Pos 3. Bermalam di tenda.'],
                    ['day' => 2, 'title' => 'Pos 3 → Rim Kawah → Danau Segara Anak', 'description' => 'Mendaki ke bibir kawah (2.639 mdpl) menyaksikan pemandangan spektakuler. Turun menuju Danau Segara Anak. Bermalam di tepi danau.'],
                    ['day' => 3, 'title' => 'Summit Attack (3.726 mdpl)', 'description' => 'Dini hari summit attack ke puncak Rinjani. Menyaksikan matahari terbit dari puncak. Turun kembali ke danau lalu menuju Sembalun.'],
                    ['day' => 4, 'title' => 'Descend ke Sembalun & Kepulangan', 'description' => 'Perjalanan turun melalui jalur Sembalun melintasi padang sabana. Tiba di Sembalun dan kembali ke Mataram.'],
                ],
            ],
            [
                'category' => 'Religi',
                'title' => 'Open Trip Tanah Suci Wali Songo',
                'destination' => 'Jawa Tengah & Jawa Timur',
                'departure_city' => 'Semarang',
                'start_date' => now()->addDays(10),
                'duration_days' => 3,
                'price' => 550_000,
                'quota' => 30,
                'min_participants' => 15,
                'cover_image' => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?auto=format&fit=crop&w=1200&q=80',
                'meeting_point' => 'Masjid Agung Jawa Tengah, Semarang',
                'description' => 'Ziarah ke makam-makam Wali Songo yang tersebar di Jawa Tengah dan Jawa Timur. Perjalanan spiritual yang memperkuat iman sekaligus mengenal sejarah penyebaran Islam di tanah Jawa.',
                'includes' => ['Bus AC', 'Guide spiritual', 'Makan 2x sehari', 'Air mineral', 'Doorprize'],
                'excludes' => ['Penginapan', 'Makan malam', 'Infaq/sedekah', 'Pengeluaran pribadi'],
                'itineraries' => [
                    ['day' => 1, 'title' => 'Sunan Kalijaga & Sunan Kudus', 'description' => 'Ziarah ke Makam Sunan Kalijaga di Demak dan Masjid Agung Demak. Melanjutkan ke Makam Sunan Kudus di Menara Kudus.'],
                    ['day' => 2, 'title' => 'Sunan Muria & Sunan Bonang', 'description' => 'Pagi hari ke Makam Sunan Muria di Gunung Muria. Siang hari perjalanan ke Tuban untuk ziarah ke Makam Sunan Bonang.'],
                    ['day' => 3, 'title' => 'Sunan Ampel & Kembali', 'description' => 'Pagi hari ziarah ke Makam Sunan Ampel di Surabaya dan mengunjungi Pasar Arab Ampel. Siang hari kembali ke Semarang.'],
                ],
            ],
        ];

        foreach ($trips as $data) {
            $category = $categories[$data['category']];

            $startDate = $data['start_date'];
            $endDate = (clone $startDate)->modify("+{$data['duration_days']} days");

            $trip = Trip::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'category_id' => $category->id,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'destination' => $data['destination'],
                    'departure_city' => $data['departure_city'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'duration_days' => $data['duration_days'],
                    'price' => $data['price'],
                    'quota' => $data['quota'],
                    'min_participants' => $data['min_participants'],
                    'meeting_point' => $data['meeting_point'],
                    'cover_image' => $data['cover_image'],
                    'status' => 'published',
                    'includes' => $data['includes'],
                    'excludes' => $data['excludes'],
                ],
            );

            foreach ($data['itineraries'] as $itinerary) {
                TripItinerary::updateOrCreate(
                    ['trip_id' => $trip->id, 'day' => $itinerary['day']],
                    ['title' => $itinerary['title'], 'description' => $itinerary['description']],
                );
            }
        }
    }
}
