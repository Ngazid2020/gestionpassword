/**
 * PARTICLES CANVAS ANIMATION
 * Background animé avec particules connectées
 * 
 * Features:
 * - Adaptation automatique au thème (clair/sombre)
 * - Performance optimisée (RequestAnimationFrame)
 * - Responsive (recalcul sur resize)
 * - Configuration via data-attributes
 * 
 * Usage:
 * 1. Inclure particles-canvas.css
 * 2. Ajouter <canvas id="particles-canvas"></canvas>
 * 3. Appeler ParticlesCanvas.init()
 */

const ParticlesCanvas = (function () {
  'use strict';

  // Configuration par défaut
  const CONFIG = {
    particleSpeed: 0.5,        // Vitesse de déplacement
    particleSize: { min: 0.6, max: 2.4 }, // Taille des particules
    connectionDistance: 130,    // Distance max de connexion
    lineWidth: 0.6,            // Épaisseur des lignes
    colorDark: 'rgba(79,124,255,', // Couleur thème sombre
    colorLight: 'rgba(41,82,227,' // Couleur thème clair
  };

  let canvas, ctx, width, height, particles = [];
  let animationId = null;
  let isInitialized = false;

  /**
   * Calcule le nombre optimal de particules selon la taille d'écran
   */
  function calculateParticleCount(customCount) {
    if (customCount && customCount !== 'auto') {
      return parseInt(customCount, 10);
    }

    const w = window.innerWidth;
    
    // Moins de particules sur mobile pour la performance
    if (w < 768) {
      return Math.min(30, Math.floor(w / 20));
    }
    
    return Math.min(80, Math.floor(w / 16));
  }

  /**
   * Redimensionne le canvas à la taille de la fenêtre
   */
  function resizeCanvas() {
    if (!canvas) return;
    
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
  }

  /**
   * Initialise les particules avec positions et vélocités aléatoires
   */
  function createParticles(count) {
    particles = [];
    
    for (let i = 0; i < count; i++) {
      particles.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * CONFIG.particleSpeed,
        vy: (Math.random() - 0.5) * CONFIG.particleSpeed,
        r: Math.random() * (CONFIG.particleSize.max - CONFIG.particleSize.min) + CONFIG.particleSize.min
      });
    }
  }

  /**
   * Retourne la couleur des particules selon le thème actif
   */
  function getParticleColor() {
    const theme = document.documentElement.getAttribute('data-theme');
    return theme === 'light' ? CONFIG.colorLight : CONFIG.colorDark;
  }

  /**
   * Met à jour la position d'une particule avec wrapping aux bords
   */
  function updateParticle(p) {
    p.x += p.vx;
    p.y += p.vy;

    // Wrapping : réapparaît du côté opposé
    if (p.x < 0) p.x = width;
    if (p.x > width) p.x = 0;
    if (p.y < 0) p.y = height;
    if (p.y > height) p.y = 0;
  }

  /**
   * Dessine une particule
   */
  function drawParticle(p, color) {
    ctx.beginPath();
    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
    ctx.fillStyle = color + '0.65)';
    ctx.fill();
  }

  /**
   * Dessine une ligne de connexion entre deux particules
   */
  function drawConnection(p1, p2, distance, color) {
    const opacity = (0.55 - distance / CONFIG.connectionDistance * 0.55).toFixed(3);
    
    ctx.beginPath();
    ctx.moveTo(p1.x, p1.y);
    ctx.lineTo(p2.x, p2.y);
    ctx.strokeStyle = color + opacity + ')';
    ctx.lineWidth = CONFIG.lineWidth;
    ctx.stroke();
  }

  /**
   * Boucle d'animation principale
   */
  function animate() {
    if (!ctx || !canvas) return;

    // Clear du canvas
    ctx.clearRect(0, 0, width, height);

    const color = getParticleColor();

    // Update et draw de chaque particule
    for (let i = 0; i < particles.length; i++) {
      const p = particles[i];
      
      updateParticle(p);
      drawParticle(p, color);

      // Connexions avec les autres particules
      for (let j = i + 1; j < particles.length; j++) {
        const q = particles[j];
        const dx = p.x - q.x;
        const dy = p.y - q.y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < CONFIG.connectionDistance) {
          drawConnection(p, q, distance, color);
        }
      }
    }

    animationId = requestAnimationFrame(animate);
  }

  /**
   * Gère le redimensionnement de la fenêtre
   */
  function handleResize() {
    resizeCanvas();
    
    // Recalcule le nombre de particules si nécessaire
    const targetCount = calculateParticleCount(canvas.dataset.particleCount);
    
    if (particles.length !== targetCount) {
      createParticles(targetCount);
    }
  }

  /**
   * Initialise le canvas et démarre l'animation
   */
  function init(canvasId = 'particles-canvas') {
    // Évite la double initialisation
    if (isInitialized) {
      console.warn('ParticlesCanvas already initialized');
      return;
    }

    canvas = document.getElementById(canvasId);
    
    if (!canvas) {
      console.error('Canvas element not found:', canvasId);
      return;
    }

    ctx = canvas.getContext('2d', { alpha: true });
    
    if (!ctx) {
      console.error('Could not get 2D context');
      return;
    }

    // Setup initial
    resizeCanvas();
    
    const particleCount = calculateParticleCount(canvas.dataset.particleCount);
    createParticles(particleCount);

    // Event listeners
    window.addEventListener('resize', handleResize);

    // Démarrage de l'animation
    animate();
    
    isInitialized = true;
    console.log('✨ ParticlesCanvas initialized with', particles.length, 'particles');
  }

  /**
   * Arrête l'animation et nettoie les ressources
   */
  function destroy() {
    if (animationId) {
      cancelAnimationFrame(animationId);
      animationId = null;
    }

    window.removeEventListener('resize', handleResize);
    
    particles = [];
    canvas = null;
    ctx = null;
    isInitialized = false;
    
    console.log('🧹 ParticlesCanvas destroyed');
  }

  /**
   * Met à jour la configuration
   */
  function updateConfig(newConfig) {
    Object.assign(CONFIG, newConfig);
    
    if (isInitialized) {
      // Force un redraw avec la nouvelle config
      createParticles(particles.length);
    }
  }

  // API publique
  return {
    init,
    destroy,
    updateConfig,
    getConfig: () => ({ ...CONFIG })
  };
})();

// Auto-initialisation au chargement du DOM
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => ParticlesCanvas.init());
} else {
  ParticlesCanvas.init();
}

// Export pour utilisation en module
if (typeof module !== 'undefined' && module.exports) {
  module.exports = ParticlesCanvas;
}
