<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" {{ $attributes }}>
  <defs>
    <linearGradient id="lockGradient" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#4F7CFF;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#818cf8;stop-opacity:1" />
    </linearGradient>
    <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
      <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
      <feOffset dx="0" dy="2" result="offsetblur"/>
      <feComponentTransfer>
        <feFuncA type="linear" slope="0.3"/>
      </feComponentTransfer>
      <feMerge>
        <feMergeNode/>
        <feMergeNode in="SourceGraphic"/>
      </feMerge>
    </filter>
  </defs>

  <!-- Fond arrondi -->
  <rect width="100" height="100" rx="22" fill="url(#lockGradient)"/>

  <!-- Cadenas -->
  <g transform="translate(50, 50)" filter="url(#shadow)">
    <path d="M -12 -8 L -12 -18 A 12 12 0 0 1 12 -18 L 12 -8"
          fill="none"
          stroke="#ffffff"
          stroke-width="5"
          stroke-linecap="round"/>
    <rect x="-16" y="-8" width="32" height="24" rx="4" fill="#ffffff"/>
    <circle cx="0" cy="2" r="3.5" fill="url(#lockGradient)"/>
    <rect x="-1.5" y="2" width="3" height="8" rx="1.5" fill="url(#lockGradient)"/>
  </g>
</svg>
