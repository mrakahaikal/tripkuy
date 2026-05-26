@extends('mail.layouts.base')
@section('preview', 'Booking dikonfirmasi — ' . $booking->booking_code)

@section('body')

<mj-section background-color="#ffffff" padding="40px 32px 24px">
  <mj-column>
    <mj-text font-size="26px" font-weight="700" color="#111827" line-height="1.3">
      Booking dikonfirmasi! 🎊
    </mj-text>
    <mj-text padding-top="8px" color="#6B7280">
      Halo {{ $booking->user->name }}, pembayaranmu telah diverifikasi dan booking kamu resmi dikonfirmasi. Sampai jumpa di trip!
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column background-color="#F0FDF4" border-radius="10px" padding="16px 24px">
    <mj-text font-size="13px" color="#166534" font-weight="600" letter-spacing="0.5px">
      ✅ &nbsp;BOOKING CONFIRMED
    </mj-text>
    <mj-text font-size="20px" font-weight="800" color="#15803D" letter-spacing="1.5px" padding-top="4px" font-family="'Courier New', monospace">
      {{ $booking->booking_code }}
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column border="1px solid #E5E7EB" border-radius="10px" padding="20px 24px">
    <mj-text font-size="14px" font-weight="600" color="#0F766E" padding-bottom="12px">
      Detail Trip Kamu
    </mj-text>
    <mj-table>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px; width: 44%;">Trip</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600;">{{ $booking->trip->title }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Tanggal</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->trip->start_date->format('d M Y') }} – {{ $booking->trip->end_date->format('d M Y') }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Peserta</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->participant_count }} orang</td>
      </tr>
      @if($booking->trip->meeting_point)
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Meeting Point</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->trip->meeting_point }}</td>
      </tr>
      @endif
      <tr style="border-top: 1px solid #F3F4F6;">
        <td style="padding: 10px 0 6px; color: #6B7280; font-size: 14px;">Total Dibayar</td>
        <td style="padding: 10px 0 6px; color: #15803D; font-size: 16px; font-weight: 700;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
    </mj-table>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 40px">
  <mj-column>
    <mj-button href="{{ route('bookings.show', $booking->booking_code) }}" align="left">
      Lihat Detail Booking →
    </mj-button>
  </mj-column>
</mj-section>

@endsection
