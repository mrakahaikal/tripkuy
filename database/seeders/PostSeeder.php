<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::where('email', 'admin@tripkuy.test')->first();
        $categories = $this->createCategories();
        $this->createPosts($categories, $admin);
    }

    /** @return array<string, PostCategory> */
    private function createCategories(): array
    {
        $data = [
            ['name' => 'Tips Perjalanan', 'description' => 'Panduan dan tips praktis untuk perjalanan yang lebih nyaman.'],
            ['name' => 'Destinasi', 'description' => 'Ulasan lengkap berbagai destinasi wisata di Indonesia.'],
            ['name' => 'Kuliner', 'description' => 'Rekomendasi makanan dan minuman khas tiap daerah.'],
            ['name' => 'Budaya', 'description' => 'Kekayaan budaya, tradisi, dan seni nusantara.'],
            ['name' => 'Panduan Wisata', 'description' => 'Itinerary dan panduan lengkap untuk berbagai destinasi.'],
        ];

        $categories = [];
        foreach ($data as $item) {
            $categories[$item['name']] = PostCategory::firstOrCreate(
                ['slug' => Str::slug($item['name'])],
                ['name' => $item['name'], 'description' => $item['description']],
            );
        }

        return $categories;
    }

    /**
     * @param  array<string, PostCategory>  $categories
     */
    private function createPosts(array $categories, ?User $author): void
    {
        $authorId = $author?->id ?? User::first()?->id;

        $posts = [
            [
                'category' => 'Tips Perjalanan',
                'title' => '10 Tips Packing Cerdas untuk Open Trip Agar Tidak Overload',
                'excerpt' => 'Bawa barang terlalu banyak saat open trip bisa menjadi beban. Simak tips packing cerdas berikut agar perjalananmu lebih ringan dan menyenangkan.',
                'content' => $this->contentPackingTips(),
                'cover_image' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(10),
            ],
            [
                'category' => 'Destinasi',
                'title' => 'Mengapa Raja Ampat Jadi Surga Bawah Laut Terbaik di Dunia',
                'excerpt' => 'Raja Ampat bukan sekadar destinasi wisata biasa. Kawasan ini menyimpan keanekaragaman hayati laut tertinggi di dunia yang membuat setiap penyelam terkagum-kagum.',
                'content' => $this->contentRajaAmpat(),
                'cover_image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f90f6?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(7),
            ],
            [
                'category' => 'Panduan Wisata',
                'title' => 'Panduan Lengkap Open Trip Bromo: Dari Persiapan hingga Pulang',
                'excerpt' => 'Gunung Bromo adalah salah satu destinasi paling ikonik di Indonesia. Berikut panduan lengkap yang perlu kamu ketahui sebelum ikut open trip Bromo.',
                'content' => $this->contentGuideBromo(),
                'cover_image' => 'https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(5),
            ],
            [
                'category' => 'Kuliner',
                'title' => 'Wajib Dicoba! 7 Kuliner Khas Lombok yang Bikin Ketagihan',
                'excerpt' => 'Lombok tidak hanya terkenal dengan pantainya yang memukau, tapi juga kekayaan kulinernya. Dari ayam taliwang hingga plecing kangkung, inilah yang wajib kamu coba.',
                'content' => $this->contentKulinerLombok(),
                'cover_image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(3),
            ],
            [
                'category' => 'Budaya',
                'title' => 'Mengenal Tradisi Ngaben: Upacara Kremasi Suci di Bali',
                'excerpt' => 'Ngaben adalah upacara kremasi umat Hindu Bali yang sarat makna spiritual. Memahami tradisi ini akan membuat pengalaman wisata budaya kamu di Bali semakin bermakna.',
                'content' => $this->contentNgaben(),
                'cover_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(2),
            ],
            [
                'category' => 'Tips Perjalanan',
                'title' => 'Cara Memilih Open Trip yang Aman dan Terpercaya',
                'excerpt' => 'Maraknya penipuan open trip membuat wisatawan harus lebih selektif. Simak panduan ini agar kamu tidak salah pilih operator trip.',
                'content' => $this->contentMemilihOpenTrip(),
                'cover_image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(1),
            ],
            [
                'category' => 'Destinasi',
                'title' => 'Pesona Labuan Bajo: Gerbang Menuju Keajaiban Flores',
                'excerpt' => 'Labuan Bajo telah menjelma menjadi salah satu destinasi premium Indonesia. Temukan pesona kota kecil ini sebelum menjelajahi Komodo dan sekitarnya.',
                'content' => $this->contentLabuanBajo(),
                'cover_image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now(),
            ],
            [
                'category' => 'Panduan Wisata',
                'title' => 'Itinerary 3 Hari 2 Malam Jogja yang Wajib Kamu Coba',
                'excerpt' => 'Yogyakarta selalu punya cerita. Dengan itinerary 3 hari ini, kamu bisa menjelajahi Borobudur, Prambanan, Keraton, dan sudut-sudut tersembunyi kota pelajar ini.',
                'content' => $this->contentItineraryJogja(),
                'cover_image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subHours(6),
            ],
        ];

        foreach ($posts as $data) {
            $category = $categories[$data['category']];

            Post::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'post_category_id' => $category->id,
                    'user_id' => $authorId,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'cover_image' => $data['cover_image'],
                    'status' => 'published',
                    'published_at' => $data['published_at'],
                ],
            );
        }
    }

    private function contentPackingTips(): string
    {
        return <<<'HTML'
<p>Salah satu tantangan terbesar saat ikut open trip adalah memutuskan apa yang perlu dibawa dan apa yang bisa ditinggal. Koper yang berat hanya akan menyusahkan dirimu sendiri, terutama jika trip melibatkan trekking atau naik kapal.</p>

<h2>1. Gunakan Tas Ransel, Bukan Koper</h2>
<p>Untuk open trip yang melibatkan mobilitas tinggi, ransel 40–50 liter jauh lebih praktis daripada koper. Ransel bisa digendong di punggung, masuk ke bagasi kapal, dan lebih mudah dibawa saat trekking.</p>

<h2>2. Prinsip Satu Minggu, Satu Outfit</h2>
<p>Banyak traveler berpengalaman menerapkan aturan: 1 baju untuk 2 hari. Cuci dan keringkan di malam hari. Ini menghemat ruang secara drastis.</p>

<h2>3. Bawa Obat-obatan Pribadi</h2>
<p>Jangan andalkan toko obat di lokasi tujuan. Bawa obat maag, antidiare, pereda nyeri, obat alergi, dan plester. Lebih baik membawa tapi tidak dipakai daripada butuh tapi tidak ada.</p>

<h2>4. Pisahkan Dokumen Penting</h2>
<p>KTP, kartu ATM, dan uang tunai jangan ditaruh di satu tempat. Gunakan dompet kecil yang bisa diikat di pinggang untuk akses mudah saat check-in atau beli tiket.</p>

<h2>5. Bawa Power Bank Berkapasitas Besar</h2>
<p>Minimal 20.000 mAh untuk perjalanan 3–5 hari. Di lokasi terpencil seperti Raja Ampat atau Rinjani, colokan listrik adalah kemewahan langka.</p>

<h2>6. Jas Hujan, Bukan Payung</h2>
<p>Payung tidak praktis saat trekking atau di kapal. Jas hujan ponco transparan lebih ringan, mudah dipakai, dan melindungi tas sekaligus.</p>

<h2>7. Sandal Jepit dan Sepatu Trekking</h2>
<p>Dua alas kaki ini sudah cukup untuk mayoritas open trip. Sandal untuk santai di pantai atau penginapan, sepatu trekking untuk jalur mendaki.</p>

<h2>8. Sunscreen dan Lip Balm Wajib</h2>
<p>Sering dilupakan tapi sangat penting, terutama untuk trip pantai. Paparan sinar UV di destinasi tropis Indonesia bisa sangat intens.</p>

<h2>9. Dry Bag untuk Trip Bahari</h2>
<p>Jika trip melibatkan snorkeling, kapal, atau pantai, dry bag adalah investasi terbaik. Simpan ponsel, kamera, dan dokumen agar tidak kena air.</p>

<h2>10. Jangan Lupa Cek List Sehari Sebelum</h2>
<p>Buat daftar barang dan centang satu per satu sehari sebelum berangkat. Ini mencegah lupa membawa hal-hal kecil tapi penting seperti charger atau earphone.</p>

<p>Dengan persiapan yang tepat, kamu bisa menikmati setiap momen open trip tanpa direpotkan oleh bawaan yang berlebihan. Selamat berpetualang!</p>
HTML;
    }

    private function contentRajaAmpat(): string
    {
        return <<<'HTML'
<p>Terletak di ujung timur Indonesia, Raja Ampat adalah gugusan kepulauan di Papua Barat yang terdiri dari lebih dari 1.500 pulau kecil, cay, dan gosong pasir. Nama "Raja Ampat" berasal dari legenda lokal tentang empat raja yang lahir dari telur — Waigeo, Batanta, Salawati, dan Misool.</p>

<h2>Keanekaragaman Hayati Tertinggi di Dunia</h2>
<p>Menurut penelitian Conservation International, Raja Ampat memiliki keanekaragaman hayati laut tertinggi yang pernah dicatat di planet ini. Lebih dari 1.300 spesies ikan karang, 600 spesies karang keras, dan 700 spesies moluska telah teridentifikasi di sini.</p>

<h2>Spot Diving dan Snorkeling Ikonik</h2>
<p>Beberapa spot paling terkenal antara lain:</p>
<ul>
<li><strong>Cape Kri</strong> — rekor dunia dengan 374 spesies ikan dalam satu penyelaman</li>
<li><strong>Manta Sandy</strong> — tempat berenang bersama pari manta raksasa</li>
<li><strong>Blue Magic</strong> — arus kuat dengan ikan-ikan pelagis besar</li>
<li><strong>Passage</strong> — kanal sempit dengan terumbu karang spektakuler</li>
</ul>

<h2>Wayag: Ikon Fotografi Raja Ampat</h2>
<p>Gugusan pulau karst Wayag adalah salah satu pemandangan paling ikonik di Indonesia. Trekking singkat ke puncaknya menghadirkan panorama lautan hijau dengan pulau-pulau berbentuk jamur yang tersebar tak beraturan.</p>

<h2>Waktu Terbaik Berkunjung</h2>
<p>Oktober hingga April adalah musim terbaik dengan visibilitas bawah laut terbaik dan laut yang tenang. Hindari Mei–Agustus karena angin kencang dan gelombang tinggi sering terjadi.</p>

<h2>Cara Menuju Raja Ampat</h2>
<p>Penerbangan ke Sorong tersedia dari Jakarta, Makassar, dan Manado. Dari Pelabuhan Sorong, naik kapal feri atau speedboat menuju Waisai, ibu kota Raja Ampat, yang ditempuh sekitar 2 jam.</p>

<p>Raja Ampat bukan sekadar destinasi wisata — ia adalah pengingat betapa kayanya alam Indonesia yang harus kita jaga bersama.</p>
HTML;
    }

    private function contentGuideBromo(): string
    {
        return <<<'HTML'
<p>Gunung Bromo (2.329 mdpl) adalah gunung berapi aktif yang terletak di Taman Nasional Bromo Tengger Semeru, Jawa Timur. Setiap tahun, ribuan wisatawan datang untuk menyaksikan panorama sunrise-nya yang legendaris.</p>

<h2>Persiapan Sebelum Berangkat</h2>
<p>Cuaca di Bromo sangat dingin, terutama dini hari saat menuju Penanjakan. Suhu bisa turun hingga 0–5°C. Siapkan:</p>
<ul>
<li>Jaket tebal atau windbreaker</li>
<li>Sarung tangan dan kupluk</li>
<li>Masker (untuk debu vulkanik)</li>
<li>Sepatu tertutup yang nyaman</li>
<li>Kamera dengan baterai penuh</li>
</ul>

<h2>Itinerary Open Trip Bromo 2 Hari 1 Malam</h2>
<p><strong>Hari 1</strong></p>
<p>Kumpul di Surabaya atau Malang pada malam hari. Perjalanan darat menuju Cemoro Lawang (pintu masuk Bromo) ditempuh sekitar 4–5 jam. Istirahat di penginapan hingga dini hari.</p>

<p><strong>Hari 2</strong></p>
<p>Pukul 02.30: Bangun dan bersiap. Naik Jeep 4WD menuju Penanjakan 1 untuk menyaksikan sunrise. Setelah matahari terbit, turun menuju lautan pasir dan berjalan kaki atau naik kuda ke kawah Bromo. Pukul 10.00: Kembali ke penginapan, sarapan, dan perjalanan pulang.</p>

<h2>Tiket Masuk dan Biaya</h2>
<p>Tiket masuk TNBTS untuk wisatawan domestik berkisar Rp 29.000 (hari biasa) hingga Rp 34.000 (akhir pekan). Sewa Jeep untuk 6 orang sekitar Rp 750.000–850.000 per unit.</p>

<h2>Tips Tambahan</h2>
<p>Datang di weekday jika ingin menghindari keramaian. Bawa uang tunai karena ATM sangat terbatas di area Cemoro Lawang. Jangan buang sampah sembarangan di kawasan taman nasional.</p>
HTML;
    }

    private function contentKulinerLombok(): string
    {
        return <<<'HTML'
<p>Lombok dikenal sebagai "Pulau Seribu Masjid" dengan budaya Sasak yang kaya. Kulinernya pun tak kalah menarik — didominasi cita rasa pedas dan gurih yang khas. Inilah 7 makanan wajib coba saat berkunjung ke Lombok.</p>

<h2>1. Ayam Taliwang</h2>
<p>Ini adalah kuliner paling ikonik dari Lombok. Ayam kampung dibakar atau digoreng dengan bumbu khas yang pedas dan gurih, terbuat dari cabai merah, bawang putih, kencur, dan terasi. Disajikan dengan plecing kangkung dan beberuk terong.</p>

<h2>2. Plecing Kangkung</h2>
<p>Sayur kangkung rebus yang disiram sambal tomat segar dengan perasan jeruk limau. Segar, pedas, dan sangat cocok dimakan bersama ayam taliwang. Ini adalah paduan sempurna kuliner Lombok.</p>

<h2>3. Beberuk Terong</h2>
<p>Potongan terong dan kacang panjang segar yang disiram bumbu rempah pedas. Berbeda dari terong yang dimasak, beberuk menggunakan terong mentah sehingga teksturnya renyah.</p>

<h2>4. Sate Pusut</h2>
<p>Sate khas Sasak yang menggunakan daging cincang (biasanya campur sapi dan kelapa parut) yang dililitkan pada bambu. Bumbu rempahnya kaya dan aromanya sangat menggugah selera.</p>

<h2>5. Nasi Balap Puyung</h2>
<p>Nasi putih dengan lauk serundeng pedas, ikan teri, dan sayuran. Meski tampilannya sederhana, rasanya sangat nendang dan bikin ketagihan. Makanan favorit warga Lombok untuk sarapan.</p>

<h2>6. Ares</h2>
<p>Sayur batang pisang muda yang dimasak dengan santan dan rempah-rempah. Teksturnya lembut dan rasanya gurih. Ares adalah makanan khas yang biasa disajikan pada upacara adat Sasak.</p>

<h2>7. Es Kelapa Muda Jeruk Nipis</h2>
<p>Setelah menikmati hidangan pedas, tutup dengan es kelapa muda segar yang dicampurkan perasan jeruk nipis dan sedikit gula merah. Minuman sederhana yang menyegarkan jiwa dan raga.</p>

<p>Jangan lupa mampir ke Rumah Makan Taliwang Irama di Cakranegara untuk pengalaman ayam taliwang yang autentik!</p>
HTML;
    }

    private function contentNgaben(): string
    {
        return <<<'HTML'
<p>Bagi umat Hindu Bali, kematian bukanlah akhir, melainkan sebuah perjalanan menuju kehidupan berikutnya. Ngaben adalah upacara kremasi yang membantu jiwa seseorang yang telah meninggal untuk melepaskan diri dari ikatan dunia dan menuju alam berikutnya.</p>

<h2>Makna Filosofis Ngaben</h2>
<p>Ngaben berasal dari kata "beya" yang berarti bekal. Upacara ini diyakini sebagai pemberian bekal spiritual bagi roh orang yang telah meninggal untuk perjalanannya ke alam lain. Api pembakaran dianggap suci karena memurnikan dan membebaskan jiwa.</p>

<h2>Proses Upacara</h2>
<p>Ngaben biasanya melibatkan beberapa tahapan panjang yang bisa berlangsung berhari-hari:</p>
<ul>
<li><strong>Persiapan</strong>: Membuat bade (menara kremasi) dan lembu (patung banteng untuk wadah jenazah) yang bisa memakan waktu berminggu-minggu</li>
<li><strong>Prosesi</strong>: Arak-arakan membawa jenazah menuju tempat kremasi dengan iringan gamelan dan doa</li>
<li><strong>Pembakaran</strong>: Jenazah dibakar dalam bade atau lembu yang telah disiapkan</li>
<li><strong>Nganyud</strong>: Abu jenazah dihanyutkan ke laut atau sungai</li>
</ul>

<h2>Ngaben sebagai Perayaan, Bukan Dukacita</h2>
<p>Hal yang mungkin mengejutkan bagi wisatawan adalah suasana Ngaben yang tidak selalu penuh kesedihan. Keluarga yang ditinggalkan percaya bahwa menangis bisa menghambat perjalanan roh. Upacara ini sering diiringi gamelan yang meriah dan penuh warna.</p>

<h2>Etika Menyaksikan Ngaben</h2>
<p>Jika berkesempatan menyaksikan Ngaben, hormati prosesi dengan berpakaian sopan (sarung dan selendang), tidak memotret sembarangan, dan tidak masuk ke area yang dilarang. Banyak keluarga Bali justru senang jika wisatawan ikut menyaksikan sebagai bentuk penghormatan.</p>

<p>Memahami Ngaben adalah memahami cara pandang orang Bali tentang kehidupan, kematian, dan siklus alam semesta yang tak pernah berhenti berputar.</p>
HTML;
    }

    private function contentMemilihOpenTrip(): string
    {
        return <<<'HTML'
<p>Open trip semakin populer sebagai pilihan wisata yang hemat dan seru. Namun, tidak semua operator trip bisa dipercaya. Kasus pungutan liar, fasilitas tidak sesuai janji, hingga penipuan berkedok open trip masih sering terjadi. Berikut cara memilih open trip yang aman.</p>

<h2>1. Cek Legalitas Operator</h2>
<p>Pastikan operator memiliki izin usaha perjalanan wisata (SIUP bidang pariwisata) yang valid. Operator yang terdaftar di ASITA (Asosiasi Perusahaan Perjalanan Wisata Indonesia) atau PHRI lebih dapat dipercaya.</p>

<h2>2. Baca Ulasan di Berbagai Platform</h2>
<p>Jangan hanya percaya ulasan di website mereka sendiri. Cari ulasan di Google Maps, TripAdvisor, dan media sosial. Perhatikan pola keluhan yang berulang — itu sinyal peringatan.</p>

<h2>3. Minta Itinerary dan Detail Fasilitas Tertulis</h2>
<p>Operator yang profesional akan dengan senang hati memberikan itinerary lengkap, daftar fasilitas yang termasuk (akomodasi, makan, transportasi), dan yang tidak termasuk. Jika mereka enggan atau informasinya samar, waspadalah.</p>

<h2>4. Hindari Transfer ke Rekening Pribadi</h2>
<p>Selalu bayar ke rekening perusahaan, bukan rekening pribadi atas nama seseorang. Simpan bukti transfer dan konfirmasi booking dalam bentuk tertulis.</p>

<h2>5. Tanya Soal Asuransi Perjalanan</h2>
<p>Operator yang bertanggung jawab biasanya menyarankan atau bahkan mewajibkan peserta memiliki asuransi perjalanan, terutama untuk trip petualangan seperti pendakian gunung atau diving.</p>

<h2>6. Verifikasi Guide dan Fasilitasnya</h2>
<p>Tanya apakah guide memiliki sertifikasi resmi (HNSI untuk pendakian, SSI/PADI untuk diving). Guide bersertifikat adalah jaminan keselamatan yang tidak bisa dikompromikan.</p>

<h2>7. Perhatikan Kuota Peserta</h2>
<p>Trip dengan kuota terlalu besar (misalnya 50+ orang untuk pendakian gunung) biasanya kualitasnya menurun drastis. Cari operator yang membatasi peserta untuk pengalaman yang lebih personal dan aman.</p>

<p>Open trip yang baik adalah yang memberikan pengalaman tak terlupakan dengan keselamatan sebagai prioritas utama. Jangan tergiur harga murah tanpa memeriksa kualitasnya terlebih dahulu.</p>
HTML;
    }

    private function contentLabuanBajo(): string
    {
        return <<<'HTML'
<p>Beberapa tahun lalu, Labuan Bajo hanyalah kota pelabuhan kecil yang dikenal sebagai gerbang menuju Taman Nasional Komodo. Kini, kota di ujung barat Flores ini telah bertransformasi menjadi salah satu destinasi super premium Indonesia.</p>

<h2>Mengapa Labuan Bajo Semakin Populer?</h2>
<p>Pemerintah Indonesia menetapkan Labuan Bajo sebagai salah satu dari lima "Bali Baru" yang diprioritaskan pengembangannya. Infrastruktur terus diperbaiki: jalan diperlebar, bandara diperbesar, dan kawasan wisata ditata lebih rapi.</p>

<h2>Atraksi Utama di Labuan Bajo</h2>
<p><strong>Bukit Cinta</strong> — Spot terbaik untuk menyaksikan sunset dengan pemandangan gugusan pulau di kejauhan. Wajib dikunjungi di hari pertama tiba.</p>

<p><strong>Pulau Padar</strong> — Trekking 30 menit menuju puncak memberikan pemandangan tiga teluk berwarna berbeda: hitam, putih, dan merah jambu. Ini adalah ikon Labuan Bajo yang paling difoto.</p>

<p><strong>Pink Beach</strong> — Pantai berpasir merah muda akibat campuran pecahan terumbu karang merah. Spot snorkeling dengan terumbu karang yang masih sangat terjaga.</p>

<p><strong>Manta Point</strong> — Perairan di sekitar Pulau Mauan ini adalah rumah bagi ratusan pari manta yang berenang bebas. Pengalaman berenang bersama manta adalah momen yang tidak akan terlupakan.</p>

<h2>Kuliner di Labuan Bajo</h2>
<p>Dermaga Labuan Bajo dipenuhi restoran seafood dengan pemandangan laut yang memukau. Coba ikan bakar segar dengan harga terjangkau, atau mampir ke Warung Sopa untuk mencicipi masakan Flores yang autentik.</p>

<h2>Tips Berkunjung</h2>
<p>Datanglah di musim kemarau (April–November) untuk cuaca terbaik. Pesan paket kapal dari jauh hari karena slot cepat penuh, terutama di musim liburan. Jangan lupa membawa sunscreen SPF tinggi karena sinar matahari di Flores sangat terik.</p>
HTML;
    }

    private function contentItineraryJogja(): string
    {
        return <<<'HTML'
<p>Yogyakarta adalah kota yang tidak pernah kehabisan cerita. Dengan itinerary 3 hari ini, kamu bisa menikmati warisan UNESCO, kuliner legendaris, dan kehangatan budaya Jawa tanpa terburu-buru.</p>

<h2>Hari 1: Borobudur dan Prambanan</h2>
<p><strong>Pagi (05.00)</strong>: Tiba di Borobudur sebelum matahari terbit. Momen sunrise di atas candi Buddha terbesar di dunia ini adalah pengalaman spiritual yang tak tertandingi. Masuk lebih awal ke zona candi atas (paket sunrise tersedia).</p>

<p><strong>Siang (12.00)</strong>: Kembali ke Jogja, makan siang di Warung Bu Ageng — gudeg autentik yang sudah ada sejak puluhan tahun.</p>

<p><strong>Sore (15.00)</strong>: Kunjungi Candi Prambanan, kompleks candi Hindu terbesar di Indonesia. Saksikan pertunjukan Sendratari Ramayana jika jadwalnya pas.</p>

<h2>Hari 2: Keraton dan Malioboro</h2>
<p><strong>Pagi (08.00)</strong>: Kunjungi Keraton Yogyakarta, tempat tinggal resmi Sultan Hamengkubuwono. Ikuti tur pagi untuk melihat koleksi benda bersejarah dan pertunjukan seni tradisional.</p>

<p><strong>Siang (11.00)</strong>: Jelajahi Tamansari, bekas taman istana yang kini menjadi kawasan seni dengan street art yang instagramable.</p>

<p><strong>Sore (16.00)</strong>: Jalan-jalan di Malioboro, pusat oleh-oleh Jogja. Beli batik, bakpia, dan berbagai kerajinan tangan khas. Makan malam di angkringan pinggir rel kereta — pengalaman kuliner paling autentik di Jogja.</p>

<h2>Hari 3: Gunung Merapi dan Kotagede</h2>
<p><strong>Pagi (07.00)</strong>: Jeep Lava Tour Merapi. Jelajahi bekas jalur lava dan desa-desa yang terdampak erupsi 2010 dengan Jeep off-road. Pemandangan Merapi dari dekat sungguh mendebarkan.</p>

<p><strong>Siang (12.00)</strong>: Makan siang di Kaliurang sambil menikmati udara pegunungan yang sejuk.</p>

<p><strong>Sore (15.00)</strong>: Kunjungi Kotagede, kampung pengrajin perak tertua di Jogja. Lihat proses pembuatan perhiasan perak tradisional dan bawa pulang sebagai oleh-oleh eksklusif.</p>

<h2>Tips Tambahan</h2>
<p>Sewa sepeda motor adalah cara terbaik berkeliling Jogja (Rp 70.000–100.000/hari). Hindari berkunjung saat libur nasional karena semua tempat wisata akan sangat ramai. Bawa uang tunai karena banyak warung dan parkir tidak menerima pembayaran digital.</p>
HTML;
    }
}
