@extends('mail.layouts.base')
@section('preview', 'Selamat datang di TripKuy, ' . $user->name . '!')

@section('body')

<mj-section background-color="#ffffff" padding="40px 32px 32px" border-radius="0">
  <mj-column>
    <mj-text font-size="26px" font-weight="700" color="#111827" line-height="1.3">
      Selamat datang, {{ $user->name }}! 👋
    </mj-text>
    <mj-text padding-top="12px" color="#6B7280">
      Akun kamu di <strong style="color: #111827;">TripKuy</strong> telah berhasil dibuat. Sekarang kamu bisa mulai menjelajahi ratusan trip seru dan memesan perjalanan impianmu dengan mudah.
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 32px">
  <mj-column background-color="#F0FDFA" border-radius="10px" padding="20px 24px">
    <mj-text font-size="14px" font-weight="600" color="#0F766E" padding-bottom="4px">
      Apa yang bisa kamu lakukan di TripKuy?
    </mj-text>
    <mj-text font-size="14px" color="#374151" padding-top="0">
      ✅ &nbsp;Jelajahi trip dengan berbagai kategori &amp; tingkat kesulitan<br />
      ✅ &nbsp;Pesan trip dan bayar dengan mudah<br />
      ✅ &nbsp;Simpan trip favorit ke wishlist<br />
      ✅ &nbsp;Pantau status booking secara real-time
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 40px">
  <mj-column>
    <mj-button href="{{ url('/trips') }}" align="left">
      Mulai Jelajahi Trip →
    </mj-button>
  </mj-column>
</mj-section>

@endsection
