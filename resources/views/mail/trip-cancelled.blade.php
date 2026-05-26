@extends('mail.layouts.base')
@section('preview', 'Trip ' . $booking->trip->title . ' dibatalkan')

@section('body')

<mj-section background-color="#ffffff" padding="40px 32px 24px">
  <mj-column>
    <mj-text font-size="26px" font-weight="700" color="#111827" line-height="1.3">
      Trip dibatalkan oleh penyelenggara
    </mj-text>
    <mj-text padding-top="8px" color="#6B7280">
      Halo {{ $booking->user->name }}, kami dengan berat hati memberitahu bahwa trip berikut harus dibatalkan oleh tim TripKuy.
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column background-color="#FEF2F2" border-radius="10px" padding="20px 24px">
    <mj-text font-size="13px" color="#B91C1C" font-weight="600" letter-spacing="0.5px">
      TRIP DIBATALKAN
    </mj-text>
    <mj-text font-size="20px" font-weight="700" color="#7F1D1D" padding-top="4px" line-height="1.3">
      {{ $booking->trip->title }}
    </mj-text>
    <mj-text font-size="14px" color="#991B1B" padding-top="4px">
      {{ $booking->trip->start_date->format('d M Y') }} – {{ $booking->trip->end_date->format('d M Y') }}
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column border="1px solid #E5E7EB" border-radius="10px" padding="20px 24px">
    <mj-table>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px; width: 44%;">Kode Booking</td>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px; font-weight: 600; font-family: 'Courier New', monospace;">{{ $booking->booking_code }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Peserta</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->participant_count }} orang</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Total Bayar</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
    </mj-table>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column background-color="#F0FDFA" border-radius="10px" padding="16px 20px">
    <mj-text font-size="14px" color="#134E4A">
      💬 &nbsp;<strong>Proses pengembalian dana:</strong><br />
      Jika kamu sudah melakukan pembayaran, tim kami akan menghubungi kamu untuk proses refund. Harap hubungi kami jika ada pertanyaan.
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 40px">
  <mj-column>
    <mj-text font-size="14px" color="#6B7280">
      Kami mohon maaf atas pembatalan ini. Temukan trip lain yang sesuai dengan rencanamu.
    </mj-text>
    <mj-button href="{{ url('/trips') }}" align="left">
      Jelajahi Trip Lainnya →
    </mj-button>
  </mj-column>
</mj-section>

@endsection
