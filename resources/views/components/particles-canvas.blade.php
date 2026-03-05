{{--
  Composant : Canvas de particules animées
  Usage : @include('components.particles-canvas')
  
  Props optionnelles (à passer via @include) :
  - $particleCount : nombre de particules (défaut: auto)
  - $opacity : opacité du canvas (défaut: 0.55 dark, 0.25 light)
--}}

<canvas id="particles-canvas" 
        class="particles-canvas"
        data-particle-count="{{ $particleCount ?? 'auto' }}"
        data-opacity-dark="{{ $opacityDark ?? '0.55' }}"
        data-opacity-light="{{ $opacityLight ?? '0.25' }}"
        aria-hidden="true">
</canvas>
