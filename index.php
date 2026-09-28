<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AMS Barbershop — Sentuhan Presisi, Gaya Sejati</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600&family=Bebas+Neue&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --gold: #C9A84C;
      --gold-light: #E8C96A;
      --gold-dim: rgba(201,168,76,0.15);
      --black: #0a0a0a;
      --black-2: #111111;
      --black-3: #1a1a1a;
      --black-4: #222222;
      --white: #f5f0e8;
      --white-dim: rgba(245,240,232,0.08);
      --text-muted: rgba(245,240,232,0.45);
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--black);
      color: var(--white);
      overflow-x: hidden;
    }

    /* ====== SCROLLBAR ====== */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: var(--black); }
    ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }

    /* ====== NOISE OVERLAY ====== */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
      opacity: 0.35;
    }

    /* ====== CURSOR ====== */
    .cursor {
      width: 8px; height: 8px;
      background: var(--gold);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 99999;
      transition: transform 0.1s;
      mix-blend-mode: difference;
    }
    .cursor-ring {
      width: 36px; height: 36px;
      border: 1px solid var(--gold);
      border-radius: 50%;
      position: fixed;
      pointer-events: none;
      z-index: 99998;
      transition: all 0.12s ease;
      mix-blend-mode: difference;
    }

    /* ====== LOADER ====== */
    #loader {
      position: fixed;
      inset: 0;
      background: var(--black);
      z-index: 99990;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 24px;
      transition: opacity 0.6s ease, visibility 0.6s ease;
    }
    #loader.hidden { opacity: 0; visibility: hidden; }
    .loader-logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 64px;
      letter-spacing: 12px;
      color: var(--gold);
      animation: logoFlicker 0.8s ease forwards;
    }
    @keyframes logoFlicker {
      0%,20%,40% { opacity: 0.1; }
      10%,30%,100% { opacity: 1; }
    }
    .loader-bar {
      width: 200px; height: 1px;
      background: rgba(255,255,255,0.1);
      position: relative;
      overflow: hidden;
    }
    .loader-bar::after {
      content: '';
      position: absolute;
      left: -100%;
      top: 0; height: 100%;
      width: 100%;
      background: var(--gold);
      animation: loadBar 1.8s ease forwards;
    }
    @keyframes loadBar { to { left: 0; } }
    .loader-text {
      font-size: 11px;
      letter-spacing: 4px;
      color: var(--text-muted);
      text-transform: uppercase;
    }

    /* ====== NAV ====== */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 1000;
      padding: 24px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: all 0.4s ease;
    }
    nav.scrolled {
      background: rgba(10,10,10,0.95);
      backdrop-filter: blur(20px);
      padding: 16px 60px;
      border-bottom: 1px solid rgba(201,168,76,0.12);
    }
    .nav-logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 28px;
      letter-spacing: 6px;
      color: var(--gold);
      text-decoration: none;
    }
    .nav-links { display: flex; gap: 40px; list-style: none; }
    .nav-links a {
      font-size: 12px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.3s;
      position: relative;
    }
    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -4px; left: 0;
      width: 0; height: 1px;
      background: var(--gold);
      transition: width 0.3s ease;
    }
    .nav-links a:hover { color: var(--white); }
    .nav-links a:hover::after { width: 100%; }
    .nav-cta {
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--black);
      background: var(--gold);
      padding: 10px 24px;
      text-decoration: none;
      transition: all 0.3s;
    }
    .nav-cta:hover { background: var(--gold-light); transform: translateY(-1px); }

    /* Hamburger */
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
    .hamburger span { width: 24px; height: 1px; background: var(--white); transition: all 0.3s; display: block; }
    .hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(4px, 4px); }
    .hamburger.open span:nth-child(2) { opacity: 0; }
    .hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(4px, -4px); }

    /* Mobile menu */
    .mobile-menu {
      display: none;
      position: fixed;
      inset: 0;
      background: var(--black);
      z-index: 900;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 40px;
    }
    .mobile-menu.open { display: flex; }
    .mobile-menu a {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 48px;
      letter-spacing: 8px;
      color: var(--white);
      text-decoration: none;
      transition: color 0.3s;
    }
    .mobile-menu a:hover { color: var(--gold); }

    /* ====== HERO ====== */
    #hero {
      min-height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      overflow: hidden;
    }
    .hero-bg {
      position: absolute;
      inset: 0;
      background: url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=1800&q=80') center/cover no-repeat;
      filter: brightness(0.25);
      transform: scale(1.05);
      animation: heroZoom 12s ease-in-out infinite alternate;
    }
    @keyframes heroZoom {
      from { transform: scale(1.05); }
      to { transform: scale(1.12); }
    }
    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(10,10,10,0.7) 0%, transparent 60%, rgba(10,10,10,0.4) 100%);
    }
    .hero-content {
      position: relative;
      z-index: 2;
      padding: 0 60px;
      max-width: 800px;
    }
    .hero-eyebrow {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 28px;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s 2.2s forwards;
    }
    .hero-eyebrow span {
      font-size: 11px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--gold);
    }
    .eyebrow-line {
      width: 60px; height: 1px;
      background: var(--gold);
    }
    .hero-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: clamp(72px, 10vw, 140px);
      line-height: 0.9;
      letter-spacing: 4px;
      margin-bottom: 24px;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeUp 1s 2.4s forwards;
    }
    .hero-title .gold { color: var(--gold); }
    .hero-sub {
      font-size: 15px;
      color: var(--text-muted);
      line-height: 1.7;
      max-width: 420px;
      margin-bottom: 40px;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s 2.6s forwards;
    }
    .hero-actions {
      display: flex;
      gap: 16px;
      align-items: center;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.8s 2.8s forwards;
    }
    .btn-primary {
      background: var(--gold);
      color: var(--black);
      padding: 16px 40px;
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      font-weight: 600;
      border: none;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s;
      position: relative;
      overflow: hidden;
    }
    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0; left: -100%;
      width: 100%; height: 100%;
      background: var(--gold-light);
      transition: left 0.3s ease;
    }
    .btn-primary:hover::before { left: 0; }
    .btn-primary span { position: relative; z-index: 1; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 16px 40px rgba(201,168,76,0.3); }
    .btn-ghost {
      color: var(--white);
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s;
    }
    .btn-ghost::after {
      content: '→';
      transition: transform 0.3s;
    }
    .btn-ghost:hover { color: var(--gold); }
    .btn-ghost:hover::after { transform: translateX(6px); }

    /* Hero bottom bar */
    .hero-stats {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      z-index: 2;
      display: flex;
      border-top: 1px solid rgba(201,168,76,0.15);
      opacity: 0;
      animation: fadeIn 0.8s 3.2s forwards;
    }
    .hero-stat {
      flex: 1;
      padding: 28px 40px;
      border-right: 1px solid rgba(201,168,76,0.1);
      text-align: center;
      background: rgba(10,10,10,0.6);
      backdrop-filter: blur(10px);
      transition: background 0.3s;
    }
    .hero-stat:last-child { border-right: none; }
    .hero-stat:hover { background: rgba(201,168,76,0.06); }
    .stat-num {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 40px;
      letter-spacing: 2px;
      color: var(--gold);
      display: block;
    }
    .stat-label {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-top: 4px;
    }

    /* Scroll indicator */
    .scroll-hint {
      position: absolute;
      bottom: 140px;
      right: 60px;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      opacity: 0;
      animation: fadeIn 1s 3.4s forwards;
    }
    .scroll-hint span {
      font-size: 9px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      writing-mode: vertical-rl;
    }
    .scroll-line {
      width: 1px; height: 60px;
      background: linear-gradient(to bottom, var(--gold), transparent);
      animation: scrollPulse 2s infinite;
    }
    @keyframes scrollPulse {
      0%,100% { transform: scaleY(1); opacity: 1; }
      50% { transform: scaleY(0.5); opacity: 0.5; }
    }

    /* ====== KEYFRAMES ====== */
    @keyframes fadeUp {
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      to { opacity: 1; }
    }

    /* ====== SECTION COMMON ====== */
    section { padding: 120px 60px; }
    .section-eyebrow {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 20px;
    }
    .section-eyebrow span {
      font-size: 10px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--gold);
    }
    .eyebrow-line-sm { width: 40px; height: 1px; background: var(--gold); }
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(36px, 5vw, 64px);
      font-weight: 700;
      line-height: 1.1;
      margin-bottom: 20px;
    }
    .section-sub {
      font-size: 15px;
      color: var(--text-muted);
      line-height: 1.8;
      max-width: 500px;
    }

    /* Reveal animation */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .reveal-left {
      opacity: 0;
      transform: translateX(-40px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .reveal-left.visible { opacity: 1; transform: translateX(0); }
    .reveal-right {
      opacity: 0;
      transform: translateX(40px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    .reveal-right.visible { opacity: 1; transform: translateX(0); }

    /* ====== ABOUT ====== */
    #about {
      background: var(--black-2);
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 100px;
      align-items: center;
    }
    .about-image-wrap {
      position: relative;
    }
    .about-image-wrap img {
      width: 100%;
      height: 600px;
      object-fit: cover;
      display: block;
    }
    .about-image-accent {
      position: absolute;
      top: -20px; left: -20px;
      width: 100%; height: 100%;
      border: 1px solid rgba(201,168,76,0.3);
      pointer-events: none;
      transition: transform 0.4s ease;
    }
    .about-image-wrap:hover .about-image-accent {
      transform: translate(8px, 8px);
    }
    .about-year {
      position: absolute;
      bottom: -20px; right: -20px;
      background: var(--gold);
      color: var(--black);
      padding: 24px 28px;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 48px;
      letter-spacing: 4px;
      line-height: 1;
    }
    .about-year small {
      display: block;
      font-family: 'Inter', sans-serif;
      font-size: 9px;
      letter-spacing: 3px;
      text-transform: uppercase;
      margin-bottom: 4px;
    }
    .about-features {
      margin-top: 40px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .about-feature {
      padding: 20px;
      border: 1px solid rgba(201,168,76,0.12);
      transition: all 0.3s;
    }
    .about-feature:hover {
      border-color: rgba(201,168,76,0.4);
      background: var(--gold-dim);
    }
    .about-feature-icon {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .about-feature h4 {
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 4px;
    }
    .about-feature p {
      font-size: 12px;
      color: var(--text-muted);
    }

    /* ====== SERVICES ====== */
    #services {
      background: var(--black);
    }
    .services-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 60px;
    }
    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
    }
    .service-card {
      position: relative;
      overflow: hidden;
      aspect-ratio: 3/4;
      background: var(--black-3);
      cursor: pointer;
    }
    .service-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.5;
      transition: all 0.6s ease;
    }
    .service-card:hover img {
      opacity: 0.7;
      transform: scale(1.06);
    }
    .service-info {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 36px 32px;
      background: linear-gradient(to top, rgba(10,10,10,0.95) 0%, transparent 60%);
    }
    .service-num {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 80px;
      color: rgba(201,168,76,0.1);
      line-height: 1;
      position: absolute;
      top: 20px; right: 24px;
      transition: color 0.3s;
    }
    .service-card:hover .service-num { color: rgba(201,168,76,0.2); }
    .service-tag {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 8px;
    }
    .service-name {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 8px;
      transform: translateY(10px);
      transition: transform 0.4s ease;
    }
    .service-card:hover .service-name { transform: translateY(0); }
    .service-desc {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.6;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease, opacity 0.4s ease;
      opacity: 0;
    }
    .service-card:hover .service-desc { max-height: 80px; opacity: 1; }
    .service-price {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 32px;
      letter-spacing: 2px;
      color: var(--gold);
      margin-top: 16px;
      display: flex;
      align-items: baseline;
      gap: 6px;
    }
    .service-price small {
      font-family: 'Inter', sans-serif;
      font-size: 11px;
      font-weight: 400;
      color: var(--text-muted);
      letter-spacing: 0;
    }

    /* ====== BARBERS ====== */
    #barbers {
      background: var(--black-2);
    }
    .barbers-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 60px;
    }
    .barber-card {
      position: relative;
      overflow: hidden;
      background: var(--black-3);
      transition: transform 0.4s ease;
    }
    .barber-card:hover { transform: translateY(-8px); }
    .barber-img {
      width: 100%;
      height: 380px;
      object-fit: cover;
      display: block;
      filter: grayscale(30%);
      transition: filter 0.4s ease;
    }
    .barber-card:hover .barber-img { filter: grayscale(0%); }
    .barber-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, var(--black-3) 0%, transparent 50%);
    }
    .barber-info {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      padding: 28px 24px;
    }
    .barber-name {
      font-family: 'Playfair Display', serif;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .barber-title {
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 12px;
    }
    .barber-skills {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }
    .skill-tag {
      font-size: 10px;
      letter-spacing: 1px;
      color: var(--text-muted);
      background: rgba(255,255,255,0.06);
      padding: 4px 10px;
      border: 1px solid rgba(255,255,255,0.1);
    }

    /* ====== GALLERY ====== */
    #gallery {
      background: var(--black);
      padding: 120px 0;
    }
    .gallery-header {
      padding: 0 60px;
      margin-bottom: 60px;
    }
    .gallery-track-wrap {
      overflow: hidden;
      position: relative;
    }
    .gallery-track-wrap::before,
    .gallery-track-wrap::after {
      content: '';
      position: absolute;
      top: 0; bottom: 0;
      width: 120px;
      z-index: 2;
    }
    .gallery-track-wrap::before {
      left: 0;
      background: linear-gradient(to right, var(--black), transparent);
    }
    .gallery-track-wrap::after {
      right: 0;
      background: linear-gradient(to left, var(--black), transparent);
    }
    .gallery-track {
      display: flex;
      gap: 16px;
      animation: galleryScroll 28s linear infinite;
    }
    .gallery-track:hover { animation-play-state: paused; }
    @keyframes galleryScroll {
      from { transform: translateX(0); }
      to { transform: translateX(-50%); }
    }
    .gallery-item {
      flex-shrink: 0;
      width: 320px;
      height: 400px;
      overflow: hidden;
      position: relative;
    }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s ease;
    }
    .gallery-item:hover img { transform: scale(1.08); }
    .gallery-item-label {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      padding: 20px;
      background: linear-gradient(to top, rgba(10,10,10,0.9), transparent);
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--gold);
      opacity: 0;
      transition: opacity 0.3s;
    }
    .gallery-item:hover .gallery-item-label { opacity: 1; }

    /* ====== TESTIMONIALS ====== */
    #testimonials {
      background: var(--black-2);
    }
    .testimonials-slider {
      margin-top: 60px;
      position: relative;
      overflow: hidden;
    }
    .testimonials-track {
      display: flex;
      transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .testimonial-slide {
      min-width: 100%;
      padding: 0 60px;
    }
    .testimonial-inner {
      max-width: 820px;
      margin: 0 auto;
      text-align: center;
    }
    .testimonial-quote {
      font-size: 80px;
      color: var(--gold);
      line-height: 0.5;
      font-family: 'Playfair Display', serif;
      margin-bottom: 32px;
      opacity: 0.4;
    }
    .testimonial-text {
      font-family: 'Playfair Display', serif;
      font-size: clamp(20px, 3vw, 32px);
      font-style: italic;
      line-height: 1.5;
      color: var(--white);
      margin-bottom: 40px;
    }
    .testimonial-author {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
    }
    .author-img {
      width: 52px; height: 52px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--gold);
    }
    .author-name {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 2px;
    }
    .author-meta {
      font-size: 11px;
      color: var(--text-muted);
      letter-spacing: 2px;
    }
    .stars { color: var(--gold); font-size: 14px; margin-bottom: 6px; }
    .slider-controls {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      margin-top: 48px;
    }
    .slider-btn {
      width: 48px; height: 48px;
      border: 1px solid rgba(201,168,76,0.3);
      background: transparent;
      color: var(--gold);
      font-size: 18px;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .slider-btn:hover {
      background: var(--gold);
      color: var(--black);
    }
    .slider-dots {
      display: flex;
      gap: 8px;
    }
    .dot {
      width: 6px; height: 6px;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      cursor: pointer;
      transition: all 0.3s;
    }
    .dot.active {
      background: var(--gold);
      width: 24px;
      border-radius: 3px;
    }

    /* ====== PRICING ====== */
    #pricing {
      background: var(--black);
    }
    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
      margin-top: 60px;
    }
    .pricing-card {
      background: var(--black-3);
      padding: 48px 40px;
      position: relative;
      transition: all 0.4s ease;
      border: 1px solid transparent;
    }
    .pricing-card:hover {
      border-color: rgba(201,168,76,0.3);
      transform: translateY(-4px);
    }
    .pricing-card.featured {
      background: var(--gold);
    }
    .pricing-card.featured * { color: var(--black); }
    .pricing-badge {
      position: absolute;
      top: 24px; right: 24px;
      font-size: 9px;
      letter-spacing: 3px;
      text-transform: uppercase;
      background: var(--black);
      color: var(--gold);
      padding: 6px 14px;
    }
    .pricing-icon { font-size: 32px; margin-bottom: 20px; }
    .pricing-name {
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 10px;
    }
    .pricing-card.featured .pricing-name { color: rgba(10,10,10,0.6); }
    .pricing-price {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 56px;
      letter-spacing: 2px;
      color: var(--white);
      line-height: 1;
      margin-bottom: 4px;
    }
    .pricing-card.featured .pricing-price { color: var(--black); }
    .pricing-dur {
      font-size: 12px;
      color: var(--text-muted);
      margin-bottom: 28px;
    }
    .pricing-features {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-bottom: 36px;
    }
    .pricing-features li {
      font-size: 13px;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .pricing-card.featured .pricing-features li { color: rgba(10,10,10,0.7); }
    .pricing-features li::before {
      content: '✓';
      color: var(--gold);
      font-size: 12px;
      font-weight: 700;
    }
    .pricing-card.featured .pricing-features li::before { color: var(--black); }
    .btn-pricing {
      width: 100%;
      padding: 14px;
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      border: 1px solid var(--gold);
      background: transparent;
      color: var(--gold);
    }
    .btn-pricing:hover { background: var(--gold); color: var(--black); }
    .pricing-card.featured .btn-pricing {
      background: var(--black);
      color: var(--gold);
      border-color: var(--black);
    }
    .pricing-card.featured .btn-pricing:hover { background: var(--black-4); }

    /* ====== BOOKING ====== */
    #booking {
      background: var(--black-2);
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0;
      padding: 0;
      overflow: hidden;
    }
    .booking-visual {
      position: relative;
      min-height: 700px;
      overflow: hidden;
    }
    .booking-visual img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.4);
    }
    .booking-visual-overlay {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 60px;
      background: linear-gradient(to top, rgba(10,10,10,0.9), transparent);
    }
    .booking-form-wrap {
      padding: 80px 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-label {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--text-muted);
      display: block;
      margin-bottom: 8px;
    }
    .form-control {
      width: 100%;
      background: var(--white-dim);
      border: 1px solid rgba(201,168,76,0.15);
      color: var(--white);
      padding: 14px 18px;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: all 0.3s;
      appearance: none;
    }
    .form-control:focus {
      border-color: var(--gold);
      background: rgba(201,168,76,0.06);
    }
    .form-control option { background: var(--black-3); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .booking-note {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 20px;
      line-height: 1.6;
    }

    /* ====== CONTACT BAR ====== */
    #contact {
      background: var(--black);
      padding: 80px 60px;
    }
    .contact-inner {
      border: 1px solid rgba(201,168,76,0.15);
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      divide-x: 1px solid rgba(201,168,76,0.1);
    }
    .contact-item {
      padding: 48px 40px;
      border-right: 1px solid rgba(201,168,76,0.1);
      transition: background 0.3s;
    }
    .contact-item:last-child { border-right: none; }
    .contact-item:hover { background: var(--gold-dim); }
    .contact-icon { font-size: 28px; margin-bottom: 16px; }
    .contact-label {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 8px;
    }
    .contact-value {
      font-size: 15px;
      font-weight: 500;
      margin-bottom: 4px;
    }
    .contact-meta {
      font-size: 12px;
      color: var(--text-muted);
    }

    /* ====== FOOTER ====== */
    footer {
      background: var(--black-2);
      padding: 60px;
      border-top: 1px solid rgba(201,168,76,0.12);
    }
    .footer-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .footer-logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 36px;
      letter-spacing: 8px;
      color: var(--gold);
    }
    .footer-sub {
      font-size: 11px;
      letter-spacing: 3px;
      color: var(--text-muted);
      margin-top: 4px;
    }
    .footer-links { display: flex; gap: 32px; }
    .footer-links a {
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.3s;
    }
    .footer-links a:hover { color: var(--gold); }
    .footer-copy {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 40px;
      padding-top: 28px;
      border-top: 1px solid rgba(255,255,255,0.05);
      text-align: center;
    }

    /* ====== FLOATER ====== */
    .float-cta {
      position: fixed;
      bottom: 40px;
      right: 40px;
      z-index: 500;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 12px;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.4s;
    }
    .float-cta.show { opacity: 1; transform: translateY(0); }
    .float-wa {
      width: 52px; height: 52px;
      background: #25D366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      text-decoration: none;
      box-shadow: 0 8px 24px rgba(37,211,102,0.3);
      transition: transform 0.3s;
    }
    .float-wa:hover { transform: scale(1.1); }
    .float-top {
      width: 48px; height: 48px;
      border: 1px solid rgba(201,168,76,0.3);
      background: var(--black-2);
      color: var(--gold);
      font-size: 18px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
    }
    .float-top:hover { background: var(--gold); color: var(--black); }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 1024px) {
      section { padding: 80px 40px; }
      nav, nav.scrolled { padding: 20px 40px; }
      #about { grid-template-columns: 1fr; gap: 60px; }
      .services-grid { grid-template-columns: 1fr 1fr; }
      .barbers-grid { grid-template-columns: 1fr 1fr; }
      .pricing-grid { grid-template-columns: 1fr; gap: 2px; }
      #booking { grid-template-columns: 1fr; }
      .booking-visual { min-height: 400px; }
      .contact-inner { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 768px) {
      section { padding: 60px 24px; }
      nav { padding: 18px 24px; }
      nav.scrolled { padding: 14px 24px; }
      .nav-links, .nav-cta { display: none; }
      .hamburger { display: flex; }
      .hero-content { padding: 0 24px; }
      .hero-stats { display: none; }
      .scroll-hint { display: none; }
      .services-grid { grid-template-columns: 1fr; }
      .barbers-grid { grid-template-columns: 1fr; }
      .contact-inner { grid-template-columns: 1fr; }
      .footer-inner { flex-direction: column; gap: 32px; text-align: center; }
      .footer-links { flex-wrap: wrap; justify-content: center; }
      .gallery-item { width: 240px; height: 300px; }
      .booking-form-wrap { padding: 40px 24px; }
      .form-row { grid-template-columns: 1fr; }
      #contact { padding: 60px 24px; }
    }
  </style>
</head>
<body>

<!-- CURSOR -->
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- LOADER -->
<div id="loader">
  <div class="loader-logo">AMS</div>
  <div class="loader-bar"></div>
  <div class="loader-text">Barbershop</div>
</div>

<!-- NAV -->
<nav id="navbar">
  <a href="#hero" class="nav-logo">AMS</a>
  <ul class="nav-links">
    <li><a href="#about">About</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#barbers">Barbers</a></li>
    <li><a href="#gallery">Gallery</a></li>
    <li><a href="#pricing">Pricing</a></li>
  </ul>
  <a href="#booking" class="nav-cta"><span>Book Now</span></a>
  <div class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="#about" onclick="toggleMenu()">About</a>
  <a href="#services" onclick="toggleMenu()">Services</a>
  <a href="#barbers" onclick="toggleMenu()">Barbers</a>
  <a href="#gallery" onclick="toggleMenu()">Gallery</a>
  <a href="#pricing" onclick="toggleMenu()">Pricing</a>
  <a href="#booking" onclick="toggleMenu()" style="color:var(--gold);">Book Now</a>
</div>

<!-- HERO -->
<section id="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">
      <div class="eyebrow-line"></div>
      <span>Pekanbaru, Riau · Est. 2020</span>
    </div>
    <h1 class="hero-title">
      CUKURAN<br>
      <span class="gold">PRESISI.</span><br>
      GAYA SEJATI.
    </h1>
    <p class="hero-sub">AMS: Sentuhan Presisi, Gaya Sejati. Temukan pengalaman barbershop premium yang memadukan keahlian dan estetika tinggi.</p>
    <div class="hero-actions">
      <a href="#booking" class="btn-primary"><span>Reservasi Sekarang</span></a>
      <a href="#services" class="btn-ghost">Lihat Layanan</a>
    </div>
  </div>
  <div class="hero-stats">
    <div class="hero-stat">
      <span class="stat-num" data-count="1000">0</span>
      <span class="stat-label">Klien Puas</span>
    </div>
    <div class="hero-stat">
      <span class="stat-num">5★</span>
      <span class="stat-label">Rating Bintang</span>
    </div>
    <div class="hero-stat">
      <span class="stat-num" data-count="5">0</span>
      <span class="stat-label">Tahun Pengalaman</span>
    </div>
    <div class="hero-stat">
      <span class="stat-num" data-count="3">0</span>
      <span class="stat-label">Master Barber</span>
    </div>
  </div>
  <div class="scroll-hint">
    <div class="scroll-line"></div>
    <span>Scroll</span>
  </div>
</section>

<!-- ABOUT -->
<section id="about">
  <div class="about-image-wrap reveal-left">
    <img src="https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=800&q=80" alt="AMS Barbershop Interior">
    <div class="about-image-accent"></div>
    <div class="about-year">
      <small>Berdiri</small>
      2020
    </div>
  </div>
  <div class="reveal-right">
    <div class="section-eyebrow">
      <div class="eyebrow-line-sm"></div>
      <span>Tentang Kami</span>
    </div>
    <h2 class="section-title">Lebih dari<br>Sekadar<br><em>Cukuran</em></h2>
    <p class="section-sub">AMS Barbershop hadir sebagai ruang di mana ketepatan bertemu dengan gaya. Kami percaya setiap potongan rambut adalah sebuah karya — dipersembahkan dengan tangan terlatih dan jiwa penuh dedikasi.</p>
    <div class="about-features">
      <div class="about-feature">
        <div class="about-feature-icon">✂️</div>
        <h4>Presisi Tinggi</h4>
        <p>Setiap potongan dikerjakan dengan detail penuh dan konsistensi sempurna</p>
      </div>
      <div class="about-feature">
        <div class="about-feature-icon">🎯</div>
        <h4>Tepat Waktu</h4>
        <p>Sistem booking terstruktur agar waktu kamu selalu dihargai</p>
      </div>
      <div class="about-feature">
        <div class="about-feature-icon">💎</div>
        <h4>Produk Premium</h4>
        <p>Hanya menggunakan produk perawatan rambut berkualitas terbaik</p>
      </div>
      <div class="about-feature">
        <div class="about-feature-icon">🔥</div>
        <h4>Teknik Modern</h4>
        <p>Selalu mengikuti tren dan teknik terbaru dunia barbering</p>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="services-header reveal">
    <div>
      <div class="section-eyebrow">
        <div class="eyebrow-line-sm"></div>
        <span>Layanan Kami</span>
      </div>
      <h2 class="section-title">Pilih Layanan<br><em>Terbaik Anda</em></h2>
    </div>
    <p class="section-sub" style="text-align:right;max-width:320px;">Setiap layanan dirancang untuk memenuhi kebutuhan gaya pria modern yang mengutamakan kualitas.</p>
  </div>
  <div class="services-grid reveal">
    <div class="service-card">
      <img src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=600&q=80" alt="Classic Cut">
      <div class="service-info">
        <div class="service-num">01</div>
        <div class="service-tag">Signature Service</div>
        <div class="service-name">Classic Cut</div>
        <div class="service-desc">Potongan klasik dengan teknik presisi tinggi. Cocok untuk tampilan formal maupun kasual sehari-hari.</div>
        <div class="service-price">Rp 150K <small>/ sesi</small></div>
      </div>
    </div>
    <div class="service-card">
      <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=600&q=80" alt="Beard Sculpt">
      <div class="service-info">
        <div class="service-num">02</div>
        <div class="service-tag">Premium Service</div>
        <div class="service-name">Beard Sculpt</div>
        <div class="service-desc">Pembentukan jenggot dengan detail artistik. Dari clean shave hingga full beard styling.</div>
        <div class="service-price">Rp 75K <small>/ sesi</small></div>
      </div>
    </div>
    <div class="service-card">
      <img src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=600&q=80" alt="Hot Towel Shave">
      <div class="service-info">
        <div class="service-num">03</div>
        <div class="service-tag">Luxury Service</div>
        <div class="service-name">Hot Towel Shave</div>
        <div class="service-desc">Pengalaman cukur mewah dengan handuk panas dan produk perawatan premium untuk kulit halus sempurna.</div>
        <div class="service-price">Rp 100K <small>/ sesi</small></div>
      </div>
    </div>
  </div>
</section>

<!-- BARBERS -->
<section id="barbers">
  <div class="reveal">
    <div class="section-eyebrow">
      <div class="eyebrow-line-sm"></div>
      <span>Tim Kami</span>
    </div>
    <h2 class="section-title">Master<br><em>Barber Kami</em></h2>
  </div>
  <div class="barbers-grid">
    <div class="barber-card reveal" style="transition-delay:0.1s">
      <img class="barber-img" src="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=600&q=80" alt="Anuar">
      <div class="barber-overlay"></div>
      <div class="barber-info">
        <div class="barber-name">Anuar Silitonga</div>
        <div class="barber-title">Head Barber & Founder</div>
        <div class="barber-skills">
          <span class="skill-tag">Fade</span>
          <span class="skill-tag">Classic Cut</span>
          <span class="skill-tag">Beard Art</span>
        </div>
      </div>
    </div>
    <div class="barber-card reveal" style="transition-delay:0.2s">
      <img class="barber-img" src="https://images.unsplash.com/photo-1618077360395-f3068be8e001?w=600&q=80" alt="Maleakhi">
      <div class="barber-overlay"></div>
      <div class="barber-info">
        <div class="barber-name">Maleakhi</div>
        <div class="barber-title">Senior Barber</div>
        <div class="barber-skills">
          <span class="skill-tag">Skin Fade</span>
          <span class="skill-tag">Pompadour</span>
          <span class="skill-tag">Shave</span>
        </div>
      </div>
    </div>
    <div class="barber-card reveal" style="transition-delay:0.3s">
      <img class="barber-img" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80" alt="Reza">
      <div class="barber-overlay"></div>
      <div class="barber-info">
        <div class="barber-name">Reza Pratama</div>
        <div class="barber-title">Barber Specialist</div>
        <div class="barber-skills">
          <span class="skill-tag">Undercut</span>
          <span class="skill-tag">Textured</span>
          <span class="skill-tag">Color</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery">
  <div class="gallery-header reveal">
    <div class="section-eyebrow">
      <div class="eyebrow-line-sm"></div>
      <span>#FreshCut</span>
    </div>
    <h2 class="section-title">Karya-karya<br><em>Terbaik Kami</em></h2>
  </div>
  <div class="gallery-track-wrap">
    <div class="gallery-track" id="galleryTrack"></div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials">
  <div class="reveal">
    <div class="section-eyebrow">
      <div class="eyebrow-line-sm"></div>
      <span>Testimoni</span>
    </div>
    <h2 class="section-title">Kata Mereka<br><em>Tentang Kami</em></h2>
  </div>
  <div class="testimonials-slider">
    <div class="testimonials-track" id="testimonialTrack">
      <div class="testimonial-slide">
        <div class="testimonial-inner">
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">Sudah 2 tahun langganan di sini. Setiap potongan selalu rapi dan presisi. Bukan hanya tempat cukur, ini sudah jadi ritual wajib mingguan saya.</p>
          <div class="testimonial-author">
            <img class="author-img" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&q=80" alt="">
            <div>
              <div class="stars">★★★★★</div>
              <div class="author-name">Rizky Firmansyah</div>
              <div class="author-meta">Pelanggan Setia · Pekanbaru</div>
            </div>
          </div>
        </div>
      </div>
      <div class="testimonial-slide">
        <div class="testimonial-inner">
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">Hot towel shave-nya luar biasa. Kulit jadi halus, rileks, dan berasa dimanjakan. Ini bukan sekadar barbershop — ini pengalaman.</p>
          <div class="testimonial-author">
            <img class="author-img" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&q=80" alt="">
            <div>
              <div class="stars">★★★★★</div>
              <div class="author-name">Budi Santoso</div>
              <div class="author-meta">Profesional · Pekanbaru</div>
            </div>
          </div>
        </div>
      </div>
      <div class="testimonial-slide">
        <div class="testimonial-inner">
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">Barbernya ramah dan paham betul apa yang saya mau. Beard sculpt saya akhirnya ada yang bisa bikin rapi dengan gaya yang pas. Highly recommended!</p>
          <div class="testimonial-author">
            <img class="author-img" src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&q=80" alt="">
            <div>
              <div class="stars">★★★★★</div>
              <div class="author-name">Doni Pratama</div>
              <div class="author-meta">Entrepreneur · Pekanbaru</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-controls">
      <button class="slider-btn" onclick="prevSlide()">←</button>
      <div class="slider-dots" id="sliderDots"></div>
      <button class="slider-btn" onclick="nextSlide()">→</button>
    </div>
  </div>
</section>

<!-- PRICING -->
<section id="pricing">
  <div class="reveal" style="text-align:center;margin-bottom:0;">
    <div class="section-eyebrow" style="justify-content:center;">
      <div class="eyebrow-line-sm"></div>
      <span>Harga Layanan</span>
      <div class="eyebrow-line-sm"></div>
    </div>
    <h2 class="section-title" style="text-align:center;">Investasi untuk<br><em>Penampilanmu</em></h2>
  </div>
  <div class="pricing-grid reveal">
    <div class="pricing-card">
      <div class="pricing-icon">✂️</div>
      <div class="pricing-name">Classic Cut</div>
      <div class="pricing-price">150K</div>
      <div class="pricing-dur">~45 menit</div>
      <ul class="pricing-features">
        <li>Konsultasi gaya gratis</li>
        <li>Cuci rambut termasuk</li>
        <li>Finishing & styling</li>
        <li>Foto hasil (opsional)</li>
      </ul>
      <button class="btn-pricing" onclick="document.getElementById('booking').scrollIntoView({behavior:'smooth'})">Booking Sekarang</button>
    </div>
    <div class="pricing-card featured">
      <div class="pricing-badge">Terpopuler</div>
      <div class="pricing-icon">🔱</div>
      <div class="pricing-name">Full Package</div>
      <div class="pricing-price">280K</div>
      <div class="pricing-dur">~90 menit</div>
      <ul class="pricing-features">
        <li>Classic Cut</li>
        <li>Beard Sculpt</li>
        <li>Hot Towel Shave</li>
        <li>Premium hair product</li>
        <li>Pijat kepala 10 menit</li>
      </ul>
      <button class="btn-pricing" onclick="document.getElementById('booking').scrollIntoView({behavior:'smooth'})">Booking Sekarang</button>
    </div>
    <div class="pricing-card">
      <div class="pricing-icon">🔥</div>
      <div class="pricing-name">Beard & Shave</div>
      <div class="pricing-price">160K</div>
      <div class="pricing-dur">~60 menit</div>
      <ul class="pricing-features">
        <li>Beard sculpting detail</li>
        <li>Hot towel shave</li>
        <li>Aftershave balm</li>
        <li>Beard oil treatment</li>
      </ul>
      <button class="btn-pricing" onclick="document.getElementById('booking').scrollIntoView({behavior:'smooth'})">Booking Sekarang</button>
    </div>
  </div>
</section>

<!-- BOOKING -->
<section id="booking">
  <div class="booking-visual">
    <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?w=800&q=80" alt="Booking">
    <div class="booking-visual-overlay">
      <div class="section-eyebrow">
        <div class="eyebrow-line-sm"></div>
        <span>Jam Operasional</span>
      </div>
      <h2 style="font-family:'Bebas Neue',sans-serif;font-size:48px;letter-spacing:4px;margin:12px 0 8px;">SENIN – SABTU</h2>
      <p style="font-family:'Bebas Neue',sans-serif;font-size:64px;color:var(--gold);letter-spacing:4px;line-height:1;">09:00 – 20:00</p>
      <p style="font-size:13px;color:var(--text-muted);margin-top:16px;">Walk-in diterima · Reservasi diutamakan</p>
    </div>
  </div>
  <div class="booking-form-wrap">
    <div class="section-eyebrow">
      <div class="eyebrow-line-sm"></div>
      <span>Booking</span>
    </div>
    <h2 class="section-title" style="margin-bottom:32px;">Reservasi<br><em>Sekarang</em></h2>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" placeholder="Nama kamu">
      </div>
      <div class="form-group">
        <label class="form-label">Nomor WhatsApp</label>
        <input type="tel" class="form-control" placeholder="08xx xxxx xxxx">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Pilih Layanan</label>
      <select class="form-control">
        <option>Classic Cut — Rp 150.000</option>
        <option>Beard Sculpt — Rp 75.000</option>
        <option>Hot Towel Shave — Rp 100.000</option>
        <option>Full Package — Rp 280.000</option>
        <option>Beard & Shave — Rp 160.000</option>
      </select>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Pilih Barber</label>
        <select class="form-control">
          <option>Anuar Silitonga</option>
          <option>Maleakhi</option>
          <option>Reza Pratama</option>
          <option>Siapapun tersedia</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Jam</label>
        <select class="form-control">
          <option>09:00</option><option>10:00</option><option>11:00</option>
          <option>13:00</option><option>14:00</option><option>15:00</option>
          <option>16:00</option><option>17:00</option><option>18:00</option>
          <option>19:00</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Tanggal</label>
      <input type="date" class="form-control" id="bookDate">
    </div>
    <button class="btn-primary" style="width:100%;margin-top:8px;" onclick="handleBooking()">
      <span>Konfirmasi Reservasi via WhatsApp</span>
    </button>
    <p class="booking-note">* Konfirmasi akan dikirim ke WhatsApp kamu dalam 5 menit. Walk-in tetap diterima sesuai ketersediaan.</p>
  </div>
</section>

<!-- CONTACT -->
<section id="contact">
  <div class="contact-inner reveal">
    <div class="contact-item">
      <div class="contact-icon">📍</div>
      <div class="contact-label">Lokasi</div>
      <div class="contact-value">Pekanbaru, Riau</div>
      <div class="contact-meta">Jl. Contoh No. 12, Tampan</div>
    </div>
    <div class="contact-item">
      <div class="contact-icon">📞</div>
      <div class="contact-label">WhatsApp</div>
      <div class="contact-value">+62 812 3456 7890</div>
      <div class="contact-meta">Respon cepat · setiap hari</div>
    </div>
    <div class="contact-item">
      <div class="contact-icon">📸</div>
      <div class="contact-label">Instagram</div>
      <div class="contact-value">@ams.barbershop</div>
      <div class="contact-meta">#FreshCut #AMSBarber</div>
    </div>
    <div class="contact-item">
      <div class="contact-icon">🕐</div>
      <div class="contact-label">Jam Buka</div>
      <div class="contact-value">Senin – Sabtu</div>
      <div class="contact-meta">09:00 – 20:00 WIB</div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-logo">AMS</div>
      <div class="footer-sub">Sentuhan Presisi, Gaya Sejati</div>
    </div>
    <div class="footer-links">
      <a href="#about">About</a>
      <a href="#services">Services</a>
      <a href="#barbers">Barbers</a>
      <a href="#gallery">Gallery</a>
      <a href="#booking">Booking</a>
    </div>
  </div>
  <div class="footer-copy">© 2025 AMS Barbershop — Anuar Maleakhi Silitonga. All rights reserved.</div>
</footer>

<!-- FLOAT CTA -->
<div class="float-cta" id="floatCta">
  <a class="float-wa" href="https://wa.me/6281234567890" target="_blank" title="WhatsApp">💬</a>
  <button class="float-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Back to top">↑</button>
</div>

<script>
// ====== LOADER ======
window.addEventListener('load', () => {
  setTimeout(() => {
    document.getElementById('loader').classList.add('hidden');
  }, 2200);
});

// ====== CURSOR ======
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mx = 0, my = 0, rx = 0, ry = 0;
document.addEventListener('mousemove', e => {
  mx = e.clientX; my = e.clientY;
  cursor.style.left = mx - 4 + 'px';
  cursor.style.top = my - 4 + 'px';
});
function animRing() {
  rx += (mx - rx) * 0.12;
  ry += (my - ry) * 0.12;
  ring.style.left = rx - 18 + 'px';
  ring.style.top = ry - 18 + 'px';
  requestAnimationFrame(animRing);
}
animRing();
document.querySelectorAll('a,button,.service-card,.barber-card,.pricing-card').forEach(el => {
  el.addEventListener('mouseenter', () => { ring.style.transform = 'scale(1.6)'; ring.style.opacity = '0.5'; });
  el.addEventListener('mouseleave', () => { ring.style.transform = 'scale(1)'; ring.style.opacity = '1'; });
});

// ====== NAV SCROLL ======
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 60);
  document.getElementById('floatCta').classList.toggle('show', window.scrollY > 400);
});

// ====== MOBILE MENU ======
function toggleMenu() {
  const h = document.getElementById('hamburger');
  const m = document.getElementById('mobileMenu');
  h.classList.toggle('open');
  m.classList.toggle('open');
}

// ====== REVEAL ON SCROLL ======
const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
const revealObs = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('visible'), i * 80);
    }
  });
}, { threshold: 0.12 });
reveals.forEach(el => revealObs.observe(el));

// ====== COUNT UP ======
const counters = document.querySelectorAll('[data-count]');
const countObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      const target = +e.target.dataset.count;
      const suffix = target >= 1000 ? '+' : '';
      let current = 0;
      const step = target / 60;
      const timer = setInterval(() => {
        current = Math.min(current + step, target);
        e.target.textContent = Math.floor(current).toLocaleString('id-ID') + suffix;
        if (current >= target) clearInterval(timer);
      }, 25);
      countObs.unobserve(e.target);
    }
  });
}, { threshold: 0.5 });
counters.forEach(el => countObs.observe(el));

// ====== GALLERY ======
const galleryImages = [
  { url: 'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=600&q=80', label: 'Classic Cut' },
  { url: 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=600&q=80', label: 'Beard Sculpt' },
  { url: 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=600&q=80', label: 'Hot Towel Shave' },
  { url: 'https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=600&q=80', label: 'Barbershop' },
  { url: 'https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=600&q=80', label: 'Fade Cut' },
  { url: 'https://images.unsplash.com/photo-1618077360395-f3068be8e001?w=600&q=80', label: 'Premium Style' },
];
const track = document.getElementById('galleryTrack');
[...galleryImages, ...galleryImages].forEach(img => {
  track.innerHTML += `
    <div class="gallery-item">
      <img src="${img.url}" alt="${img.label}" loading="lazy">
      <div class="gallery-item-label">${img.label}</div>
    </div>`;
});

// ====== TESTIMONIAL SLIDER ======
let slideIndex = 0;
const slides = document.querySelectorAll('.testimonial-slide');
const dotsEl = document.getElementById('sliderDots');
slides.forEach((_, i) => {
  dotsEl.innerHTML += `<div class="dot ${i===0?'active':''}" onclick="goSlide(${i})"></div>`;
});
function updateSlider() {
  document.getElementById('testimonialTrack').style.transform = `translateX(-${slideIndex * 100}%)`;
  document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === slideIndex));
}
function nextSlide() { slideIndex = (slideIndex + 1) % slides.length; updateSlider(); }
function prevSlide() { slideIndex = (slideIndex - 1 + slides.length) % slides.length; updateSlider(); }
function goSlide(i) { slideIndex = i; updateSlider(); }
setInterval(nextSlide, 5000);

// ====== BOOKING DATE DEFAULT ======
const today = new Date();
document.getElementById('bookDate').value = today.toISOString().split('T')[0];
document.getElementById('bookDate').min = today.toISOString().split('T')[0];

// ====== BOOKING HANDLER ======
function handleBooking() {
  const nama = document.querySelector('.booking-form-wrap input[type=text]').value;
  const wa = document.querySelector('.booking-form-wrap input[type=tel]').value;
  const layanan = document.querySelector('.booking-form-wrap select').value;
  if (!nama || !wa) {
    alert('Mohon isi nama dan nomor WhatsApp terlebih dahulu.');
    return;
  }
  const msg = encodeURIComponent(`Halo AMS Barbershop! Saya ingin reservasi.\n\nNama: ${nama}\nLayanan: ${layanan}\nNo. WA: ${wa}\n\nTerima kasih!`);
  window.open(`https://wa.me/6281234567890?text=${msg}`, '_blank');
}

// ====== PARALLAX HERO ======
window.addEventListener('scroll', () => {
  const hero = document.querySelector('.hero-bg');
  if (hero) hero.style.transform = `scale(1.05) translateY(${window.scrollY * 0.25}px)`;
});
</script>
</body>
</html>
