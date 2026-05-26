# Entity Relationship Diagram — TripKuy

```mermaid
erDiagram

    %% ─────────────────────────────────────
    %% USER & AUTH
    %% ─────────────────────────────────────

    users {
        bigint id PK
        string name
        string email
        timestamp email_verified_at
        string password
        string phone
        string avatar
        enum role "admin|user"
        timestamp created_at
        timestamp updated_at
    }

    %% ─────────────────────────────────────
    %% TRIP
    %% ─────────────────────────────────────

    categories {
        bigint id PK
        string name
        string slug
        string icon
        timestamp created_at
        timestamp updated_at
    }

    trips {
        bigint id PK
        bigint category_id FK
        string title
        string slug
        text description
        string highlight
        string destination
        string departure_city
        date start_date
        date end_date
        tinyint duration_days
        bigint price
        smallint quota
        smallint min_participants
        string cover_image
        enum status "draft|published|full|cancelled|completed"
        enum difficulty_level "easy|moderate|hard"
        string meeting_point
        json includes
        json excludes
        timestamp created_at
        timestamp updated_at
    }

    trip_itineraries {
        bigint id PK
        bigint trip_id FK
        tinyint day
        string title
        text description
        timestamp created_at
        timestamp updated_at
    }

    trip_images {
        bigint id PK
        bigint trip_id FK
        string image_path
        tinyint order
        timestamp created_at
        timestamp updated_at
    }

    trip_faqs {
        bigint id PK
        bigint trip_id FK
        string question
        text answer
        tinyint order
        timestamp created_at
        timestamp updated_at
    }

    trip_wishlists {
        bigint user_id FK
        bigint trip_id FK
        timestamp created_at
    }

    %% ─────────────────────────────────────
    %% BOOKING & TRANSAKSI
    %% ─────────────────────────────────────

    bookings {
        bigint id PK
        string booking_code
        bigint user_id FK
        bigint trip_id FK
        tinyint participant_count
        bigint total_price
        enum status "pending|confirmed|cancelled"
        text notes
        timestamp payment_deadline
        timestamp confirmed_at
        timestamp cancelled_at
        timestamp created_at
        timestamp updated_at
    }

    participants {
        bigint id PK
        bigint booking_id FK
        string name
        string id_number
        date date_of_birth
        enum gender "male|female"
        string phone
        string emergency_contact_name
        string emergency_contact_phone
        timestamp created_at
        timestamp updated_at
    }

    payments {
        bigint id PK
        bigint booking_id FK
        bigint amount
        string payment_method
        string proof_image
        enum status "pending|verified|rejected"
        text notes
        timestamp paid_at
        timestamp verified_at
        bigint verified_by FK
        timestamp created_at
        timestamp updated_at
    }

    reviews {
        bigint id PK
        bigint trip_id FK
        bigint user_id FK
        bigint booking_id FK
        tinyint rating "1-5"
        text comment
        timestamp created_at
        timestamp updated_at
    }

    %% ─────────────────────────────────────
    %% BLOG / KONTEN
    %% ─────────────────────────────────────

    post_categories {
        bigint id PK
        string name
        string slug
        string description
        timestamp created_at
        timestamp updated_at
    }

    posts {
        bigint id PK
        bigint post_category_id FK
        bigint user_id FK
        string title
        string slug
        string excerpt
        longtext content
        string cover_image
        enum status "draft|published|archived"
        timestamp published_at
        timestamp created_at
        timestamp updated_at
    }

    %% ─────────────────────────────────────
    %% RELASI
    %% ─────────────────────────────────────

    %% Trip
    categories         ||--o{ trips             : "memiliki"
    trips              ||--o{ trip_itineraries   : "memiliki"
    trips              ||--o{ trip_images        : "memiliki"
    trips              ||--o{ trip_faqs          : "memiliki"
    trips              ||--o{ reviews            : "menerima"
    trips              ||--o{ bookings           : "dipesan via"

    %% Wishlist (pivot)
    users              }o--o{ trips             : "wishlist"

    %% Booking
    users              ||--o{ bookings           : "membuat"
    bookings           ||--o{ participants       : "memiliki"
    bookings           ||--o{ payments           : "memiliki"
    bookings           ||--o| reviews            : "menghasilkan"

    %% Payment verification
    users              ||--o{ payments           : "memverifikasi"

    %% Review
    users              ||--o{ reviews            : "menulis"

    %% Blog
    post_categories    ||--o{ posts              : "memiliki"
    users              ||--o{ posts              : "menulis"
```

---

## Ringkasan Tabel

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Akun user dengan role admin/user |
| `categories` | Kategori trip (Petualangan, Pantai, dll) |
| `trips` | Data open trip: jadwal, harga, kuota, status |
| `trip_itineraries` | Jadwal harian per trip |
| `trip_images` | Galeri foto trip |
| `trip_faqs` | FAQ per trip |
| `trip_wishlists` | Pivot: trip yang disimpan user |
| `bookings` | Pemesanan trip oleh user |
| `participants` | Data peserta per booking |
| `payments` | Bukti pembayaran + status verifikasi |
| `reviews` | Ulasan & rating trip (1 booking = 1 review) |
| `post_categories` | Kategori artikel blog |
| `posts` | Artikel blog dengan konten HTML |

## Ringkasan Relasi

| Relasi | Jenis |
|--------|-------|
| Category → Trips | One-to-Many |
| Trip → Itineraries | One-to-Many |
| Trip → Images | One-to-Many |
| Trip → FAQs | One-to-Many |
| Trip → Bookings | One-to-Many |
| Trip → Reviews | One-to-Many |
| User ↔ Trip (wishlist) | Many-to-Many |
| User → Bookings | One-to-Many |
| User → Reviews | One-to-Many |
| User → Posts | One-to-Many |
| User → Payments (verifikasi) | One-to-Many |
| Booking → Participants | One-to-Many |
| Booking → Payments | One-to-Many |
| Booking → Review | One-to-One |
| PostCategory → Posts | One-to-Many |
