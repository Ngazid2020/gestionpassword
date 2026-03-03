<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lakile — Coffre-fort numérique d'entreprise</title>

{{-- ⚡ CRITIQUE : doit être le PREMIER script, avant tout CSS --}}
<script>
  (function(){
    var saved = localStorage.getItem('lk-theme');
    var theme = saved === 'light' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', theme);
  })();
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif

<style>
/* ══════════════════════════════════════════════════════════
   1. THEME TOKENS — appliqués sur html[data-theme]
══════════════════════════════════════════════════════════ */
[data-theme="dark"] {
  --bg:          #07090f;
  --bg2:         #0d1120;
  --surf:        #111827;
  --surf2:       #1a2438;
  --bdr:         rgba(255,255,255,0.07);
  --bdr2:        rgba(255,255,255,0.14);
  --txt:         #e2e8f8;
  --txt2:        rgba(226,232,248,0.52);
  --txt3:        rgba(226,232,248,0.28);
  --acc:         #4F7CFF;
  --acc2:        #3565f0;
  --acc3:        rgba(79,124,255,0.15);
  --gold:        #FFB443;
  --gold2:       rgba(255,180,67,0.14);
  --green:       #22d3a4;
  --glow-a:      rgba(79,124,255,0.22);
  --glow-b:      rgba(255,180,67,0.1);
  --nav-bg:      rgba(7,9,15,0.85);
  --tag-bg:      rgba(79,124,255,0.12);
  --tag-txt:     #7fa8ff;
  --shadow-card: 0 24px 60px rgba(0,0,0,0.3);
  --shadow-sm:   0 4px 16px rgba(0,0,0,0.2);
  --card-shine:  rgba(255,255,255,0.03);
}
[data-theme="light"] {
  --bg:          #f0f4ff;
  --bg2:         #e5eaf7;
  --surf:        #ffffff;
  --surf2:       #f5f7ff;
  --bdr:         rgba(0,0,0,0.07);
  --bdr2:        rgba(0,0,0,0.14);
  --txt:         #0c1028;
  --txt2:        rgba(12,16,40,0.52);
  --txt3:        rgba(12,16,40,0.3);
  --acc:         #2952e3;
  --acc2:        #1a3fc9;
  --acc3:        rgba(41,82,227,0.1);
  --gold:        #c97d10;
  --gold2:       rgba(201,125,16,0.12);
  --green:       #059669;
  --glow-a:      rgba(41,82,227,0.1);
  --glow-b:      rgba(201,125,16,0.07);
  --nav-bg:      rgba(240,244,255,0.88);
  --tag-bg:      rgba(41,82,227,0.08);
  --tag-txt:     #2952e3;
  --shadow-card: 0 16px 48px rgba(0,0,0,0.1);
  --shadow-sm:   0 4px 16px rgba(0,0,0,0.07);
  --card-shine:  rgba(255,255,255,0.7);
}

/* ══════════════════════════════════════════════════════════
   2. RESET & BASE
══════════════════════════════════════════════════════════ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;font-size:16px;height:100%}
body{
  font-family:'DM Sans',system-ui,sans-serif;
  background:var(--bg);color:var(--txt);
  line-height:1.65;font-weight:400;
  overflow-x:hidden;
  -webkit-font-smoothing:antialiased;
  -moz-osx-font-smoothing:grayscale;
  /* transition uniquement sur bg/color pour éviter les flash */
  transition:background-color .35s ease, color .35s ease;
}
a{text-decoration:none;color:inherit}
button{font-family:inherit;cursor:pointer;border:none;background:none}
img{display:block;max-width:100%}

/* ══════════════════════════════════════════════════════════
   3. PARTICULES CANVAS HERO
══════════════════════════════════════════════════════════ */
#particles-canvas{
  position:fixed;inset:0;z-index:0;pointer-events:none;
  opacity:.55;transition:opacity .4s;
}
[data-theme="light"] #particles-canvas{opacity:.25}

/* ══════════════════════════════════════════════════════════
   4. LAYOUT
══════════════════════════════════════════════════════════ */
.wrap{max-width:1200px;margin:0 auto;padding:0 2rem;position:relative;z-index:2}

/* ══════════════════════════════════════════════════════════
   5. NAV
══════════════════════════════════════════════════════════ */
.nav{
  position:sticky;top:0;z-index:500;
  background:var(--nav-bg);
  border-bottom:1px solid var(--bdr);
  backdrop-filter:blur(24px) saturate(180%);
  -webkit-backdrop-filter:blur(24px) saturate(180%);
  transition:background-color .35s ease, border-color .35s ease;
}
.nav-inner{
  display:flex;align-items:center;
  justify-content:space-between;
  height:68px;gap:1.5rem;
}
.logo{display:flex;align-items:center;gap:11px;flex-shrink:0}
.logo-mark{
  width:38px;height:38px;border-radius:10px;
  background:linear-gradient(135deg,var(--acc),#818cf8);
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 0 0 1px rgba(79,124,255,.35), 0 6px 20px rgba(79,124,255,.3);
  transition:box-shadow .25s,transform .25s;
  flex-shrink:0;
}
.logo-mark:hover{transform:scale(1.06);box-shadow:0 0 0 2px rgba(79,124,255,.5),0 8px 28px rgba(79,124,255,.4)}
.logo-mark svg{width:19px;height:19px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.logo-name{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:1.4rem;font-weight:700;letter-spacing:-.03em;color:var(--txt);
}
.logo-name b{color:var(--acc);font-weight:700}
.nav-links{
  display:flex;align-items:center;gap:.2rem;
  flex:1;justify-content:center;
}
.nav-link{
  font-family:'DM Sans',sans-serif;font-size:.84rem;font-weight:500;
  color:var(--txt2);padding:.45rem .95rem;border-radius:8px;
  letter-spacing:.01em;transition:color .2s,background-color .2s;
}
.nav-link:hover{color:var(--txt);background:var(--bdr)}
.nav-right{display:flex;align-items:center;gap:.65rem;flex-shrink:0}

/* ─── Toggle thème ─── */
.theme-toggle{
  position:relative;width:50px;height:28px;border-radius:999px;
  background:var(--surf2);
  border:1.5px solid var(--bdr2);
  cursor:pointer;
  transition:background-color .3s,border-color .3s;
  flex-shrink:0;
}
.theme-toggle::after{
  content:'';position:absolute;
  top:4px;left:4px;
  width:18px;height:18px;border-radius:50%;
  background:var(--acc);
  box-shadow:0 2px 8px rgba(0,0,0,.25);
  transition:transform .35s cubic-bezier(.34,1.56,.64,1),background-color .3s;
}
[data-theme="light"] .theme-toggle::after{transform:translateX(22px)}
.toggle-icons{
  position:absolute;inset:0;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 6px;pointer-events:none;
}
.toggle-icons svg{width:11px;height:11px}
.ico-moon{color:var(--txt2);transition:opacity .3s}
.ico-sun{color:var(--gold);opacity:.35;transition:opacity .3s}
[data-theme="light"] .ico-moon{opacity:.3}
[data-theme="light"] .ico-sun{opacity:1}

.btn-nav-ghost{
  font-family:'DM Sans',sans-serif;font-size:.84rem;font-weight:500;
  color:var(--txt2);padding:.46rem 1rem;border-radius:8px;
  border:1.5px solid transparent;
  transition:color .2s,border-color .2s,background-color .2s;
}
.btn-nav-ghost:hover{color:var(--txt);border-color:var(--bdr2);background:var(--surf)}
.btn-nav-cta{
  font-family:'DM Sans',sans-serif;font-size:.84rem;font-weight:600;
  color:#fff;padding:.5rem 1.3rem;border-radius:9px;
  background:var(--acc);border:1.5px solid var(--acc);
  box-shadow:0 3px 14px rgba(79,124,255,.35);
  transition:background-color .2s,box-shadow .2s,transform .2s;
  white-space:nowrap;
}
.btn-nav-cta:hover{background:var(--acc2);transform:translateY(-1px);box-shadow:0 6px 22px rgba(79,124,255,.45)}

/* ══════════════════════════════════════════════════════════
   6. HERO
══════════════════════════════════════════════════════════ */
.hero{
  min-height:92vh;display:flex;align-items:center;
  padding:5rem 0 4rem;
  position:relative;overflow:hidden;
}
.hero-glow{
  position:absolute;
  top:-30%;left:-15%;
  width:900px;height:900px;
  border-radius:50%;
  background:radial-gradient(circle,var(--glow-a) 0%,transparent 65%);
  pointer-events:none;animation:gFloat 14s ease-in-out infinite alternate;
}
.hero-glow2{
  position:absolute;
  bottom:-20%;right:-10%;
  width:600px;height:600px;
  border-radius:50%;
  background:radial-gradient(circle,var(--glow-b) 0%,transparent 65%);
  pointer-events:none;animation:gFloat 18s ease-in-out infinite alternate-reverse;
}
@keyframes gFloat{
  0%{transform:translate(0,0) scale(1)}
  100%{transform:translate(40px,50px) scale(1.08)}
}
.hero-grid{
  display:grid;grid-template-columns:1fr 1fr;
  gap:5rem;align-items:center;width:100%;
}
/* ── Left ── */
.hero-left{}
.chip{
  display:inline-flex;align-items:center;gap:8px;
  background:var(--tag-bg);color:var(--tag-txt);
  font-family:'JetBrains Mono',monospace;
  font-size:.67rem;font-weight:500;letter-spacing:.18em;
  text-transform:uppercase;padding:6px 14px;
  border-radius:999px;border:1.5px solid rgba(79,124,255,.2);
  margin-bottom:2rem;
  animation:fadeUp .6s ease both;
}
.chip-dot{
  width:6px;height:6px;border-radius:50%;
  background:var(--green);box-shadow:0 0 8px var(--green);
  animation:pulse-dot 2s infinite;
}
@keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.8)}}
.hero-h1{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:clamp(2.8rem,5.5vw,5rem);
  font-weight:800;line-height:1.03;letter-spacing:-.04em;
  color:var(--txt);margin-bottom:1.75rem;
  animation:fadeUp .6s .1s ease both;
}
.hero-h1 .grad-blue{
  background:linear-gradient(135deg,var(--acc) 0%,#a78bfa 60%,var(--acc) 100%);
  background-size:200% auto;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  animation:gradShift 4s ease infinite;
}
.hero-h1 .grad-gold{
  background:linear-gradient(135deg,var(--gold) 0%,#fb923c 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
@keyframes gradShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
.hero-body{
  font-size:1.1rem;color:var(--txt2);line-height:1.8;
  max-width:470px;margin-bottom:2.5rem;font-weight:300;
  animation:fadeUp .6s .2s ease both;
}
.hero-ctas{
  display:flex;align-items:center;gap:1rem;flex-wrap:wrap;
  animation:fadeUp .6s .3s ease both;
}
.btn-primary{
  display:inline-flex;align-items:center;gap:9px;
  font-family:'DM Sans',sans-serif;font-size:.94rem;font-weight:600;
  color:#fff;padding:.9rem 2.2rem;border-radius:12px;
  background:var(--acc);border:1.5px solid var(--acc);
  box-shadow:0 6px 28px rgba(79,124,255,.4);
  transition:transform .2s,box-shadow .2s,background-color .2s;
  position:relative;overflow:hidden;
}
.btn-primary::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,.12) 0%,transparent 60%);
  pointer-events:none;
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 10px 36px rgba(79,124,255,.5);background:var(--acc2)}
.btn-primary svg{width:17px;height:17px;transition:transform .2s;flex-shrink:0}
.btn-primary:hover svg{transform:translateX(4px)}
.btn-secondary{
  display:inline-flex;align-items:center;gap:9px;
  font-family:'DM Sans',sans-serif;font-size:.94rem;font-weight:500;
  color:var(--txt2);padding:.9rem 1.7rem;border-radius:12px;
  border:1.5px solid var(--bdr2);background:transparent;
  transition:color .2s,background-color .2s,transform .2s,border-color .2s;
}
.btn-secondary:hover{color:var(--txt);background:var(--surf);transform:translateY(-1px);border-color:var(--bdr2)}
.btn-secondary svg{width:17px;height:17px;flex-shrink:0}
.hero-social{
  margin-top:2.5rem;display:flex;align-items:center;gap:1.2rem;
  animation:fadeUp .6s .4s ease both;
}
.avatar-stack{display:flex}
.av-item{
  width:32px;height:32px;border-radius:50%;
  border:2.5px solid var(--bg);
  margin-left:-9px;display:flex;align-items:center;justify-content:center;
  font-family:'DM Sans',sans-serif;font-size:.55rem;font-weight:700;color:#fff;
  flex-shrink:0;
}
.av-item:first-child{margin-left:0}
.hero-social-text{font-size:.82rem;color:var(--txt2);line-height:1.5}
.hero-social-text strong{display:block;color:var(--txt);font-weight:600;margin-bottom:1px}

/* ── Right: 3D Vault ── */
.hero-right{
  perspective:1200px;
  animation:fadeUp .7s .15s ease both;
}
.vault-scene{
  position:relative;padding:2rem 2rem 2.5rem;
  transform-style:preserve-3d;
  transition:transform .12s ease-out;
}
/* Carte principale */
.vault-card{
  background:var(--surf);
  border:1px solid var(--bdr2);
  border-radius:22px;padding:1.8rem;
  position:relative;overflow:hidden;
  box-shadow:var(--shadow-card);
  transform-style:preserve-3d;
  transition:box-shadow .3s;
}
.vault-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,var(--acc),#a78bfa,transparent);
}
/* Shine overlay */
.vault-card::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,var(--card-shine) 0%,transparent 50%);
  pointer-events:none;border-radius:22px;
}
.vc-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem}
.vc-label{
  font-family:'JetBrains Mono',monospace;
  font-size:.67rem;font-weight:500;color:var(--txt2);
  letter-spacing:.14em;text-transform:uppercase;
}
.vc-status{
  display:flex;align-items:center;gap:6px;
  font-family:'JetBrains Mono',monospace;font-size:.65rem;
  color:var(--green);letter-spacing:.06em;
}
.status-dot{
  width:7px;height:7px;border-radius:50%;
  background:var(--green);box-shadow:0 0 10px var(--green);
  animation:pulse-dot 3s infinite;
}
/* Lignes vault */
.vc-rows{display:flex;flex-direction:column;gap:.6rem}
.vc-row{
  display:flex;align-items:center;gap:12px;
  padding:.75rem 1rem;border-radius:11px;
  background:var(--bg2);border:1px solid var(--bdr);
  cursor:default;
  transition:border-color .2s,transform .2s,box-shadow .2s;
}
.vc-row:hover{border-color:var(--acc3);transform:translateX(5px) translateZ(8px);box-shadow:0 4px 20px rgba(79,124,255,.12)}
.vc-ico{
  width:35px;height:35px;border-radius:9px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.05rem;flex-shrink:0;
}
.vc-info{flex:1;min-width:0}
.vc-name{font-size:.84rem;font-weight:600;color:var(--txt);letter-spacing:-.01em}
.vc-mail{font-family:'JetBrains Mono',monospace;font-size:.65rem;color:var(--txt3);margin-top:1px}
.vc-shield{
  width:28px;height:28px;border-radius:7px;
  background:var(--gold2);
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
}
.vc-shield svg{width:13px;height:13px;stroke:var(--gold);fill:none;stroke-width:2}
.vc-footer{
  margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid var(--bdr);
  display:flex;align-items:center;justify-content:space-between;
}
.vc-enc{display:flex;align-items:center;gap:6px;font-family:'JetBrains Mono',monospace;font-size:.65rem;color:var(--txt3)}
.vc-enc svg{width:12px;height:12px;stroke:var(--acc);fill:none;stroke-width:2}
.vc-count{font-family:'JetBrains Mono',monospace;font-size:.7rem;color:var(--txt2)}
.vc-count span{color:var(--acc)}
/* Badges flottants */
.float-badge{
  position:absolute;background:var(--surf);
  border:1.5px solid var(--bdr2);border-radius:14px;
  padding:.65rem 1rem;display:flex;align-items:center;gap:9px;
  box-shadow:0 12px 40px rgba(0,0,0,.18);
  font-size:.8rem;white-space:nowrap;
  transform:translateZ(30px);
}
[data-theme="light"] .float-badge{box-shadow:0 6px 24px rgba(0,0,0,.1)}
.fb1{top:-18px;right:-8px;animation:fbFloat 4s ease-in-out infinite alternate}
.fb2{bottom:-14px;left:-14px;animation:fbFloat 4s 2s ease-in-out infinite alternate-reverse}
@keyframes fbFloat{from{transform:translateZ(30px) translateY(0)}to{transform:translateZ(30px) translateY(-10px)}}
.fb-icon{font-size:1.1rem}
.fb-text{}
.fb-text strong{display:block;font-family:'DM Sans',sans-serif;font-size:.79rem;font-weight:600;color:var(--txt)}
.fb-text span{font-family:'JetBrains Mono',monospace;font-size:.63rem;color:var(--txt3)}

/* ══════════════════════════════════════════════════════════
   7. STRIP LOGOS
══════════════════════════════════════════════════════════ */
.strip{
  border-top:1px solid var(--bdr);
  border-bottom:1px solid var(--bdr);
  padding:1.6rem 0;
  background:var(--bg2);
  transition:background-color .35s;
}
.strip-inner{display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap}
.strip-label{
  font-family:'JetBrains Mono',monospace;
  font-size:.63rem;color:var(--txt3);letter-spacing:.18em;text-transform:uppercase;white-space:nowrap;
}
.strip-logos{display:flex;align-items:center;gap:2.5rem;flex-wrap:wrap}
.strip-logo{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:.85rem;font-weight:700;color:var(--txt3);
  letter-spacing:.04em;transition:color .2s;
}
.strip-logo:hover{color:var(--txt2)}

/* ══════════════════════════════════════════════════════════
   8. SECTION COMMONS
══════════════════════════════════════════════════════════ */
.s-label{
  font-family:'JetBrains Mono',monospace;
  font-size:.64rem;font-weight:500;letter-spacing:.22em;
  text-transform:uppercase;color:var(--acc);
  display:flex;align-items:center;gap:10px;margin-bottom:1.25rem;
}
.s-label::before{content:'';display:inline-block;width:26px;height:1.5px;background:var(--acc);border-radius:2px}
.s-label.center{justify-content:center}
.s-label.center::before{display:none}
.s-h2{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:clamp(2rem,3.8vw,2.9rem);
  font-weight:700;line-height:1.1;letter-spacing:-.03em;color:var(--txt);
}
.s-p{font-size:.99rem;color:var(--txt2);line-height:1.8;font-weight:300}
.acc{color:var(--acc)}

/* ══════════════════════════════════════════════════════════
   9. PROBLÈME
══════════════════════════════════════════════════════════ */
.problem{padding:9rem 0}
.prob-grid{display:grid;grid-template-columns:1fr 1fr;gap:6rem;align-items:center}
.prob-p{color:var(--txt2);line-height:1.8;font-size:1rem;font-weight:300;margin-top:1.25rem}
.prob-p strong{color:var(--txt);font-weight:600}
.risk-list{display:flex;flex-direction:column;gap:1rem}
.risk-item{
  display:flex;gap:1.1rem;padding:1.25rem 1.5rem;
  border:1px solid var(--bdr);border-radius:14px;
  background:var(--surf);cursor:default;
  transition:border-color .25s,transform .25s,box-shadow .25s;
  position:relative;overflow:hidden;
}
.risk-item::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:3px;
  background:var(--acc);border-radius:3px 0 0 3px;
  transform:scaleY(0);transform-origin:bottom;transition:transform .3s;
}
.risk-item:hover::before{transform:scaleY(1)}
.risk-item:hover{border-color:rgba(79,124,255,.25);transform:translateX(5px);box-shadow:var(--shadow-sm)}
.risk-stat{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:1.5rem;font-weight:800;color:var(--acc);
  line-height:1;flex-shrink:0;min-width:48px;
}
.risk-title{font-size:.92rem;font-weight:600;color:var(--txt);margin-bottom:.25rem;letter-spacing:-.01em}
.risk-desc{font-size:.81rem;color:var(--txt2);line-height:1.65;font-weight:300}

/* ══════════════════════════════════════════════════════════
   10. FEATURES BENTO GRID
══════════════════════════════════════════════════════════ */
.features{padding:8rem 0}
.feat-head{text-align:center;max-width:580px;margin:0 auto 5rem}
.feat-head .s-label{justify-content:center}
.feat-head .s-label::before{display:none}
.bento{display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:auto;gap:1.2rem}
/* card base */
.bcard{
  background:var(--surf);border:1px solid var(--bdr);
  border-radius:18px;padding:2rem;
  position:relative;overflow:hidden;
  cursor:default;
  /* 3D tilt initialisation */
  transform-style:preserve-3d;
  transform:perspective(900px) rotateX(0deg) rotateY(0deg);
  transition:border-color .3s,box-shadow .15s;
  will-change:transform;
}
.bcard::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,var(--card-shine) 0%,transparent 50%);
  border-radius:18px;pointer-events:none;
  opacity:0;transition:opacity .3s;
}
.bcard:hover::before{opacity:1}
.bcard::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,var(--glow-a) 0%,transparent 60%);
  opacity:0;transition:opacity .4s;pointer-events:none;
}
.bcard:hover::after{opacity:.5}
.bcard:hover{border-color:rgba(79,124,255,.28);box-shadow:0 20px 60px rgba(0,0,0,.15),0 0 0 1px rgba(79,124,255,.1)}
[data-theme="light"] .bcard:hover{box-shadow:0 12px 40px rgba(0,0,0,.08),0 0 0 1px rgba(41,82,227,.1)}
/* wide card */
.bcard.wide{grid-column:span 2}
/* card icon */
.bcard-ico{
  width:48px;height:48px;border-radius:13px;
  background:var(--tag-bg);border:1px solid rgba(79,124,255,.2);
  display:flex;align-items:center;justify-content:center;
  margin-bottom:1.4rem;transition:box-shadow .3s;
  transform:translateZ(12px);
}
.bcard:hover .bcard-ico{box-shadow:0 0 24px rgba(79,124,255,.3)}
.bcard-ico svg{width:23px;height:23px;stroke:var(--acc);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round}
.bcard-tag{
  display:inline-block;
  font-family:'JetBrains Mono',monospace;font-size:.61rem;font-weight:500;
  letter-spacing:.14em;text-transform:uppercase;
  color:var(--tag-txt);background:var(--tag-bg);
  padding:3px 9px;border-radius:5px;margin-bottom:.75rem;
}
.bcard-h3{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:1.08rem;font-weight:700;color:var(--txt);
  margin-bottom:.6rem;letter-spacing:-.02em;line-height:1.2;
  transform:translateZ(8px);
}
.bcard-p{font-size:.84rem;color:var(--txt2);line-height:1.75;font-weight:300}
.bcard-metric{
  margin-top:1.5rem;padding-top:1.4rem;border-top:1px solid var(--bdr);
  display:flex;align-items:baseline;gap:7px;
}
.metric-val{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:2.2rem;font-weight:800;color:var(--acc);
  line-height:1;letter-spacing:-.04em;
  transform:translateZ(6px);
}
.metric-lbl{font-size:.78rem;color:var(--txt3);font-weight:400}
/* mini bar chart */
.mini-chart{margin-top:1.5rem;height:54px;display:flex;align-items:flex-end;gap:5px}
.bar{flex:1;border-radius:4px 4px 0 0;background:var(--acc);opacity:.12;transition:opacity .3s,height .5s ease}
.bar.hi{opacity:.7}
.bcard:hover .bar{opacity:.2}
.bcard:hover .bar.hi{opacity:1}

/* ══════════════════════════════════════════════════════════
   11. STATS BAND
══════════════════════════════════════════════════════════ */
.stats-band{padding:6rem 0}
.stats-box{
  background:var(--surf);border:1px solid var(--bdr);
  border-radius:22px;padding:4rem 3rem;
  position:relative;overflow:hidden;
  display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;
}
.stats-box::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1.5px;
  background:linear-gradient(90deg,transparent,var(--acc) 40%,var(--gold) 60%,transparent);
}
.stats-box::after{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 60% 70% at 50% 0%,var(--glow-a),transparent);
  pointer-events:none;
}
.st-col{text-align:center;position:relative;z-index:1}
.st-col:not(:last-child)::after{
  content:'';position:absolute;right:0;top:15%;bottom:15%;
  width:1px;background:var(--bdr);
}
.st-val{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:3rem;font-weight:800;line-height:1;
  color:var(--txt);margin-bottom:.55rem;letter-spacing:-.05em;
  display:flex;align-items:baseline;justify-content:center;gap:2px;
}
.st-val .acc{color:var(--acc)}
.st-strong{display:block;font-size:.88rem;font-weight:600;color:var(--txt);margin-bottom:3px;letter-spacing:-.01em}
.st-sub{font-size:.79rem;color:var(--txt2);line-height:1.5;font-weight:300}

/* ══════════════════════════════════════════════════════════
   12. COMMENT ÇA MARCHE
══════════════════════════════════════════════════════════ */
.how{padding:8rem 0}
.how-head{text-align:center;max-width:560px;margin:0 auto 5rem}
.how-head .s-label{justify-content:center}
.how-head .s-label::before{display:none}
.how-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;position:relative}
.how-grid::before{
  content:'';position:absolute;
  top:38px;left:calc(100%/6);right:calc(100%/6);
  border-top:1.5px dashed var(--bdr2);pointer-events:none;
}
.how-step{
  background:var(--surf);border:1px solid var(--bdr);
  border-radius:18px;padding:2.2rem 1.75rem;
  text-align:center;
  transition:border-color .3s,box-shadow .3s,transform .3s;
}
.how-step:hover{border-color:rgba(79,124,255,.3);box-shadow:0 0 0 5px rgba(79,124,255,.07),var(--shadow-sm);transform:translateY(-4px)}
.step-num{
  width:68px;height:68px;border-radius:50%;
  background:var(--bg2);
  border:2px solid var(--bdr2);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 1.5rem;
  transition:border-color .3s,box-shadow .3s;
}
.how-step:hover .step-num{border-color:var(--acc);box-shadow:0 0 0 7px rgba(79,124,255,.1)}
.step-n{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:1.5rem;font-weight:800;color:var(--acc);letter-spacing:-.04em;
}
.step-title{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:1.05rem;font-weight:700;color:var(--txt);
  margin-bottom:.6rem;letter-spacing:-.02em;
}
.step-desc{font-size:.84rem;color:var(--txt2);line-height:1.75;font-weight:300}

/* ══════════════════════════════════════════════════════════
   13. TÉMOIGNAGES
══════════════════════════════════════════════════════════ */
.testi{padding:8rem 0}
.testi-head{text-align:center;margin-bottom:4rem}
.testi-head .s-label{justify-content:center}
.testi-head .s-label::before{display:none}
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
.tcard{
  background:var(--surf);border:1px solid var(--bdr);
  border-radius:18px;padding:2.1rem;
  display:flex;flex-direction:column;
  transition:border-color .3s,transform .3s,box-shadow .3s;
}
.tcard:hover{border-color:var(--bdr2);transform:translateY(-5px);box-shadow:var(--shadow-card)}
.tcard-stars{display:flex;gap:3px;margin-bottom:1.1rem}
.star{color:var(--gold);font-size:.9rem}
.tcard-quote{
  font-size:.9rem;line-height:1.78;color:var(--txt2);
  font-weight:300;flex:1;margin-bottom:1.6rem;
  font-style:italic;
}
.tcard-quote strong{color:var(--acc);font-style:normal;font-weight:600;font-size:.88rem}
.tcard-auth{display:flex;align-items:center;gap:11px}
.tcard-av{
  width:38px;height:38px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-family:'DM Sans',sans-serif;font-size:.72rem;font-weight:700;color:#fff;flex-shrink:0;
}
.tav-a{background:linear-gradient(135deg,#4F7CFF,#7c3aed)}
.tav-b{background:linear-gradient(135deg,#06b6d4,#4F7CFF)}
.tav-c{background:linear-gradient(135deg,#f97316,#FFB443)}
.tcard-name{font-size:.87rem;font-weight:600;color:var(--txt);letter-spacing:-.01em}
.tcard-role{font-family:'JetBrains Mono',monospace;font-size:.63rem;color:var(--txt3);margin-top:2px}

/* ══════════════════════════════════════════════════════════
   14. PRICING
══════════════════════════════════════════════════════════ */
.pricing{padding:8rem 0}
.pricing-head{text-align:center;margin-bottom:4rem}
.pricing-head .s-label{justify-content:center}
.pricing-head .s-label::before{display:none}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
.pcard{
  background:var(--surf);border:1px solid var(--bdr);
  border-radius:18px;padding:2.5rem 2.1rem;
  position:relative;
  transition:border-color .3s,transform .3s,box-shadow .3s;
}
.pcard:hover{border-color:var(--bdr2);transform:translateY(-5px);box-shadow:var(--shadow-card)}
.pcard.pop{
  border-color:var(--acc);
  box-shadow:0 0 0 1.5px var(--acc),0 20px 50px rgba(79,124,255,.18);
}
.pop-tag{
  position:absolute;top:-13px;left:50%;transform:translateX(-50%);
  background:var(--acc);color:#fff;
  font-family:'JetBrains Mono',monospace;font-size:.61rem;font-weight:500;
  letter-spacing:.14em;text-transform:uppercase;
  padding:5px 16px;border-radius:999px;white-space:nowrap;
}
.plan-tier{
  font-family:'JetBrains Mono',monospace;font-size:.67rem;font-weight:500;
  letter-spacing:.18em;text-transform:uppercase;color:var(--txt3);margin-bottom:1.1rem;
}
.plan-price-wrap{display:flex;align-items:baseline;gap:4px;margin-bottom:.4rem}
.plan-price{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:2.8rem;font-weight:800;color:var(--txt);
  line-height:1;letter-spacing:-.05em;
}
.plan-per{font-size:.83rem;color:var(--txt3);font-weight:400}
.plan-desc{font-size:.83rem;color:var(--txt2);margin-bottom:1.75rem;line-height:1.6;font-weight:300}
.plan-sep{height:1px;background:var(--bdr);margin-bottom:1.75rem}
.plan-list{list-style:none;display:flex;flex-direction:column;gap:.72rem}
.plan-item{display:flex;align-items:center;gap:8px;font-size:.84rem;color:var(--txt2);font-weight:400}
.plan-item svg{width:15px;height:15px;stroke:var(--green);fill:none;stroke-width:2.5;flex-shrink:0}
.plan-btn{
  display:block;width:100%;text-align:center;
  margin-top:2rem;padding:.85rem;border-radius:11px;
  font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:600;
  transition:all .2s;letter-spacing:.005em;
}
.pb-outline{border:1.5px solid var(--bdr2);color:var(--txt);background:transparent}
.pb-outline:hover{background:var(--surf2);border-color:var(--bdr2)}
.pb-filled{background:var(--acc);color:#fff;border:1.5px solid var(--acc);box-shadow:0 5px 22px rgba(79,124,255,.32)}
.pb-filled:hover{background:var(--acc2);box-shadow:0 8px 30px rgba(79,124,255,.42);transform:translateY(-1px)}

/* ══════════════════════════════════════════════════════════
   15. CTA FINAL
══════════════════════════════════════════════════════════ */
.cta-section{padding:8rem 0}
.cta-box{
  background:var(--surf);border:1px solid var(--bdr);
  border-radius:28px;padding:6rem 4rem;
  text-align:center;position:relative;overflow:hidden;
}
.cta-box::before{
  content:'';position:absolute;top:0;left:15%;right:15%;height:1.5px;
  background:linear-gradient(90deg,transparent,var(--acc),#a78bfa,transparent);
}
.cta-box::after{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 70% 60% at 50% 0%,var(--glow-a),transparent);
  pointer-events:none;
}
.cta-chip{
  display:inline-flex;align-items:center;gap:8px;
  background:var(--tag-bg);color:var(--tag-txt);
  font-family:'JetBrains Mono',monospace;font-size:.65rem;font-weight:500;
  letter-spacing:.18em;text-transform:uppercase;
  padding:6px 16px;border-radius:999px;border:1.5px solid rgba(79,124,255,.2);
  margin-bottom:2rem;position:relative;z-index:1;
}
.cta-h2{
  font-family:'Bricolage Grotesque',sans-serif;
  font-size:clamp(2.4rem,5vw,4rem);font-weight:800;
  line-height:1.04;letter-spacing:-.04em;color:var(--txt);
  margin-bottom:1.25rem;position:relative;z-index:1;
}
.cta-p{
  color:var(--txt2);max-width:490px;margin:0 auto 2.75rem;
  font-size:1.05rem;line-height:1.8;font-weight:300;
  position:relative;z-index:1;
}
.cta-acts{
  display:flex;align-items:center;justify-content:center;gap:1rem;
  flex-wrap:wrap;position:relative;z-index:1;
}
.cta-trust{
  margin-top:1.75rem;font-family:'JetBrains Mono',monospace;
  font-size:.65rem;color:var(--txt3);letter-spacing:.06em;
  position:relative;z-index:1;display:flex;align-items:center;
  justify-content:center;gap:.75rem;flex-wrap:wrap;
}
.cta-trust-item{display:flex;align-items:center;gap:5px}
.cta-trust-item svg{width:11px;height:11px;stroke:var(--green);fill:none;stroke-width:2.5}

/* ══════════════════════════════════════════════════════════
   16. FOOTER
══════════════════════════════════════════════════════════ */
.footer{border-top:1px solid var(--bdr);padding:2.5rem 0 2rem;transition:border-color .35s}
.footer-inner{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem}
.footer-copy{font-size:.78rem;color:var(--txt3);font-weight:400}
.footer-copy span{color:var(--acc)}
.footer-links{display:flex;gap:1.5rem}
.footer-links a{font-size:.79rem;color:var(--txt3);transition:color .2s;font-weight:500}
.footer-links a:hover{color:var(--txt2)}

/* ══════════════════════════════════════════════════════════
   17. REVEAL ANIMATION
══════════════════════════════════════════════════════════ */
.reveal{opacity:0;transform:translateY(28px);transition:opacity .65s ease,transform .65s ease}
.reveal.in{opacity:1;transform:translateY(0)}
@keyframes fadeUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}

/* ══════════════════════════════════════════════════════════
   18. RESPONSIVE
══════════════════════════════════════════════════════════ */
@media(max-width:1060px){
  .hero-grid{grid-template-columns:1fr;padding:5rem 0 3rem}
  .hero-right{display:none}
  .prob-grid{grid-template-columns:1fr;gap:3rem}
  .bento{grid-template-columns:repeat(2,1fr)}
  .bcard.wide{grid-column:span 2}
  .stats-box{grid-template-columns:repeat(2,1fr)}
  .st-col:nth-child(2)::after{display:none}
  .testi-grid{grid-template-columns:repeat(2,1fr)}
  .pricing-grid{grid-template-columns:repeat(2,1fr)}
  .nav-links{display:none}
}
@media(max-width:720px){
  .hero{padding:4rem 0 3rem;min-height:auto}
  .hero-h1{font-size:2.5rem}
  .bento{grid-template-columns:1fr}
  .bcard.wide{grid-column:span 1}
  .stats-box{grid-template-columns:1fr 1fr;padding:2.5rem 1.5rem}
  .how-grid{grid-template-columns:1fr}
  .how-grid::before{display:none}
  .testi-grid{grid-template-columns:1fr}
  .pricing-grid{grid-template-columns:1fr}
  .cta-box{padding:3.5rem 1.5rem}
  .footer-inner{flex-direction:column;text-align:center}
  .strip-logos{gap:1.5rem}
}
</style>
</head>
<body>

<canvas id="particles-canvas"></canvas>

<!-- ════════════════════════════════
     NAV
════════════════════════════════ -->
<header class="nav">
  <div class="wrap">
    <div class="nav-inner">

      <a href="/" class="logo">
        <div class="logo-mark">
          <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2.5"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <span class="logo-name">La<b>kile</b></span>
      </a>

      <nav class="nav-links" aria-label="Navigation principale">
        <a class="nav-link" href="#features">Fonctionnalités</a>
        <a class="nav-link" href="#how">Comment ça marche</a>
        <a class="nav-link" href="#pricing">Tarifs</a>
        <a class="nav-link" href="#testi">Témoignages</a>
      </nav>

      <div class="nav-right">
        <button class="theme-toggle" id="themeToggle" aria-label="Basculer le thème clair/sombre">
          <span class="toggle-icons" aria-hidden="true">
            <svg class="ico-moon" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <svg class="ico-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
          </span>
        </button>
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="btn-nav-cta">Mon Lakile</a>
          @else
            <a href="{{ route('login') }}" class="btn-nav-ghost">Connexion</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="btn-nav-cta">Essai gratuit →</a>
            @endif
          @endauth
        @endif
      </div>

    </div>
  </div>
</header>

<!-- ════════════════════════════════
     HERO
════════════════════════════════ -->
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-glow2"></div>
  <div class="wrap">
    <div class="hero-grid">

      <!-- Texte gauche -->
      <div class="hero-left">
        <div class="chip">
          <span class="chip-dot"></span>
          Chiffrement AES-256 · Zero-knowledge
        </div>
        <h1 class="hero-h1">
          Vos accès critiques,<br>
          <span class="grad-blue">blindés</span> &amp;<br>
          <span class="grad-gold">toujours sûrs.</span>
        </h1>
        <p class="hero-body">
          Lakile centralise tous les mots de passe de votre entreprise dans un coffre-fort chiffré, partageable par équipe, auditable et conforme. Zéro tableur. Zéro faille.
        </p>
        <div class="hero-ctas">
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-primary">
              Démarrer gratuitement
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
          @endif
          <a href="#features" class="btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/></svg>
            Voir la démo
          </a>
        </div>
        <div class="hero-social">
          <div class="avatar-stack">
            <div class="av-item" style="background:linear-gradient(135deg,#4F7CFF,#7c3aed)">MB</div>
            <div class="av-item" style="background:linear-gradient(135deg,#06b6d4,#4F7CFF)">KD</div>
            <div class="av-item" style="background:linear-gradient(135deg,#f97316,#FFB443)">AT</div>
            <div class="av-item" style="background:linear-gradient(135deg,#22d3a4,#06b6d4)">RL</div>
            <div class="av-item" style="background:linear-gradient(135deg,#a78bfa,#4F7CFF)">+</div>
          </div>
          <div class="hero-social-text">
            <strong>+2 400 équipes sécurisées</strong>
            Déployé dans 18 pays · Noté 4.9⁄5
          </div>
        </div>
      </div>

      <!-- Vault 3D droit -->
      <div class="hero-right">
        <div class="vault-scene" id="vaultScene">
          <div class="float-badge fb1">
            <span class="fb-icon">🔒</span>
            <div class="fb-text">
              <strong>Chiffrement actif</strong>
              <span>AES-256 · Zero-knowledge</span>
            </div>
          </div>

          <div class="vault-card">
            <div class="vc-top">
              <span class="vc-label">Coffre-fort équipe</span>
              <span class="vc-status"><span class="status-dot"></span>Sécurisé</span>
            </div>
            <div class="vc-rows">
              <div class="vc-row">
                <div class="vc-ico" style="background:rgba(79,124,255,.12)">🌐</div>
                <div class="vc-info">
                  <div class="vc-name">Production · AWS</div>
                  <div class="vc-mail">ops@entreprise.com</div>
                </div>
                <div class="vc-shield"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
              </div>
              <div class="vc-row">
                <div class="vc-ico" style="background:rgba(34,211,164,.1)">💼</div>
                <div class="vc-info">
                  <div class="vc-name">Salesforce CRM</div>
                  <div class="vc-mail">sales@entreprise.com</div>
                </div>
                <div class="vc-shield"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
              </div>
              <div class="vc-row">
                <div class="vc-ico" style="background:rgba(255,180,67,.1)">🏦</div>
                <div class="vc-info">
                  <div class="vc-name">Banque · SGBM</div>
                  <div class="vc-mail">finance@entreprise.com</div>
                </div>
                <div class="vc-shield"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
              </div>
              <div class="vc-row">
                <div class="vc-ico" style="background:rgba(167,139,250,.1)">☁️</div>
                <div class="vc-info">
                  <div class="vc-name">Google Workspace</div>
                  <div class="vc-mail">admin@entreprise.com</div>
                </div>
                <div class="vc-shield"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
              </div>
            </div>
            <div class="vc-footer">
              <span class="vc-enc">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Chiffré bout-en-bout
              </span>
              <span class="vc-count"><span>247</span> identifiants</span>
            </div>
          </div>

          <div class="float-badge fb2">
            <span class="fb-icon">✅</span>
            <div class="fb-text">
              <strong>Accès révoqué</strong>
              <span>Thomas D. · il y a 2 min</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ════════════════════════════════
     STRIP LOGOS
════════════════════════════════ -->
<div class="strip">
  <div class="wrap">
    <div class="strip-inner">
      <span class="strip-label">Ils nous font confiance</span>
      <div class="strip-logos">
        <span class="strip-logo">NEXAGROUP</span>
        <span class="strip-logo">TECHBUILD</span>
        <span class="strip-logo">OMNIBANK</span>
        <span class="strip-logo">DIGITORA</span>
        <span class="strip-logo">VELOCLOUD</span>
        <span class="strip-logo">AXIOLAB</span>
      </div>
    </div>
  </div>
</div>

<!-- ════════════════════════════════
     PROBLÈME
════════════════════════════════ -->
<section class="problem" id="problem">
  <div class="wrap">
    <div class="prob-grid">
      <div class="reveal">
        <div class="s-label">Le problème</div>
        <h2 class="s-h2">Chaque jour sans Lakile,<br>votre sécurité est exposée.</h2>
        <p class="prob-p">Les entreprises perdent en moyenne <strong>4,35 M$</strong> par violation de données. La cause #1&nbsp;? Des mots de passe partagés sur Slack, dans des tableurs, ou réutilisés. Lakile élimine ces risques à la racine.</p>
      </div>
      <div class="risk-list reveal">
        <div class="risk-item">
          <div class="risk-stat">81%</div>
          <div>
            <div class="risk-title">Des violations liées aux mots de passe</div>
            <div class="risk-desc">La majorité des cyberattaques exploitent des credentials faibles ou compromis. Votre entreprise n'est pas immunisée.</div>
          </div>
        </div>
        <div class="risk-item">
          <div class="risk-stat">↑3×</div>
          <div>
            <div class="risk-title">Plus de risque lors d'un départ</div>
            <div class="risk-desc">Chaque collaborateur qui part emporte potentiellement l'accès à des dizaines de comptes critiques.</div>
          </div>
        </div>
        <div class="risk-item">
          <div class="risk-stat">0s</div>
          <div>
            <div class="risk-title">Délai de révocation avec Lakile</div>
            <div class="risk-desc">Révoquez tous les accès d'un collaborateur en un clic, instantanément, depuis n'importe où.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     FEATURES
════════════════════════════════ -->
<section class="features" id="features">
  <div class="wrap">
    <div class="feat-head reveal">
      <div class="s-label center">Fonctionnalités</div>
      <h2 class="s-h2" style="margin-bottom:.9rem">La sécurité,<br>sans la complexité.</h2>
      <p class="s-p">Conçu pour les DSI exigeants et les équipes qui avancent vite.</p>
    </div>
    <div class="bento reveal" id="bentoGrid">
      <!-- Grande carte -->
      <div class="bcard wide" data-tilt>
        <span class="bcard-tag">Core</span>
        <div class="bcard-ico"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
        <h3 class="bcard-h3">Coffre-fort zero-knowledge</h3>
        <p class="bcard-p">Vos données sont chiffrées côté client avant d'atteindre nos serveurs. Même notre équipe ne peut pas lire vos mots de passe — c'est mathématiquement impossible.</p>
        <div class="mini-chart">
          <div class="bar" style="height:28%"></div><div class="bar" style="height:48%"></div>
          <div class="bar" style="height:38%"></div><div class="bar" style="height:62%"></div>
          <div class="bar hi" style="height:80%"></div><div class="bar" style="height:68%"></div>
          <div class="bar" style="height:85%"></div><div class="bar hi" style="height:100%"></div>
          <div class="bar" style="height:88%"></div><div class="bar" style="height:94%"></div>
          <div class="bar hi" style="height:100%"></div><div class="bar" style="height:90%"></div>
        </div>
      </div>
      <!-- Carte équipes -->
      <div class="bcard" data-tilt>
        <span class="bcard-tag">Contrôle</span>
        <div class="bcard-ico"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <h3 class="bcard-h3">Gestion équipes & rôles</h3>
        <p class="bcard-p">Permissions granulaires par rôle, projet ou département. Chacun accède uniquement à ce dont il a besoin.</p>
        <div class="bcard-metric"><span class="metric-val">∞</span><span class="metric-lbl">utilisateurs par org.</span></div>
      </div>
      <!-- Carte audit -->
      <div class="bcard" data-tilt>
        <span class="bcard-tag">Conformité</span>
        <div class="bcard-ico"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
        <h3 class="bcard-h3">Journal d'audit complet</h3>
        <p class="bcard-p">Chaque action est tracée. Prêt pour vos audits ISO 27001 et RGPD.</p>
        <div class="bcard-metric"><span class="metric-val">100%</span><span class="metric-lbl">traçabilité des accès</span></div>
      </div>
      <!-- Carte SSO -->
      <div class="bcard" data-tilt>
        <span class="bcard-tag">Intégration</span>
        <div class="bcard-ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
        <h3 class="bcard-h3">SSO · SAML · Active Directory</h3>
        <p class="bcard-p">Compatible Azure AD, Okta, Google Workspace. Déploiement en quelques minutes.</p>
      </div>
      <!-- Carte partage -->
      <div class="bcard" data-tilt>
        <span class="bcard-tag">Collaboration</span>
        <div class="bcard-ico"><svg viewBox="0 0 24 24"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg></div>
        <h3 class="bcard-h3">Partage sécurisé par lien</h3>
        <p class="bcard-p">Partagez un accès via lien chiffré à durée limitée. Révocable en 1 clic.</p>
      </div>
      <!-- Carte alertes -->
      <div class="bcard" data-tilt>
        <span class="bcard-tag">Intelligence</span>
        <div class="bcard-ico"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
        <h3 class="bcard-h3">Alertes & détection de fuites</h3>
        <p class="bcard-p">Monitoring 24/7 des bases de fuites connues. Alertes instantanées sur credentials compromis.</p>
        <div class="bcard-metric"><span class="metric-val" style="color:var(--gold)">24/7</span><span class="metric-lbl">surveillance active</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     STATS
════════════════════════════════ -->
<section class="stats-band">
  <div class="wrap">
    <div class="stats-box reveal">
      <div class="st-col">
        <div class="st-val"><span id="c1">256</span><span class="acc">-bit</span></div>
        <span class="st-strong">Chiffrement AES</span>
        <span class="st-sub">Standard militaire, certifié FIPS 140-2</span>
      </div>
      <div class="st-col">
        <div class="st-val"><span class="acc"><span id="c2">0</span></span></div>
        <span class="st-strong">Violation enregistrée</span>
        <span class="st-sub">Depuis notre lancement en 2021</span>
      </div>
      <div class="st-col">
        <div class="st-val"><span id="c3">99</span><span class="acc">.<span id="c4">9</span>%</span></div>
        <span class="st-strong">Uptime garanti</span>
        <span class="st-sub">Infrastructure multi-région redondante</span>
      </div>
      <div class="st-col">
        <div class="st-val"><span id="c5">2</span><span class="acc">min</span></div>
        <span class="st-strong">Pour démarrer</span>
        <span class="st-sub">Onboarding guidé, sans carte bancaire</span>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     COMMENT ÇA MARCHE
════════════════════════════════ -->
<section class="how" id="how">
  <div class="wrap">
    <div class="how-head reveal">
      <div class="s-label center">Comment ça marche</div>
      <h2 class="s-h2" style="margin-bottom:.9rem">Opérationnel en <span class="acc">3 étapes.</span></h2>
      <p class="s-p">Aucune formation. Aucun consultant. Juste de la sécurité, immédiatement.</p>
    </div>
    <div class="how-grid reveal">
      <div class="how-step">
        <div class="step-num"><span class="step-n">1</span></div>
        <div class="step-title">Créez votre organisation</div>
        <div class="step-desc">Renseignez le nom de votre entreprise, invitez vos collaborateurs. Coffre-fort actif en moins de 2 minutes.</div>
      </div>
      <div class="how-step">
        <div class="step-num"><span class="step-n">2</span></div>
        <div class="step-title">Importez vos accès</div>
        <div class="step-desc">Depuis un CSV, LastPass, 1Password ou saisie manuelle. Chiffrement instantané à l'import.</div>
      </div>
      <div class="how-step">
        <div class="step-num"><span class="step-n">3</span></div>
        <div class="step-title">Gérez &amp; dormez tranquille</div>
        <div class="step-desc">Attribuez les accès par équipe, suivez en temps réel, révoquez en 1 clic lors des départs.</div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     TÉMOIGNAGES
════════════════════════════════ -->
<section class="testi" id="testi">
  <div class="wrap">
    <div class="testi-head reveal">
      <div class="s-label center">Témoignages</div>
      <h2 class="s-h2">Ce que disent nos clients.</h2>
    </div>
    <div class="testi-grid reveal">
      <div class="tcard">
        <div class="tcard-stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div>
        <p class="tcard-quote">"Avant Lakile, nos mots de passe traînaient sur des Google Sheets. Depuis, <strong>zéro incident</strong> en 18 mois. L'équipe IT dort enfin la nuit."</p>
        <div class="tcard-auth">
          <div class="tcard-av tav-a">MB</div>
          <div><div class="tcard-name">Marc Beaumont</div><div class="tcard-role">RSSI · NexaGroup (350 emp.)</div></div>
        </div>
      </div>
      <div class="tcard">
        <div class="tcard-stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div>
        <p class="tcard-quote">"L'onboarding a pris <strong>11 minutes</strong>. Nos 80 collaborateurs étaient opérationnels le jour même. Exactement ce dont on avait besoin."</p>
        <div class="tcard-auth">
          <div class="tcard-av tav-b">KD</div>
          <div><div class="tcard-name">Kenza Dalil</div><div class="tcard-role">CTO · Digitora</div></div>
        </div>
      </div>
      <div class="tcard">
        <div class="tcard-stars"><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span></div>
        <p class="tcard-quote">"La révocation instantanée a déjà <strong>bloqué 3 tentatives</strong> d'accès post-contrat. Lakile nous a évité une catastrophe."</p>
        <div class="tcard-auth">
          <div class="tcard-av tav-c">AT</div>
          <div><div class="tcard-name">Amine Tahiri</div><div class="tcard-role">DG · Axiolab Finance</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     PRICING
════════════════════════════════ -->
<section class="pricing" id="pricing">
  <div class="wrap">
    <div class="pricing-head reveal">
      <div class="s-label center">Tarification</div>
      <h2 class="s-h2" style="margin-bottom:.9rem">Simple. Transparent.<br><span class="acc">Sans surprise.</span></h2>
      <p class="s-p">14 jours d'essai gratuit sur tous les plans. Aucune carte bancaire.</p>
    </div>
    <div class="pricing-grid reveal">
      <!-- Starter -->
      <div class="pcard">
        <div class="plan-tier">Starter</div>
        <div class="plan-price-wrap"><span class="plan-price">Gratuit</span></div>
        <div class="plan-desc">Pour les petites équipes. Jusqu'à 5 utilisateurs.</div>
        <div class="plan-sep"></div>
        <ul class="plan-list">
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Coffre-fort chiffré</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>5 utilisateurs</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>50 identifiants</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Partage sécurisé</li>
        </ul>
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="plan-btn pb-outline">Commencer gratuitement</a>
        @endif
      </div>
      <!-- Pro -->
      <div class="pcard pop">
        <div class="pop-tag">Le plus choisi</div>
        <div class="plan-tier">Pro</div>
        <div class="plan-price-wrap"><span class="plan-price">29€</span><span class="plan-per">/ mois</span></div>
        <div class="plan-desc">Pour les équipes en croissance. Utilisateurs illimités.</div>
        <div class="plan-sep"></div>
        <ul class="plan-list">
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Tout du Starter</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Utilisateurs illimités</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Identifiants illimités</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Journal d'audit complet</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>SSO &amp; SAML 2.0</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Alertes fuites temps réel</li>
        </ul>
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="plan-btn pb-filled">Essai 14 jours gratuit</a>
        @endif
      </div>
      <!-- Enterprise -->
      <div class="pcard">
        <div class="plan-tier">Enterprise</div>
        <div class="plan-price-wrap"><span class="plan-price" style="font-size:1.8rem;font-weight:700">Sur devis</span></div>
        <div class="plan-desc">Pour les grandes organisations. SLA garanti.</div>
        <div class="plan-sep"></div>
        <ul class="plan-list">
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Tout du Pro</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Déploiement on-premise</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Active Directory</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>SLA 99.99% garanti</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Support dédié 24/7</li>
          <li class="plan-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Audit de conformité</li>
        </ul>
        <a href="#" class="plan-btn pb-outline">Contacter les ventes</a>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     CTA FINAL
════════════════════════════════ -->
<section class="cta-section">
  <div class="wrap">
    <div class="cta-box reveal">
      <div class="cta-chip"><span class="chip-dot"></span>Rejoignez 2 400+ équipes sécurisées</div>
      <h2 class="cta-h2">Chaque jour sans Lakile<br>est un jour de trop.</h2>
      <p class="cta-p">Vos accès critiques méritent une protection enterprise. Démarrez en 2 minutes, sans carte bancaire.</p>
      <div class="cta-acts">
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="btn-primary">
            Créer mon compte gratuit
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        @endif
        <a href="#" class="btn-secondary">Demander une démo</a>
      </div>
      <div class="cta-trust">
        <span class="cta-trust-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>14 jours d'essai gratuit</span>
        <span>·</span>
        <span class="cta-trust-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Sans carte bancaire</span>
        <span>·</span>
        <span class="cta-trust-item"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Résiliation libre</span>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     FOOTER
════════════════════════════════ -->
<footer class="footer">
  <div class="wrap">
    <div class="footer-inner">
      <div class="footer-copy">
        © {{ date('Y') }} <span>Lakile</span> — Gestion sécurisée des accès entreprise
        &nbsp;·&nbsp; Laravel v{{ Illuminate\Foundation\Application::VERSION }}
      </div>
      <div class="footer-links">
        <a href="#">Confidentialité</a>
        <a href="#">CGU</a>
        <a href="#">Sécurité</a>
        <a href="#">Contact</a>
        <a href="#">Statut</a>
      </div>
    </div>
  </div>
</footer>

<!-- ════════════════════════════════
     JAVASCRIPT — Tout en un seul bloc propre
════════════════════════════════ -->
<script>
(function () {
  'use strict';

  /* ─────────────────────────────────────────────
     1. THEME TOGGLE — bullet-proof
  ───────────────────────────────────────────── */
  var THEME_KEY = 'lk-theme';
  var html = document.documentElement;

  function getTheme() {
    return localStorage.getItem(THEME_KEY) === 'light' ? 'light' : 'dark';
  }
  function applyTheme(t) {
    html.setAttribute('data-theme', t);
    localStorage.setItem(THEME_KEY, t);
  }
  // Assure que l'attribut est correct après le chargement DOM
  applyTheme(getTheme());

  var toggleBtn = document.getElementById('themeToggle');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      applyTheme(getTheme() === 'dark' ? 'light' : 'dark');
    });
  }

  /* ─────────────────────────────────────────────
     2. CANVAS PARTICLES
  ───────────────────────────────────────────── */
  var canvas = document.getElementById('particles-canvas');
  var ctx = canvas.getContext('2d');
  var W, H, pts = [];

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  var NUM = Math.min(80, Math.floor(window.innerWidth / 16));
  for (var i = 0; i < NUM; i++) {
    pts.push({
      x: Math.random() * window.innerWidth,
      y: Math.random() * window.innerHeight,
      vx: (Math.random() - .5) * .5,
      vy: (Math.random() - .5) * .5,
      r: Math.random() * 1.8 + .6
    });
  }

  function ptColor() {
    return html.getAttribute('data-theme') === 'light'
      ? 'rgba(41,82,227,'
      : 'rgba(79,124,255,';
  }

  function drawParticles() {
    ctx.clearRect(0, 0, W, H);
    var c = ptColor();
    for (var i = 0; i < pts.length; i++) {
      var p = pts[i];
      p.x += p.vx; p.y += p.vy;
      if (p.x < 0) p.x = W; if (p.x > W) p.x = 0;
      if (p.y < 0) p.y = H; if (p.y > H) p.y = 0;

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = c + '.65)';
      ctx.fill();

      for (var j = i + 1; j < pts.length; j++) {
        var q = pts[j];
        var dx = p.x - q.x, dy = p.y - q.y;
        var d = Math.sqrt(dx * dx + dy * dy);
        if (d < 130) {
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(q.x, q.y);
          ctx.strokeStyle = c + ((.55 - d / 130 * .55).toFixed(3)) + ')';
          ctx.lineWidth = .6;
          ctx.stroke();
        }
      }
    }
    requestAnimationFrame(drawParticles);
  }
  drawParticles();

  /* ─────────────────────────────────────────────
     3. 3D VAULT CARD TILT
  ───────────────────────────────────────────── */
  var scene = document.getElementById('vaultScene');
  if (scene) {
    var parent = scene.parentElement;
    parent.addEventListener('mousemove', function (e) {
      var rect = parent.getBoundingClientRect();
      var cx = rect.left + rect.width  / 2;
      var cy = rect.top  + rect.height / 2;
      var dx = (e.clientX - cx) / (rect.width  / 2);
      var dy = (e.clientY - cy) / (rect.height / 2);
      var rx =  dy * -12;  // tilt vertical
      var ry =  dx *  14;  // tilt horizontal
      scene.style.transform = 'perspective(1200px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) scale3d(1.02,1.02,1.02)';
    });
    parent.addEventListener('mouseleave', function () {
      scene.style.transform = 'perspective(1200px) rotateX(0) rotateY(0) scale3d(1,1,1)';
      scene.style.transition = 'transform .6s ease';
    });
    parent.addEventListener('mouseenter', function () {
      scene.style.transition = 'transform .15s ease-out';
    });
  }

  /* ─────────────────────────────────────────────
     4. 3D TILT SUR LES BENTO CARDS
  ───────────────────────────────────────────── */
  function initCardTilt() {
    var cards = document.querySelectorAll('[data-tilt]');
    cards.forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width  - .5;
        var y = (e.clientY - r.top)  / r.height - .5;
        card.style.transform = 'perspective(900px) rotateY(' + (x * 12) + 'deg) rotateX(' + (-y * 8) + 'deg) scale3d(1.02,1.02,1.02)';
        card.style.transition = 'transform .1s ease-out';
        // Déplace légèrement l'icone en avant
        var ico = card.querySelector('.bcard-ico');
        if (ico) ico.style.transform = 'translateZ(25px) translateX(' + (x*8) + 'px) translateY(' + (y*8) + 'px)';
      });
      card.addEventListener('mouseleave', function () {
        card.style.transform = 'perspective(900px) rotateX(0) rotateY(0) scale3d(1,1,1)';
        card.style.transition = 'transform .5s ease';
        var ico = card.querySelector('.bcard-ico');
        if (ico) { ico.style.transform = 'translateZ(12px)'; ico.style.transition = 'transform .5s ease'; }
      });
    });
  }
  initCardTilt();

  /* ─────────────────────────────────────────────
     5. SCROLL REVEAL avec IntersectionObserver
  ───────────────────────────────────────────── */
  var revealObs = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (!e.isIntersecting) return;
      var el = e.target;
      el.classList.add('in');
      // Stagger les enfants si c'est un container
      var children = el.querySelectorAll(
        '.bcard, .risk-item, .how-step, .tcard, .pcard, .st-col'
      );
      children.forEach(function (c, i) {
        c.style.transitionDelay = (i * 0.09) + 's';
      });
      revealObs.unobserve(el);
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });

  document.querySelectorAll('.reveal').forEach(function (el) {
    revealObs.observe(el);
  });

  /* ─────────────────────────────────────────────
     6. NAV SCROLL SHADOW
  ───────────────────────────────────────────── */
  var nav = document.querySelector('.nav');
  var scrollObs = new IntersectionObserver(function (entries) {
    nav.style.boxShadow = entries[0].isIntersecting
      ? 'none'
      : '0 4px 30px rgba(0,0,0,.15)';
  }, { threshold: 1 });
  var sentinel = document.createElement('div');
  sentinel.style.cssText = 'position:absolute;top:68px;left:0;width:1px;height:1px;pointer-events:none';
  document.body.prepend(sentinel);
  scrollObs.observe(sentinel);

  /* ─────────────────────────────────────────────
     7. PARALLAX HERO GLOWS
  ───────────────────────────────────────────── */
  var glow1 = document.querySelector('.hero-glow');
  var glow2 = document.querySelector('.hero-glow2');
  window.addEventListener('scroll', function () {
    var y = window.scrollY;
    if (glow1) glow1.style.transform = 'translateY(' + (y * .25) + 'px)';
    if (glow2) glow2.style.transform = 'translateY(' + (-y * .15) + 'px)';
  }, { passive: true });

})();
</script>

</body>
</html>
