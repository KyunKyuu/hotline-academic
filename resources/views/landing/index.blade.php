<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hotline Akademik — MLUP Academy</title>
<meta name="description" content="Hotline Akademik MLUP: pendampingan akademik dan non-akademik untuk mahasiswa yang tidak ingin berjuang sendiri.">

<link rel="icon" type="image/png" href="{{ asset('images/brand/logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/brand/logo.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;1,9..144,300;1,9..144,400&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* ─── DESIGN TOKENS (mirroring MLUP system) ─── */
:root {
  --font-serif: 'Fraunces', 'Times New Roman', serif;
  --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;

  --color-primary: #c2793a;
  --color-primary-active: #9c5f2b;
  --color-ink: #23261f;
  --color-body: #40453b;
  --color-muted: #666b5d;
  --color-muted-soft: #8d9284;
  --color-hairline: #e0e2d8;
  --color-canvas: #f8f8f4;
  --color-surface-soft: #f0f1ea;
  --color-surface-card: #e7e9de;
  --color-surface-dark: #20291f;
  --color-surface-dark-elevated: #2b3729;
  --color-on-primary: #fffaf3;
  --color-on-dark: #f2f4ec;
  --color-on-dark-soft: #aab5a0;
  --color-accent-teal: #5f8a52;
  --color-accent-amber: #d1a13a;
  --color-accent-blue: #3f728f;

  --radius-md: 8px;
  --radius-lg: 12px;
  --radius-xl: 16px;
  --radius-2xl: 24px;
  --radius-pill: 9999px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
  font-family: var(--font-sans);
  background-color: var(--color-canvas);
  color: var(--color-body);
  -webkit-font-smoothing: antialiased;
  line-height: 1.6;
}

/* ─── LAYOUT ─── */
.container-app {
  width: min(1200px, 100% - 2.5rem);
  margin-inline: auto;
}

/* ─── SCROLL PROGRESS ─── */
#scroll-progress {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: var(--color-primary);
  transform-origin: left;
  transform: scaleX(0);
  z-index: 100;
  transition: transform 0.05s linear;
}

/* ─── NAVBAR ─── */
.navbar {
  position: sticky;
  top: 0;
  z-index: 50;
  background: rgba(248, 248, 244, 0.92);
  backdrop-filter: blur(8px);
  border-bottom: 1px solid var(--color-hairline);
}
.navbar-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 68px;
}
.navbar-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}
.navbar-brand-badge {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px; height: 36px;
  border-radius: 50%;
  background: var(--color-canvas);
  border: 1px solid var(--color-hairline);
  font-family: var(--font-serif);
  font-size: 14px;
  color: var(--color-primary);
  font-weight: 400;
}
.navbar-brand-text {
  font-family: var(--font-serif);
  font-size: 17px;
  color: var(--color-ink);
  font-weight: 400;
}
.navbar-brand-text em {
  font-style: italic;
  color: var(--color-primary);
}
.navbar-links {
  display: flex;
  align-items: center;
  gap: 32px;
  list-style: none;
}
.navbar-links a {
  font-size: 14px;
  font-weight: 500;
  color: var(--color-muted);
  text-decoration: none;
  transition: color 0.15s;
}
.navbar-links a:hover { color: var(--color-ink); }
.navbar-cta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 40px;
  padding: 0 20px;
  border-radius: var(--radius-md);
  background: var(--color-primary);
  color: var(--color-on-primary);
  font-size: 14px;
  font-weight: 500;
  text-decoration: none;
  transition: background 0.15s, transform 0.2s;
}
.navbar-cta:hover {
  background: var(--color-primary-active);
  transform: translateY(-1px);
}
.navbar-mobile-btn {
  display: none;
  background: none;
  border: 1px solid var(--color-hairline);
  border-radius: var(--radius-md);
  width: 40px; height: 40px;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  color: var(--color-ink);
}

/* ─── HERO ─── */
.hero {
  background: var(--color-surface-dark);
  position: relative;
  overflow: hidden;
  padding: 100px 0 88px;
}
.hero-blob-1 {
  position: absolute;
  right: 5%; top: 10%;
  width: 360px; height: 360px;
  border-radius: 50%;
  background: rgba(194, 121, 58, 0.15);
  filter: blur(60px);
  pointer-events: none;
  animation: float 10s ease-in-out infinite;
}
.hero-blob-2 {
  position: absolute;
  left: -5%; bottom: -10%;
  width: 280px; height: 280px;
  border-radius: 50%;
  background: rgba(95, 138, 82, 0.12);
  filter: blur(60px);
  pointer-events: none;
  animation: float 14s ease-in-out infinite reverse;
}
.hero-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--color-accent-amber);
  margin-bottom: 28px;
}
.hero-eyebrow-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--color-accent-amber);
  animation: pulse-dot 2s ease-in-out infinite;
}
.hero h1 {
  font-family: var(--font-serif);
  font-weight: 400;
  font-size: clamp(38px, 6vw, 72px);
  line-height: 1.0;
  color: var(--color-on-dark);
  letter-spacing: -0.025em;
  max-width: 680px;
  margin-bottom: 8px;
}
.hero h1 em {
  font-style: italic;
  color: var(--color-primary);
}
.hero-bigidea {
  font-family: var(--font-serif);
  font-style: italic;
  font-size: clamp(15px, 2vw, 18px);
  color: rgba(242, 244, 236, 0.45);
  margin-bottom: 28px;
  max-width: 520px;
  line-height: 1.5;
}
.hero-desc {
  font-size: clamp(16px, 2vw, 18px);
  color: var(--color-on-dark-soft);
  max-width: 520px;
  line-height: 1.7;
  margin-bottom: 40px;
}
.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
}
.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  height: 52px;
  padding: 0 28px;
  border-radius: var(--radius-md);
  background: var(--color-primary);
  color: var(--color-on-primary);
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  transition: background 0.2s, transform 0.25s cubic-bezier(.16,1,.3,1), box-shadow 0.3s;
}
.btn-primary:hover {
  background: var(--color-primary-active);
  transform: translateY(-2px);
  box-shadow: 0 10px 30px -8px rgba(194,121,58,0.6);
}
.btn-ghost {
  display: inline-flex;
  align-items: center;
  height: 52px;
  padding: 0 28px;
  border-radius: var(--radius-md);
  border: 1px solid rgba(255,255,255,0.15);
  color: var(--color-on-dark);
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  transition: background 0.2s, transform 0.25s;
}
.btn-ghost:hover {
  background: rgba(255,255,255,0.06);
  transform: translateY(-2px);
}
.hero-stat-row {
  display: flex;
  gap: 32px;
  flex-wrap: wrap;
  margin-top: 56px;
  padding-top: 40px;
  border-top: 1px solid rgba(255,255,255,0.08);
}
.hero-stat {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.hero-stat-label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: rgba(170,181,160,0.7);
}
.hero-stat-val {
  font-family: var(--font-serif);
  font-size: 15px;
  color: rgba(242,244,236,0.75);
}

/* ─── SECTIONS BASE ─── */
.section {
  padding: 88px 0;
}
.section-soft {
  background: var(--color-surface-soft);
}
.section-eyebrow {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--color-primary);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-eyebrow::before {
  content: '';
  width: 20px; height: 1px;
  background: var(--color-primary);
}
.section-title {
  font-family: var(--font-serif);
  font-weight: 400;
  font-size: clamp(28px, 4vw, 44px);
  color: var(--color-ink);
  line-height: 1.1;
  letter-spacing: -0.02em;
  margin-bottom: 14px;
}
.section-title em { font-style: italic; color: var(--color-primary); }
.section-lead {
  font-size: 17px;
  color: var(--color-muted);
  max-width: 520px;
  line-height: 1.7;
  margin-bottom: 48px;
}

/* ─── MASALAH SECTION ─── */
.masalah-intro {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-bottom: 16px;
}
@media (max-width: 640px) {
  .masalah-intro { grid-template-columns: 1fr; }
}
.masalah-card {
  background: white;
  border: 1px solid var(--color-hairline);
  border-radius: var(--radius-xl);
  padding: 28px 28px 24px;
  transition: box-shadow 0.3s, transform 0.3s;
}
.masalah-card:hover {
  box-shadow: 0 12px 40px -10px rgba(35,38,31,0.1);
  transform: translateY(-2px);
}
.masalah-card.akademik { border-top: 3px solid var(--color-accent-teal); }
.masalah-card.psikis { border-top: 3px solid var(--color-accent-amber); }
.masalah-head {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  margin-bottom: 20px;
}
.masalah-icon {
  width: 40px; height: 40px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
  margin-top: 2px;
}
.masalah-card.akademik .masalah-icon { background: rgba(95,138,82,0.12); }
.masalah-card.psikis .masalah-icon { background: rgba(209,161,58,0.12); }
.masalah-card-title { font-size: 15px; font-weight: 600; color: var(--color-ink); margin-bottom: 3px; }
.masalah-card-sub { font-size: 12px; color: var(--color-muted); }
.masalah-list { list-style: none; display: flex; flex-direction: column; gap: 2px; }
.masalah-list li {
  font-size: 14px;
  color: var(--color-body);
  padding: 7px 0 7px 18px;
  position: relative;
  border-bottom: 1px solid var(--color-hairline);
  line-height: 1.5;
}
.masalah-list li:last-child { border-bottom: none; }
.masalah-list li::before {
  content: '–';
  position: absolute;
  left: 0;
  color: var(--color-muted-soft);
}
.masalah-note {
  text-align: center;
  font-size: 14px;
  color: var(--color-muted);
  padding: 20px 0 0;
  font-style: italic;
}

/* ─── FASILITATOR SECTION ─── */
.fas-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
@media (max-width: 640px) {
  .fas-grid { grid-template-columns: 1fr; }
}
.fas-card {
  border-radius: var(--radius-xl);
  padding: 32px;
  position: relative;
  overflow: hidden;
}
.fas-card.layer-2 {
  background: white;
  border: 1px solid var(--color-hairline);
  order: -1;
}
.fas-card.layer-1 {
  background: var(--color-surface-dark);
}
.fas-card-layer-label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  margin-bottom: 12px;
}
.layer-1 .fas-card-layer-label { color: var(--color-accent-amber); }
.layer-2 .fas-card-layer-label { color: var(--color-accent-teal); }
.fas-card-title {
  font-family: var(--font-serif);
  font-weight: 400;
  font-size: 26px;
  line-height: 1.15;
  margin-bottom: 12px;
}
.layer-1 .fas-card-title { color: var(--color-on-dark); }
.layer-2 .fas-card-title { color: var(--color-ink); }
.fas-card-desc {
  font-size: 14px;
  line-height: 1.7;
  margin-bottom: 20px;
}
.layer-1 .fas-card-desc { color: var(--color-on-dark-soft); }
.layer-2 .fas-card-desc { color: var(--color-muted); }
.fas-card-tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  padding: 5px 12px;
  border-radius: var(--radius-pill);
}
.layer-2 .fas-card-tag {
  background: rgba(95,138,82,0.12);
  color: var(--color-accent-teal);
  border: 1px solid rgba(95,138,82,0.2);
}
.layer-1 .fas-card-tag {
  background: rgba(209,161,58,0.15);
  color: var(--color-accent-amber);
  border: 1px solid rgba(209,161,58,0.25);
}
.fas-card-blob {
  position: absolute;
  bottom: -40px; right: -40px;
  width: 160px; height: 160px;
  border-radius: 50%;
  pointer-events: none;
}
.layer-1 .fas-card-blob { background: rgba(209,161,58,0.06); filter: blur(30px); }
.layer-2 .fas-card-blob { background: rgba(95,138,82,0.08); filter: blur(30px); }

/* ─── ALUR SECTION ─── */
.alur-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2px;
  position: relative;
}
@media (max-width: 640px) {
  .alur-grid { grid-template-columns: 1fr; gap: 16px; }
  .alur-connector { display: none; }
}
.alur-connector {
  position: absolute;
  top: 40px; left: calc(33.33% + 12px);
  width: calc(33.33% - 24px);
  height: 1px;
  background: linear-gradient(90deg, var(--color-primary), rgba(194,121,58,0.3));
}
.alur-connector-2 {
  left: calc(66.66% + 12px);
  background: linear-gradient(90deg, rgba(194,121,58,0.3), var(--color-primary));
}
.alur-step {
  padding: 24px 28px 28px;
  position: relative;
}
.alur-step-num {
  width: 40px; height: 40px;
  border-radius: 50%;
  background: var(--color-primary);
  color: var(--color-on-primary);
  font-family: var(--font-serif);
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  position: relative;
  z-index: 1;
}
.alur-step-title {
  font-size: 15px;
  font-weight: 600;
  color: var(--color-ink);
  margin-bottom: 8px;
}
.alur-step-desc {
  font-size: 13.5px;
  color: var(--color-muted);
  line-height: 1.65;
}
.alur-note {
  margin-top: 32px;
  padding: 18px 22px;
  background: rgba(194,121,58,0.07);
  border: 1px solid rgba(194,121,58,0.2);
  border-left: 3px solid var(--color-primary);
  border-radius: var(--radius-md);
  font-size: 13.5px;
  color: var(--color-body);
  line-height: 1.65;
}
.alur-note strong { color: var(--color-ink); font-weight: 600; }

/* ─── USP SECTION ─── */
.usp-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
}
@media (max-width: 768px) {
  .usp-grid { grid-template-columns: 1fr; }
}
.usp-card {
  background: white;
  border: 1px solid var(--color-hairline);
  border-radius: var(--radius-xl);
  padding: 28px;
  transition: box-shadow 0.3s, transform 0.3s;
}
.usp-card:hover {
  box-shadow: 0 12px 40px -10px rgba(35,38,31,0.1);
  transform: translateY(-2px);
}
.usp-icon {
  width: 44px; height: 44px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px;
  margin-bottom: 18px;
}
.usp-card:nth-child(1) .usp-icon { background: rgba(95,138,82,0.12); }
.usp-card:nth-child(2) .usp-icon { background: rgba(194,121,58,0.1); }
.usp-card:nth-child(3) .usp-icon { background: rgba(63,114,143,0.1); }
.usp-title {
  font-size: 15px;
  font-weight: 600;
  color: var(--color-ink);
  margin-bottom: 8px;
}
.usp-desc {
  font-size: 13.5px;
  color: var(--color-muted);
  line-height: 1.65;
}

/* ─── TESTIMONI SECTION ─── */
.testi-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom: 16px;
}
@media (max-width: 640px) {
  .testi-grid { grid-template-columns: 1fr; }
}
.testi-card {
  background: white;
  border: 1px solid var(--color-hairline);
  border-radius: var(--radius-xl);
  padding: 28px;
}
.testi-quote-mark {
  font-family: var(--font-serif);
  font-size: 48px;
  line-height: 1;
  color: var(--color-primary);
  opacity: 0.25;
  margin-bottom: -8px;
  display: block;
}
.testi-text {
  font-family: var(--font-serif);
  font-style: italic;
  font-size: 16px;
  color: var(--color-ink);
  line-height: 1.65;
  margin-bottom: 20px;
}
.testi-meta {
  display: flex;
  align-items: center;
  gap: 10px;
  padding-top: 16px;
  border-top: 1px solid var(--color-hairline);
}
.testi-avatar {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: var(--color-surface-card);
  display: flex; align-items: center; justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
}
.testi-name { font-size: 13px; font-weight: 600; color: var(--color-ink); }
.testi-context { font-size: 12px; color: var(--color-muted); }
.testi-disclaimer {
  font-size: 12px;
  color: var(--color-muted-soft);
  text-align: center;
  padding: 12px 0 0;
  font-style: italic;
}

/* ─── KOMUNITAS SECTION ─── */
.komunitas-intro {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end;
  justify-content: space-between;
  gap: 24px;
  margin-bottom: 40px;
}
.kom-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 12px;
  align-items: center;
}
@media (max-width: 768px) {
  .kom-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 480px) {
  .kom-grid { grid-template-columns: repeat(3, 1fr); }
}
.kom-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  text-decoration: none;
}
.kom-avatar {
  width: 64px; height: 64px;
  border-radius: 50%;
  background: var(--color-surface-card);
  border: 2px solid var(--color-hairline);
  overflow: hidden;
  display: flex; align-items: center; justify-content: center;
  transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
  font-size: 22px;
}
.kom-item:hover .kom-avatar {
  transform: scale(1.08);
  border-color: var(--color-primary);
  box-shadow: 0 4px 16px rgba(194,121,58,0.2);
}
.kom-name {
  font-size: 11px;
  font-weight: 500;
  color: var(--color-muted);
  text-align: center;
  line-height: 1.3;
}
.komunitas-note {
  margin-top: 32px;
  text-align: center;
  font-size: 14px;
  color: var(--color-muted);
  line-height: 1.7;
}
.komunitas-note strong { color: var(--color-ink); }

/* ─── MLUP CONTEXT STRIP ─── */
.mlup-strip {
  background: var(--color-ink);
  padding: 56px 0;
  position: relative;
  overflow: hidden;
}
.mlup-strip-pattern {
  position: absolute;
  inset: 0;
  background-image:
    repeating-linear-gradient(45deg, currentColor 0 1px, transparent 1px 32px),
    repeating-linear-gradient(-45deg, currentColor 0 1px, transparent 1px 32px);
  color: rgba(242,244,236,0.03);
  pointer-events: none;
}
.mlup-strip-inner {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 48px;
  align-items: start;
}
@media (max-width: 768px) {
  .mlup-strip-inner { grid-template-columns: 1fr; gap: 32px; }
}
.mlup-strip-left {}
.mlup-strip-label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: var(--color-accent-amber);
  margin-bottom: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.mlup-strip-label::before {
  content: '';
  width: 16px; height: 1px;
  background: var(--color-accent-amber);
}
.mlup-strip-visi {
  font-family: var(--font-serif);
  font-weight: 400;
  font-size: clamp(18px, 2.5vw, 24px);
  color: var(--color-on-dark);
  line-height: 1.4;
  letter-spacing: -0.01em;
  margin-bottom: 20px;
}
.mlup-strip-visi em { font-style: italic; color: rgba(209,161,58,0.9); }
.mlup-strip-origin {
  font-size: 13.5px;
  color: var(--color-on-dark-soft);
  line-height: 1.7;
  max-width: 380px;
}
.mlup-strip-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-top: 16px;
  font-size: 12.5px;
  font-weight: 500;
  color: rgba(209,161,58,0.75);
  text-decoration: none;
  transition: color 0.15s;
}
.mlup-strip-link:hover { color: var(--color-accent-amber); }
.mlup-strip-right {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.mlup-pilar-label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: rgba(170,181,160,0.5);
  margin-bottom: 12px;
}
.mlup-pilar-item {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.mlup-pilar-item:last-child { border-bottom: none; }
.mlup-pilar-num {
  font-family: var(--font-serif);
  font-size: 13px;
  color: rgba(170,181,160,0.4);
  min-width: 20px;
  padding-top: 1px;
}
.mlup-pilar-text {
  font-size: 13.5px;
  color: var(--color-on-dark-soft);
  line-height: 1.55;
}
.mlup-pilar-text strong {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: rgba(242,244,236,0.75);
  margin-bottom: 2px;
}

/* ─── BEASISWA CALLOUT ─── */
.beasiswa-callout {
  margin-top: 28px;
  background: var(--color-surface-dark);
  border-radius: var(--radius-xl);
  padding: 28px 32px;
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 20px;
  align-items: flex-start;
  position: relative;
  overflow: hidden;
}
@media (max-width: 640px) {
  .beasiswa-callout { grid-template-columns: 1fr; gap: 16px; }
}
.beasiswa-callout-icon {
  width: 44px; height: 44px;
  border-radius: 12px;
  background: rgba(209,161,58,0.15);
  display: flex; align-items: center; justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}
.beasiswa-callout-title {
  font-family: var(--font-serif);
  font-size: 17px;
  font-weight: 400;
  color: var(--color-on-dark);
  margin-bottom: 8px;
  line-height: 1.3;
}
.beasiswa-callout-title em { font-style: italic; color: var(--color-accent-amber); }
.beasiswa-callout-desc {
  font-size: 13.5px;
  color: var(--color-on-dark-soft);
  line-height: 1.7;
}
.beasiswa-callout-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  margin-top: 12px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--color-accent-amber);
  background: rgba(209,161,58,0.1);
  border: 1px solid rgba(209,161,58,0.2);
  padding: 4px 10px;
  border-radius: var(--radius-pill);
}
.beasiswa-callout-blob {
  position: absolute;
  right: -40px; bottom: -40px;
  width: 160px; height: 160px;
  border-radius: 50%;
  background: rgba(209,161,58,0.05);
  filter: blur(40px);
  pointer-events: none;
}
.masalah-keuangan-note {
  margin-top: 10px;
  font-size: 12px;
  color: var(--color-muted-soft);
  font-style: italic;
  padding-left: 18px;
}

/* ─── MASALAH KEUANGAN TAG ─── */
.masalah-list li.keuangan-item {
  background: rgba(209,161,58,0.04);
  border-radius: 6px;
  margin: 2px 0;
  padding-left: 18px;
}

/* ─── CTA FINAL ─── */
.cta-section {
  background: var(--color-surface-dark);
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}
.cta-blob-1 {
  position: absolute;
  left: -5%; top: -20%;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: rgba(194,121,58,0.1);
  filter: blur(80px);
  pointer-events: none;
}
.cta-blob-2 {
  position: absolute;
  right: -5%; bottom: -20%;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: rgba(95,138,82,0.08);
  filter: blur(80px);
  pointer-events: none;
}
.cta-inner {
  position: relative;
  z-index: 1;
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
}
.cta-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: rgba(209,161,58,0.85);
  margin-bottom: 24px;
}
.cta-title {
  font-family: var(--font-serif);
  font-weight: 400;
  font-size: clamp(32px, 5vw, 52px);
  color: var(--color-on-dark);
  line-height: 1.05;
  letter-spacing: -0.02em;
  margin-bottom: 16px;
}
.cta-title em { font-style: italic; color: var(--color-primary); }
.cta-desc {
  font-size: 16px;
  color: var(--color-on-dark-soft);
  line-height: 1.7;
  margin-bottom: 40px;
}
.cta-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  justify-content: center;
}
.cta-privacy {
  margin-top: 28px;
  font-size: 12px;
  color: rgba(170,181,160,0.6);
  display: flex;
  align-items: center;
  gap: 6px;
  justify-content: center;
}

/* ─── FOOTER ─── */
.footer {
  background: var(--color-ink);
  padding: 40px 0;
}
.footer-inner {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}
.footer-brand {
  font-family: var(--font-serif);
  font-size: 16px;
  color: rgba(242,244,236,0.6);
}
.footer-brand em { font-style: italic; color: var(--color-primary); }
.footer-back {
  font-size: 13px;
  color: rgba(170,181,160,0.6);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 6px;
  transition: color 0.15s;
}
.footer-back:hover { color: var(--color-on-dark); }
.footer-note {
  font-size: 12px;
  color: rgba(170,181,160,0.35);
  text-align: center;
  width: 100%;
  padding-top: 24px;
  border-top: 1px solid rgba(255,255,255,0.05);
  margin-top: 16px;
}

/* ─── DIVIDER ─── */
.section-divider {
  width: 100%;
  height: 1px;
  background: var(--color-hairline);
}

/* ─── REVEAL ANIMATION ─── */
[data-reveal] {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.75s cubic-bezier(.16,1,.3,1), transform 0.75s cubic-bezier(.16,1,.3,1);
}
[data-reveal].visible {
  opacity: 1;
  transform: translateY(0);
}
[data-reveal-delay="1"] { transition-delay: 80ms; }
[data-reveal-delay="2"] { transition-delay: 160ms; }
[data-reveal-delay="3"] { transition-delay: 240ms; }
[data-reveal-delay="4"] { transition-delay: 320ms; }

/* ─── MOBILE ─── */
@media (max-width: 768px) {
  .navbar-links, .navbar-cta-wrap { display: none; }
  .navbar-mobile-btn { display: flex; }
  .hero { padding: 72px 0 64px; }
  .section { padding: 64px 0; }
  .alur-grid { grid-template-columns: 1fr; }
  
  /* Dropdown styles for mobile links when active */
  .navbar-links.open {
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 68px;
    left: 0;
    right: 0;
    background: rgba(248, 248, 244, 0.98);
    border-bottom: 1px solid var(--color-hairline);
    padding: 20px;
    gap: 16px;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
  }
}

/* ─── ANIMATIONS ─── */
@keyframes float {
  0%, 100% { transform: translate(0) scale(1); }
  50% { transform: translate(2%, -6%) scale(1.05); }
}
@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(0.85); }
}

/* ─── PATTERN ─── */
.pattern-lattice {
  background-image:
    repeating-linear-gradient(45deg, currentColor 0 1px, transparent 1px 32px),
    repeating-linear-gradient(-45deg, currentColor 0 1px, transparent 1px 32px);
}

/* ─── SECTION LABEL PILL ─── */
.section-pill {
  display: inline-block;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--color-primary);
  background: rgba(194,121,58,0.1);
  border: 1px solid rgba(194,121,58,0.2);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  margin-bottom: 16px;
}
</style>
</head>
<body>

<div id="scroll-progress"></div>

<!-- ══════════ NAVBAR ══════════ -->
<header class="navbar">
  <div class="container-app navbar-inner">
    <a href="{{ route('landing.index') }}" class="navbar-brand">
      <span class="navbar-brand-badge">M</span>
      <span class="navbar-brand-text">MLUP <em>Academy</em></span>
    </a>

    <ul class="navbar-links">
      <li><a href="#masalah">Yang Dicover</a></li>
      <li><a href="#fasilitator">Fasilitator</a></li>
      <li><a href="#alur">Cara Kerja</a></li>
      <li><a href="#cerita">Cerita</a></li>
    </ul>

    <div class="navbar-cta-wrap">
      <a href="#hubungi" class="navbar-cta">Hubungi Sekarang</a>
    </div>

    <button class="navbar-mobile-btn" aria-label="Menu">
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>
</header>

<!-- ══════════ HERO ══════════ -->
<section class="hero">
  <!-- Dynamic Hero Background Image/Video -->
  @if ($hero_type === 'video' && $heroVideoExists)
      <video autoplay muted loop playsinline class="absolute inset-0 h-full w-full object-cover" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">
          @if ($hero_video && is_file(public_path('videos/' . $hero_video)))
              <source src="{{ asset('videos/' . $hero_video) }}" type="video/mp4">
          @else
              <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
          @endif
      </video>
      <div style="position: absolute; inset: 0; background: rgba(32, 41, 31, 0.65); z-index: 2;"></div>
  @elseif ($hero_type === 'image' && $hero_image && is_file(public_path('images/hero/' . $hero_image)))
      <img src="{{ asset('images/hero/' . $hero_image) }}" alt="Hero Background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">
      <div style="position: absolute; inset: 0; background: rgba(32, 41, 31, 0.65); z-index: 2;"></div>
  @endif

  <div class="hero-blob-1" style="z-index: 2;"></div>
  <div class="hero-blob-2" style="z-index: 2;"></div>

  <div class="container-app" style="position: relative; z-index: 3;">
    <div data-reveal>
      <div class="hero-eyebrow">
        <span class="hero-eyebrow-dot"></span>
        Program MLUP Academy · Aktif
      </div>

      <h1>
        @if($hero_title && $hero_title !== 'Unggul dalam Ilmu.')
          @php
              $parts = explode('.', $hero_title, 2);
          @endphp
          @if (count($parts) > 1 && filled(trim($parts[1])))
              {{ trim($parts[0]) }}.<br><span style="font-style: italic; color: var(--color-primary);">{{ trim($parts[1]) }}</span>
          @else
              {!! nl2br(e($hero_title)) !!}
          @endif
        @else
          Kuliah lagi<br>terasa <em>berat?</em>
        @endif
      </h1>

      <p class="hero-bigidea">"Kuliah bukan perjalanan yang harus kamu tempuh sendiri."</p>

      <p class="hero-desc">
        @if($hero_subtitle && !str_contains($hero_subtitle, 'Satu ruang belajar bagi pelajar'))
          {{ $hero_subtitle }}
        @else
          Hotline Akademik MLUP menyediakan pendampingan akademik dan non-akademik untuk mahasiswa — dijalankan oleh kakak mentor per kampus dan fasilitator berpengalaman, tanpa biaya.
        @endif
      </p>

      <div class="hero-actions">
        <a href="#hubungi" class="btn-primary">
          Hubungi Sekarang
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
        <a href="#masalah" class="btn-ghost">Pelajari Dulu</a>
      </div>
    </div>

    <div class="hero-stat-row" data-reveal data-reveal-delay="2">
      <div class="hero-stat">
        <span class="hero-stat-label">Jangkauan</span>
        <span class="hero-stat-val">7 komunitas partner aktif</span>
      </div>
      <div class="hero-stat">
        <span class="hero-stat-label">Hambatan yang dicover</span>
        <span class="hero-stat-val">Akademik & non-akademik</span>
      </div>
      <div class="hero-stat">
        <span class="hero-stat-label">Privasi</span>
        <span class="hero-stat-val">Terjaga, tanpa pengecualian</span>
      </div>
      <div class="hero-stat">
        <span class="hero-stat-label">Hubungi lewat</span>
        <span class="hero-stat-val">WhatsApp atau DM Instagram</span>
      </div>
    </div>
  </div>
</section>

<!-- ══════════ MLUP CONTEXT STRIP ══════════ -->
<section class="mlup-strip">
  <div class="mlup-strip-pattern"></div>
  <div class="container-app">
    <div class="mlup-strip-inner">

      <div class="mlup-strip-left" data-reveal>
        <div class="mlup-strip-label">Siapa MLUP Academy</div>
        <p class="mlup-strip-visi">
          Membangun generasi muslim Indonesia yang menjadi <em>rujukan dalam keilmuan</em> dan teladan dalam keislaman.
        </p>
        <p class="mlup-strip-origin">
          Lahir dari keresahan: biaya pendidikan yang terus naik, mentoring yang belum merata, dan anggapan lama bahwa akademik dan keislaman adalah dua jalan yang berbeda. Hotline Akademik adalah salah satu cara kami menjawab keresahan itu secara nyata.
        </p>
        <a href="https://mlup.konekin.space/" target="_blank" class="mlup-strip-link">
          Kenali MLUP Academy lebih jauh
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>

      <div class="mlup-strip-right" data-reveal data-reveal-delay="1">
        <div class="mlup-pilar-label">Empat Pilar yang Menopang Arah Kami</div>
        <div class="mlup-pilar-item">
          <span class="mlup-pilar-num">01</span>
          <div class="mlup-pilar-text">
            <strong>Merobohkan Sekat Keilmuan dan Keislaman</strong>
            Menolak anggapan bahwa serius belajar berarti longgar beragama — atau sebaliknya.
          </div>
        </div>
        <div class="mlup-pilar-item">
          <span class="mlup-pilar-num">02</span>
          <div class="mlup-pilar-text">
            <strong>Mencetak Rujukan, Bukan Sekadar Lulusan</strong>
            Sosok yang menjadi tempat bertanya, teladan, dan bermanfaat bagi masyarakat.
          </div>
        </div>
        <div class="mlup-pilar-item">
          <span class="mlup-pilar-num">03</span>
          <div class="mlup-pilar-text">
            <strong>Menghapus Alasan "Tidak Mampu"</strong>
            Biaya, akses, dan kondisi ekonomi tidak lagi menjadi alasan seseorang berhenti belajar.
          </div>
        </div>
        <div class="mlup-pilar-item">
          <span class="mlup-pilar-num">04</span>
          <div class="mlup-pilar-text">
            <strong>Merawat Ekosistem</strong>
            Jaringan, komunitas, dan budaya saling membantu lintas kampus dan kota.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════ 01 MASALAH ══════════ -->
<section class="section" id="masalah">
  <div class="container-app">
    <div data-reveal>
      <div class="section-eyebrow">01 — Yang Dicover</div>
      <h2 class="section-title">Apapun yang terasa berat,<br>bisa kamu bawa ke sini</h2>
      <p class="section-lead">Hotline Akademik mencakup hambatan akademik dan non-akademik — termasuk tekanan psikis and masalah keuangan yang berdampak pada keberlangsungan studi.</p>
    </div>

    <div class="masalah-intro">
      <div class="masalah-card akademik" data-reveal data-reveal-delay="1">
        <div class="masalah-head">
          <div class="masalah-icon">📚</div>
          <div>
            <div class="masalah-card-title">Hambatan Akademik</div>
            <div class="masalah-card-sub">Yang menghambat proses belajar & kelulusan</div>
          </div>
        </div>
        <ul class="masalah-list">
          <li>Skripsi mandek — tidak tahu harus mulai dari mana</li>
          <li>IPK rendah, takut tidak bisa lulus tepat waktu</li>
          <li>Banyak mata kuliah yang tidak lulus atau harus diulang</li>
          <li>Tidak paham materi tapi malu bertanya di kelas</li>
          <li>Proses bimbingan dosen yang tidak berjalan baik</li>
          <li>Tidak tahu cara menyusun strategi semester</li>
        </ul>
      </div>

      <div class="masalah-card psikis" data-reveal data-reveal-delay="2">
        <div class="masalah-head">
          <div class="masalah-icon">🧠</div>
          <div>
            <div class="masalah-card-title">Hambatan Non-Akademik</div>
            <div class="masalah-card-sub">Yang tidak kelihatan tapi sama beratnya</div>
          </div>
        </div>
        <ul class="masalah-list">
          <li>Tekanan psikis yang membuat tidak semangat kuliah</li>
          <li>Burnout, merasa buntu, tidak tahu harus ngomong ke siapa</li>
          <li class="keuangan-item">Kesulitan membayar UKT — takut harus berhenti kuliah</li>
          <li class="keuangan-item">Biaya kost, makan, dan kebutuhan harian yang mulai tidak terpenuhi</li>
          <li>Lingkungan atau kondisi hidup yang tidak mendukung</li>
          <li>Merasa sendirian menghadapi beratnya kuliah</li>
          <li>Kehilangan arah — tidak tahu kenapa masih kuliah</li>
        </ul>
      </div>
    </div>

    <!-- BEASISWA CALLOUT -->
    <div class="beasiswa-callout" data-reveal data-reveal-delay="3">
      <div class="beasiswa-callout-blob"></div>
      <div class="beasiswa-callout-icon">🎓</div>
      <div>
        <div class="beasiswa-callout-title">Ini bagian dari <em>Beasiswa Akademik MLUP.</em></div>
        <p class="beasiswa-callout-desc">
          Beasiswa Akademik MLUP hadir dalam dua bentuk. Pertama, bantuan pendampingan langsung — seluruh layanan Hotline Akademik tidak dipungut biaya, mulai dari pendampingan skripsi, psikis, hingga konsultasi keuangan. Kedua, bantuan nominal — kami mengupayakan bantuan biaya UKT, akomodasi, dan biaya hidup bagi mahasiswa yang membutuhkan; termasuk cita-cita jangka panjang kami untuk menyediakan rumah singgah bagi mahasiswa perantau yang tidak mampu. Penerima manfaat yang mendapat bantuan nominal diajak untuk terlibat dalam proyek sosial bersama MLUP — karena kami percaya kebermanfaatan itu bisa diteruskan.
        </p>
        <span class="beasiswa-callout-badge">
          <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
          Pendampingan tanpa biaya · Bantuan nominal tersedia
        </span>
      </div>
    </div>

    <p class="masalah-note" data-reveal data-reveal-delay="4">
      Tidak yakin masalahmu masuk kategori mana? Tidak apa-apa. Ceritakan saja — kakak mentormu yang akan bantu petakan.
    </p>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══════════ 02 FASILITATOR ══════════ -->
<section class="section section-soft" id="fasilitator">
  <div class="container-app">
    <div data-reveal>
      <div class="section-eyebrow">02 — Dua Lapis Fasilitator</div>
      <h2 class="section-title">Dua lapis pendampingan,<br><em>satu alur yang jelas.</em></h2>
      <p class="section-lead">Hotline Akademik dijalankan oleh dua lapis fasilitator dengan peran berbeda — kakak mentor per kampus sebagai titik kontak pertama, dan fasilitator berpengalaman sebagai penanganan lanjutan.</p>
    </div>

    <div class="fas-grid">
      <!-- Layer 2 dulu: yang paling relatable -->
      <div class="fas-card layer-2" data-reveal data-reveal-delay="1">
        <div class="fas-card-blob"></div>
        <div class="fas-card-layer-label">Lapisan 2 — Titik Kontak Pertama</div>
        <div class="fas-card-title">Kakak mentor<br>dari kampusmu sendiri</div>
        <div class="fas-card-desc">
          Alumni S1 atau mahasiswa berprestasi aktif dari kampus yang sama — yang tahu persis sistem, budaya, dan medan akademik di sana. Untuk mahasiswa tingkat akhir, mentornya adalah alumni S1 kampus tersebut. Untuk mahasiswa baru, bisa alumni atau mahasiswa aktif yang perjalanan akademiknya lancar dan terbukti. Mereka yang pertama kali kamu hubungi, dan yang membantu memetakan situasimu sebelum masuk ke penanganan lanjutan.
        </div>
        <span class="fas-card-tag">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Alumni & mahasiswa aktif per kampus
        </span>
      </div>

      <!-- Layer 1: para ahli -->
      <div class="fas-card layer-1" data-reveal data-reveal-delay="2">
        <div class="fas-card-blob"></div>
        <div class="fas-card-layer-label">Lapisan 1 — Penanganan Lanjutan</div>
        <div class="fas-card-title">Fasilitator dengan<br>latar akademik kuat</div>
        <div class="fas-card-desc">
          Tim fasilitator MLUP terdiri dari lulusan S1, S2, hingga doktor dan profesor — dengan latar belakang di bidang pendidikan, psikologi, dan pengembangan akademik. Mereka yang menangani kasus yang butuh keahlian lebih spesifik: strategi studi yang kompleks, pendampingan psikis lanjutan, atau situasi akademik yang perlu solusi yang lebih terstruktur.
        </div>
        <span class="fas-card-tag">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
          S1 · S2 · Doktor · Profesor
        </span>
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══════════ 03 ALUR ══════════ -->
<section class="section" id="alur">
  <div class="container-app">
    <div data-reveal>
      <div class="section-eyebrow">03 — Cara Kerja</div>
      <h2 class="section-title">Tiga langkah,<br><em>satu pesan untuk memulai.</em></h2>
      <p class="section-lead">Begini cara kerja Hotline Akademik dari kontak pertama sampai penanganan.</p>
    </div>

    <div style="position: relative;">
      <div class="alur-grid">

        <div class="alur-connector"></div>
        <div class="alur-connector alur-connector-2"></div>

        <div class="alur-step" data-reveal data-reveal-delay="1">
          <div class="alur-step-num">1</div>
          <div class="alur-step-title">Hubungi kakak konsultan akademik</div>
          <div class="alur-step-desc">
            Lewat WhatsApp atau DM Instagram <strong>@muslimlup.ac.id</strong>. Ceritakan apa yang kamu rasakan — sebisamu, semampumu. Tidak perlu terstruktur.
          </div>
        </div>

        <div class="alur-step" data-reveal data-reveal-delay="2">
          <div class="alur-step-num">2</div>
          <div class="alur-step-title">Disambungkan ke kakak mentor</div>
          <div class="alur-step-desc">
            Yang kenal kampusmu. Mulai cerita dari sana — tidak perlu rapi, tidak perlu lengkap. Kakak mentor yang akan bantu memetakan situasimu.
          </div>
        </div>

        <div class="alur-step" data-reveal data-reveal-delay="3">
          <div class="alur-step-num">3</div>
          <div class="alur-step-title">Ditangani bersama</div>
          <div class="alur-step-desc">
            Oleh kakak mentor dan fasilitator berpengalaman, sesuai kebutuhanmu. Satu langkah konkret dalam satu waktu.
          </div>
        </div>
      </div>

      <div class="alur-note" data-reveal data-reveal-delay="4">
        <strong>Privasi terjaga.</strong> Apa yang kamu ceritakan tidak akan berpindah tangan tanpa seizinmu.
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══════════ 04 USP ══════════ -->
<section class="section section-soft">
  <div class="container-app">
    <div data-reveal>
      <div class="section-eyebrow">04 — Kenapa Hotline Akademik</div>
      <h2 class="section-title">Berbeda dari jalur<br>formal kampus.</h2>
      <p class="section-lead">Jalur formal punya tempatnya. Hotline Akademik hadir untuk yang tidak tercover di sana.</p>
    </div>

    <div class="usp-grid">
      <div class="usp-card" data-reveal data-reveal-delay="1">
        <div class="usp-icon">🔒</div>
        <div class="usp-title">Privasi terjaga</div>
        <div class="usp-desc">
          Apa yang kamu ceritakan tidak berpindah tangan tanpa seizinmu. Berlaku untuk semua informasi, dari awal kontak sampai proses pendampingan.
        </div>
      </div>

      <div class="usp-card" data-reveal data-reveal-delay="2">
        <div class="usp-icon">🤝</div>
        <div class="usp-title">Pendampingan, bukan penilaian</div>
        <div class="usp-desc">
          Kakak mentor dan fasilitator di sini untuk membantu memetakan dan menyelesaikan masalahmu — bukan mengevaluasi sejauh mana kamu sudah berusaha.
        </div>
      </div>

      <div class="usp-card" data-reveal data-reveal-delay="3">
        <div class="usp-icon">🧩</div>
        <div class="usp-title">Struktur berlapis yang serius</div>
        <div class="usp-desc">
          Kakak mentor yang kenal kampusmu, fasilitator berpengalaman yang tahu solusinya — dua lapisan yang bekerja bersama agar kamu tidak jatuh di celah antara "butuh teman" and "butuh ahli."
        </div>
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══════════ 05 CERITA ══════════ -->
<section class="section" id="cerita">
  <div class="container-app">
    <div data-reveal>
      <div class="section-eyebrow">05 — Cerita dari Peserta</div>
      <h2 class="section-title">Bukan janji.<br><em>Ini yang sudah terjadi.</em></h2>
      <p class="section-lead">Cerita-cerita ini ditulis ulang secara anonim atas izin yang bersangkutan. Identitas dijaga sepenuhnya.</p>
    </div>

    <div class="testi-grid">
      @foreach($testimonials as $index => $testi)
        <div class="testi-card" data-reveal data-reveal-delay="{{ min($index + 1, 4) }}">
          <span class="testi-quote-mark">"</span>
          <p class="testi-text">
            {{ $testi['message'] }}
          </p>
          <div class="testi-meta">
            <div class="testi-avatar">{{ $testi['avatar'] ?? '✦' }}</div>
            <div>
              <div class="testi-name">{{ $testi['name'] }}</div>
              <div class="testi-context">{{ $testi['context'] }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <p class="testi-disclaimer" data-reveal data-reveal-delay="3">
      * Nama dan detail disamarkan. Cerita disampaikan atas izin peserta.
    </p>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══════════ 06 KOMUNITAS SATELIT ══════════ -->
<section class="section section-soft">
  <div class="container-app">
    <div class="komunitas-intro" data-reveal>
      <div>
        <div class="section-eyebrow">06 — Ekosistem</div>
        <h2 class="section-title" style="margin-bottom: 8px;">7 komunitas partner.<br>Sudah ada di kampusmu.</h2>
        <p style="font-size: 15px; color: var(--color-muted); max-width: 440px; line-height: 1.7;">Kakak mentor per kampus bekerja melalui jaringan komunitas ini — artinya ada yang kenal medan tempatmu belajar.</p>
      </div>
    </div>

    <div class="kom-grid" data-reveal data-reveal-delay="1">
      @foreach ($partners as $partner)
        <a class="kom-item" href="{{ route('landing.community.show', $partner['slug']) }}">
          <div class="kom-avatar">
            @if (!empty($partner['logo']['exists']))
              <img src="{{ asset('images/partners/' . $partner['logo']['file']) }}" alt="{{ $partner['name'] }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            @else
              {{ mb_substr($partner['name'], 0, 1) }}
            @endif
          </div>
          <span class="kom-name">{{ $partner['name'] }}</span>
        </a>
      @endforeach
    </div>

    <p class="komunitas-note" data-reveal data-reveal-delay="2">
      <strong>Komunitas kamu belum terdaftar?</strong> Tidak masalah — Hotline Akademik terbuka untuk semua mahasiswa, tanpa terkecuali.
    </p>
  </div>
</section>

<!-- ══════════ CTA FINAL ══════════ -->
<section class="cta-section" id="hubungi">
  <div class="cta-blob-1"></div>
  <div class="cta-blob-2"></div>

  <div class="container-app">
    <div class="cta-inner" data-reveal>
      <div class="cta-eyebrow">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Mulai di sini
      </div>

      <h2 class="cta-title">Siap untuk<br><em>cerita?</em></h2>

      <p class="cta-desc">
        Tidak perlu cerita yang terstruktur. Tidak perlu tahu dulu apa yang kamu butuhkan. Satu pesan sudah cukup untuk memulai.
      </p>

      <div class="cta-actions">
        <!-- WhatsApp redirect with dynamic tracking parameters -->
        <a href="{{ route('landing.whatsapp.redirect', ['source' => 'cta_final', 'campaign' => 'gabung_komunitas']) }}" target="_blank" class="btn-primary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.558 4.121 1.532 5.849L.057 23.428a.5.5 0 00.614.614l5.579-1.475A11.943 11.943 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.807 9.807 0 01-5.032-1.388l-.36-.214-3.733.987.988-3.647-.235-.374A9.808 9.808 0 012.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/></svg>
          Chat Kakak Konsultan
        </a>
        <a href="https://instagram.com/muslimlup.ac.id" target="_blank" class="btn-ghost">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          DM @muslimlup.ac.id
        </a>
      </div>

      <div class="cta-privacy">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Privasi terjaga. Tidak ada informasimu yang berpindah tangan tanpa seizinmu.
      </div>
    </div>
  </div>
</section>

<!-- ══════════ FOOTER ══════════ -->
<footer class="footer">
  <div class="container-app">
    <div class="footer-inner">
      <span class="footer-brand">MLUP <em>Academy</em> — Hotline Akademik</span>
      
      <div style="display: flex; flex-wrap: wrap; gap: 24px; align-items: center;">
        <a href="{{ route('articles.index') }}" class="footer-back" style="color: rgba(170,181,160,0.6); text-decoration: none; font-size: 13.5px; transition: color 0.15s;">Artikel</a>
        @auth
          <a href="{{ route('hotline.dashboard') }}" class="footer-back" style="color: rgba(170,181,160,0.6); text-decoration: none; font-size: 13.5px; transition: color 0.15s;">Dashboard Admin</a>
        @else
          <a href="{{ route('admin.login') }}" class="footer-back" style="color: rgba(170,181,160,0.6); text-decoration: none; font-size: 13.5px; transition: color 0.15s;">Login Admin</a>
        @endauth
        <a href="https://mlup.konekin.space/" class="footer-back">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Kembali ke MLUP Academy
        </a>
      </div>
    </div>
    <p class="footer-note">
      © {{ date('Y') }} · MLUP Academy · Bandung, Jawa Barat, Indonesia — Komunitas pendidikan muslim Indonesia.
    </p>
  </div>
</footer>

<script>
// ── Scroll Progress ──
const progressBar = document.getElementById('scroll-progress');
window.addEventListener('scroll', () => {
  const max = document.documentElement.scrollHeight - window.innerHeight;
  const pct = max > 0 ? window.scrollY / max : 0;
  progressBar.style.transform = `scaleX(${pct})`;
}, { passive: true });

// ── Reveal on Scroll ──
const revealEls = document.querySelectorAll('[data-reveal]');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

revealEls.forEach(el => observer.observe(el));

// ── Trigger hero reveals immediately ──
document.querySelectorAll('.hero [data-reveal]').forEach(el => {
  setTimeout(() => el.classList.add('visible'), 100);
});

// ── Mobile Menu Toggle ──
const mobileBtn = document.querySelector('.navbar-mobile-btn');
const navLinks = document.querySelector('.navbar-links');
if (mobileBtn && navLinks) {
  mobileBtn.addEventListener('click', () => {
    navLinks.classList.toggle('open');
  });
  navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      navLinks.classList.remove('open');
    });
  });
}
</script>
</body>
</html>