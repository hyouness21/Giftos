@props(['class' => '', 'height' => 'h-10 sm:h-12'])

<a href="{{ url('/') }}" class="inline-flex shrink-0 items-center {{ $class }}" aria-label="GIFTOS home" tabindex="-1">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245 78"
         class="{{ $height }} w-auto" fill="none" aria-hidden="true">

        {{-- Arch from above I to above O --}}
        <path d="M 78 46 Q 122 16 166 46"
              stroke="#0d9898" stroke-width="2.2" stroke-linecap="round"/>

        {{-- Left ribbon loop of bow --}}
        <path d="M 121 17 C 103 1, 106 14, 121 17"
              stroke="#0d9898" stroke-width="2" stroke-linecap="round"/>

        {{-- Right ribbon loop of bow --}}
        <path d="M 121 17 C 139 1, 136 14, 121 17"
              stroke="#0d9898" stroke-width="2" stroke-linecap="round"/>

        {{-- Center knot --}}
        <circle cx="121" cy="17" r="2.5" fill="#0d9898"/>

        {{-- GIFTOS wordmark --}}
        <text x="122" y="72"
              text-anchor="middle"
              font-family="Cinzel, Georgia, 'Times New Roman', serif"
              font-size="36"
              fill="#0d9898"
              style="letter-spacing:5px;font-weight:700">GIFTOS</text>
    </svg>
</a>
