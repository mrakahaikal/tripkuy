<mjml>
  <mj-head>
    <mj-attributes>
      <mj-all font-family="'Inter', 'Helvetica Neue', Arial, sans-serif" />
      <mj-text font-size="15px" line-height="1.7" color="#374151" />
      <mj-button background-color="#0F766E" color="#ffffff" font-size="14px" font-weight="600"
        border-radius="8px" inner-padding="12px 28px" />
    </mj-attributes>
    <mj-preview>@yield('preview', config('app.name'))</mj-preview>
  </mj-head>
  <mj-body background-color="#F3F4F6">

    {{-- Header --}}
    <mj-section background-color="#0F766E" padding="28px 20px 24px">
      <mj-column>
        <mj-text align="center" font-size="24px" font-weight="800" color="#ffffff" letter-spacing="-0.5px">
          TripKuy
        </mj-text>
        <mj-text align="center" font-size="13px" color="#99F6E4" padding-top="2px">
          Petualangan Dimulai dari Sini
        </mj-text>
      </mj-column>
    </mj-section>

    {{-- Main content --}}
    @yield('body')

    {{-- Footer --}}
    <mj-section background-color="#F3F4F6" padding="24px 20px 32px">
      <mj-column>
        <mj-divider border-color="#E5E7EB" border-width="1px" padding-bottom="20px" />
        <mj-text align="center" font-size="13px" color="#9CA3AF" line-height="1.6">
          Email ini dikirim secara otomatis, mohon tidak membalas pesan ini.<br />
          Butuh bantuan? Hubungi kami di <a href="mailto:{{ config('mail.from.address') }}" style="color: #0F766E; text-decoration: none;">{{ config('mail.from.address') }}</a>
        </mj-text>
        <mj-text align="center" font-size="12px" color="#D1D5DB" padding-top="8px">
          © {{ date('Y') }} {{ config('app.name') }} · Semua hak dilindungi
        </mj-text>
      </mj-column>
    </mj-section>

  </mj-body>
</mjml>
