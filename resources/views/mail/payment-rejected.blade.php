@extends('mail.layouts.base')
@section('preview', 'Pembayaran tidak dapat diverifikasi — ' . $booking->booking_code)

@section('body')

<mj-section background-color="#ffffff" padding="40px 32px 24px">
  <mj-column>
    <mj-text font-size="26px" font-weight="700" color="#111827" line-height="1.3">
      Pembayaran tidak dapat diverifikasi
    </mj-text>
    <mj-text padding-top="8px" color="#6B7280">
      Halo {{ $booking->user->name }}, kami mohon maaf — bukti transfer untuk booking kamu tidak dapat kami verifikasi. Silakan upload ulang bukti transfer yang valid.
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column background-color="#FEF2F2" border-radius="10px" padding="16px 20px">
    <mj-text font-size="14px" font-weight="600" color="#B91C1C" padding-bottom="4px">
      ❌ &nbsp;Alasan Penolakan
    </mj-text>
    <mj-text font-size="14px" color="#7F1D1D">
      {{ $reason }}
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 24px">
  <mj-column border="1px solid #E5E7EB" border-radius="10px" padding="20px 24px">
    <mj-table>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px; width: 44%;">Kode Booking</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600; font-family: 'Courier New', monospace;">{{ $booking->booking_code }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Trip</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $booking->trip->title }}</td>
      </tr>
      <tr>
        <td style="padding: 6px 0; color: #6B7280; font-size: 14px;">Total</td>
        <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
    </mj-table>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 16px">
  <mj-column background-color="#F0FDFA" border-radius="10px" padding="14px 20px">
    <mj-text font-size="13px" color="#134E4A">
      📌 &nbsp;Perhatikan batas waktu pembayaran booking kamu. Jika sudah melewati batas, silakan hubungi tim kami untuk perpanjangan.
    </mj-text>
  </mj-column>
</mj-section>

<mj-section background-color="#ffffff" padding="0 32px 40px">
  <mj-column>
    <mj-button href="{{ route('bookings.show', $booking->booking_code) }}" align="left">
      Upload Ulang Bukti Transfer →
    </mj-button>
  </mj-column>
</mj-section>

@endsection
