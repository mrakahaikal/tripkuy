@extends('mail.layouts.base')
@section('preview', 'Booking dibatalkan — ' . $booking->booking_code)

@section('body')

<mj-section background-color="#ffffff" padding="40px 32px 24px">
  <mj-column>
    <mj-text font-size="26px" font-weight="700" color="#111827" line-height="1.3">
      Booking dibatalkan
    </mj-text>
    <mj-text padding-top="8px" color="#6B7280">
      Halo {{ $booking->user->name }}, booking berikut telah dibatalkan. Kami mohon maaf atas ketidaknyamanan ini.
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column border="1px solid #E5E7EB" border-radius="10px" padding="20px 24px">
    <mj-text font-size="14px" font-weight="600" color="#374151" padding-bottom="12px">
      Detail Booking
    </mj-text>
    <mj-table>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px; width: 44%;">Kode Booking</td>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px; font-weight: 600; font-family: 'Courier New', monospace; text-decoration: line-through;">{{ $booking->booking_code }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Trip</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->trip->title }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Tanggal</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->trip->start_date->format('d M Y') }} – {{ $booking->trip->end_date->format('d M Y') }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Peserta</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->participant_count }} orang</td>
      </tr>
    </mj-table>
  </mj-column>
</mj-section>

@if($reason)
<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column background-color="#FEF3C7" border-radius="10px" padding="16px 20px">
    <mj-text font-size="14px" font-weight="600" color="#92400E" padding-bottom="4px">
      Alasan Pembatalan
    </mj-text>
    <mj-text font-size="14px" color="#78350F">
      {{ $reason }}
    </mj-text>
  </mj-column>
</mj-section>
@endif

<mj-section background-color="#ffffff" padding="0 32px 40px">
  <mj-column>
    <mj-text font-size="14px" color="#6B7280">
      Ingin memesan trip lain? Temukan pilihan perjalanan seru lainnya di TripKuy.
    </mj-text>
    <mj-button href="{{ url('/trips') }}" align="left">
      Jelajahi Trip Lainnya →
    </mj-button>
  </mj-column>
</mj-section>

@endsection
