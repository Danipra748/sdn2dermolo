@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'SD N 2 Dermolo - Sekolah Dasar Negeri 2 Dermolo')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary:   #1a56db;
        --primary-light: #3b82f6;
        --accent:    #f59e0b;
        --accent-2:  #10b981;
        --dark:      #0f172a;
        --dark-2:    #1e293b;
        --surface:   #f8fafc;
        --text:      #334155;
        --text-muted:#64748b;
        --border:    #e2e8f0;
        --radius:    1.25rem;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
        --shadow:    0 10px 40px rgba(0,0,0,.10);
        --shadow-lg: 0 25px 60px rgba(0,0,0,.15);
        /* Hero background image (ubah ke url('path-gambar')) */
        --hero-bg-image: none;
        --hero-bg-position: center;
        --hero-bg-size: cover;
        --hero-bg-opacity: 0.35;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text);
        background: var(--surface);
        overflow-x: hidden;
    }

    /* ── TYPOGRAPHY ── */
    .font-display { font-family: 'Fraunces', serif; }

    /* ── SCROLL REVEAL ── */
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1);
    }
    .reveal.visible { opacity: 1; transform: none; }
    .reveal-delay-1 { transition-delay: .1s; }
    .reveal-delay-2 { transition-delay: .2s; }
    .reveal-delay-3 { transition-delay: .3s; }
    .reveal-delay-4 { transition-delay: .4s; }

    /* ── HERO ── */
    .hero {
        min-height: 100vh;
        background: var(--dark);
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        isolation: isolate;
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: var(--hero-bg-image);
        background-position: var(--hero-bg-position);
        background-size: var(--hero-bg-size);
        background-repeat: no-repeat;
        opacity: var(--hero-bg-opacity);
        z-index: 1;
        pointer-events: none;
    }

    /* Animated mesh gradient */
    .hero-mesh {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 20% 50%, rgba(26,86,219,.45) 0%, transparent 60%),
            radial-gradient(ellipse 60% 80% at 80% 20%, rgba(16,185,129,.25) 0%, transparent 55%),
            radial-gradient(ellipse 50% 50% at 60% 80%, rgba(245,158,11,.20) 0%, transparent 55%);
        animation: meshShift 12s ease-in-out infinite alternate;
        z-index: 2;
        pointer-events: none;
    }
    @keyframes meshShift {
        0%   { filter: hue-rotate(0deg) brightness(1); }
        100% { filter: hue-rotate(20deg) brightness(1.1); }
    }

    /* Floating orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: .35;
        animation: orbFloat 8s ease-in-out infinite;
        z-index: 3;
        pointer-events: none;
    }
    .orb-1 { width: 500px; height: 500px; background: #1a56db; top: -100px; left: -100px; animation-delay: 0s; }
    .orb-2 { width: 400px; height: 400px; background: #10b981; bottom: -80px; right: -80px; animation-delay: -3s; }
    .orb-3 { width: 300px; height: 300px; background: #f59e0b; top: 40%; left: 40%; animation-delay: -6s; }
    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%       { transform: translate(30px, -30px) scale(1.08); }
    }

    /* Grid overlay */
    .hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
        background-size: 60px 60px;
        z-index: 4;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 5;
        width: 100%;
        padding: 8rem 1.5rem 6rem;
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(255,255,255,.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.2);
        color: #fff;
        padding: .5rem 1.25rem;
        border-radius: 999px;
        font-size: .85rem;
        font-weight: 600;
        letter-spacing: .04em;
        margin-bottom: 2rem;
        animation: badgePulse 3s ease-in-out infinite;
    }
    @keyframes badgePulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245,158,11,.4); }
        50%       { box-shadow: 0 0 0 12px rgba(245,158,11,0); }
    }

    .hero-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(3rem, 8vw, 6rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.05;
        letter-spacing: -.02em;
        margin-bottom: 1.5rem;
    }
    .hero-title span {
        background: linear-gradient(135deg, #f59e0b, #fcd34d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-sub {
        font-size: clamp(1rem, 2vw, 1.25rem);
        color: rgba(255,255,255,.7);
        max-width: 600px;
        margin: 0 auto 3rem;
        line-height: 1.7;
    }

    .hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent), #f97316);
        color: #fff;
        font-weight: 700;
        padding: .9rem 2.2rem;
        border-radius: 999px;
        text-decoration: none;
        font-size: 1rem;
        transition: all .3s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 8px 30px rgba(245,158,11,.4);
        display: inline-flex;
        align-items: center;
        gap: .5rem;
    }
    .btn-primary:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 16px 40px rgba(245,158,11,.5);
    }

    .btn-ghost {
        background: rgba(255,255,255,.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff;
        font-weight: 600;
        padding: .9rem 2.2rem;
        border-radius: 999px;
        text-decoration: none;
        font-size: 1rem;
        transition: all .3s ease;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
    }
    .btn-ghost:hover {
        background: rgba(255,255,255,.2);
        transform: translateY(-3px);
    }

    /* ── SECTION WRAPPER ── */
    .section { padding: 6rem 1.5rem; }
    .section-inner { max-width: 1200px; margin: 0 auto; }

    .section-label {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--primary);
        background: rgba(26,86,219,.08);
        padding: .4rem 1rem;
        border-radius: 999px;
        margin-bottom: 1rem;
    }
    .section-title {
        font-family: 'Fraunces', serif;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 900;
        color: var(--dark);
        line-height: 1.15;
        letter-spacing: -.02em;
    }
    .section-desc {
        color: var(--text-muted);
        font-size: 1.05rem;
        line-height: 1.7;
        max-width: 560px;
    }

    /* ── INFO CARDS ── */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: -5rem;
        position: relative;
        z-index: 20;
        padding: 0 1.5rem;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .info-card {
        background: #fff;
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        transition: all .4s cubic-bezier(.34,1.56,.64,1);
        position: relative;
        overflow: hidden;
    }
    .info-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .4s ease;
    }
    .info-card:hover::before { transform: scaleX(1); }
    .info-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }
    .info-card:nth-child(2)::before { background: linear-gradient(90deg, var(--accent-2), #34d399); }
    .info-card:nth-child(3)::before { background: linear-gradient(90deg, var(--accent), #fcd34d); }

    .info-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .info-icon-blue   { background: rgba(26,86,219,.1); }
    .info-icon-green  { background: rgba(16,185,129,.1); }
    .info-icon-yellow { background: rgba(245,158,11,.1); }

    .info-card h3 {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--dark);
        margin-bottom: .5rem;
    }
    .info-card p { color: var(--text-muted); font-size: .95rem; line-height: 1.6; }

    /* ── TENTANG ── */
    .tentang-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: center;
    }
    @media (max-width: 768px) {
        .tentang-grid { grid-template-columns: 1fr; gap: 3rem; }
    }

    .tentang-visual {
        position: relative;
    }
    .tentang-visual-main {
        background: linear-gradient(135deg, var(--primary), #1e40af);
        border-radius: 2rem;
        aspect-ratio: 4/3;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .tentang-visual-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        position: relative;
        z-index: 1;
    }
    .tentang-visual-main::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 30% 70%, rgba(16,185,129,.3), transparent 50%),
            radial-gradient(circle at 70% 30%, rgba(245,158,11,.2), transparent 50%);
    }
    .tentang-visual-badge {
        position: absolute;
        bottom: -1.5rem;
        right: -1.5rem;
        background: #fff;
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: .75rem;
        border: 1px solid var(--border);
        z-index: 2;
    }
    .tentang-visual-badge-icon { font-size: 2rem; }
    .tentang-visual-badge-text { font-weight: 800; font-size: 1.5rem; color: var(--dark); line-height: 1; }
    .tentang-visual-badge-sub  { font-size: .75rem; color: var(--text-muted); margin-top: .15rem; }

    .visi-misi {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    @media (max-width: 768px) {
        .visi-misi { grid-template-columns: 1fr; }
    }
    .visi-misi-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        padding: 1.25rem;
        background: var(--surface);
        border-radius: 1rem;
        border: 1px solid var(--border);
        transition: all .3s ease;
    }
    .visi-misi-item:hover {
        border-color: var(--primary);
        background: rgba(26,86,219,.03);
        transform: translateX(6px);
    }
    .visi-misi-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #fff;
        font-size: .9rem;
        font-weight: 700;
    }

    /* ── PROGRAM ── */
    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }

    /* Program Sekolah: 3 card sama besar sejajar */
    .program-grid-extras {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    .program-card-extras {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .program-card-extras .program-card-header {
        height: 180px;
    }
    .program-card-extras .program-card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: .5rem;
        flex: 1 1 auto;
    }
    .program-card-extras .program-card-body p {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .program-card {
        background: #fff;
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all .4s cubic-bezier(.34,1.56,.64,1);
        cursor: pointer;
        text-decoration: none;
        display: block;
    }
    .program-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }
    .program-card-header {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        position: relative;
        overflow: hidden;
    }
    .program-card-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,.15));
    }
    .program-card-body { padding: 1.5rem; }
    .program-card-body h3 {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--dark);
        margin-bottom: .5rem;
    }
    .program-card-body p { color: var(--text-muted); font-size: .9rem; line-height: 1.6; }

    /* Prestasi: foto fill di header card */
    .prestasi-card .program-card-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ——— NEWS ——— */
    .news-home-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 2.5rem;
    }
    .news-home-card {
        background: #fff;
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all .4s cubic-bezier(.34,1.56,.64,1);
        text-decoration: none;
        display: block;
    }
    .news-home-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }
    .news-home-thumb {
        height: 180px;
        background: #e2e8f0;
    }
    .news-home-chip {
        background: rgba(26,86,219,.08);
        color: #1a56db;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
    }

    /* ── GURU ── */
    .guru-section { background: var(--dark); }

    .kepsek-card {
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 1.5rem;
        padding: 2.5rem;
        display: flex;
        align-items: center;
        gap: 2.5rem;
        max-width: 700px;
        margin: 3rem auto 4rem;
        backdrop-filter: blur(10px);
        transition: all .4s ease;
    }
    .kepsek-card:hover {
        background: rgba(255,255,255,.08);
        border-color: rgba(245,158,11,.4);
        box-shadow: 0 0 40px rgba(245,158,11,.1);
    }
    @media (max-width: 600px) {
        .kepsek-card { flex-direction: column; text-align: center; }
    }
    .kepsek-avatar {
        width: 7rem;
        height: 7rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 2.5rem;
        border: 3px solid rgba(255,255,255,.2);
    }
    .kepsek-name  { font-family: 'Fraunces', serif; font-size: 1.4rem; font-weight: 700; color: #fff; }
    .kepsek-role  { color: var(--accent); font-weight: 600; font-size: .9rem; margin: .3rem 0; }
    .kepsek-nip   { color: rgba(255,255,255,.4); font-size: .8rem; }
    .kepsek-badges { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .75rem; }
    .kepsek-badge {
        background: rgba(245,158,11,.15);
        border: 1px solid rgba(245,158,11,.3);
        color: #fcd34d;
        padding: .3rem .85rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 600;
    }

    .guru-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    .guru-card {
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 1.25rem;
        padding: 1.75rem 1.5rem;
        text-align: center;
        transition: all .4s cubic-bezier(.34,1.56,.64,1);
    }
    .guru-card:hover {
        background: rgba(255,255,255,.08);
        border-color: rgba(255,255,255,.2);
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,.3);
    }
    .guru-avatar {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 1rem;
        border: 2px solid rgba(255,255,255,.15);
    }
    .guru-name   { font-weight: 700; color: #fff; font-size: .95rem; margin-bottom: .3rem; }
    .guru-jabatan{ font-size: .8rem; font-weight: 600; margin-bottom: .25rem; }
    .guru-nip    { font-size: .72rem; color: rgba(255,255,255,.35); margin-bottom: .75rem; }
    .guru-badges { display: flex; flex-wrap: wrap; gap: .35rem; justify-content: center; }
    .guru-badge  {
        padding: .25rem .7rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 600;
    }

    /* ── FASILITAS ── */
    .fasilitas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }

    .fasilitas-card {
        background: #fff;
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--border);
        text-decoration: none;
        display: block;
        transition: all .4s cubic-bezier(.34,1.56,.64,1);
        group: true;
        position: relative;
    }
    .fasilitas-card::after {
        content: 'Lihat Detail →';
        position: absolute;
        bottom: 1.5rem;
        right: 1.5rem;
        font-size: .8rem;
        font-weight: 700;
        opacity: 0;
        transform: translateX(-8px);
        transition: all .3s ease;
    }
    .fasilitas-card:hover::after {
        opacity: 1;
        transform: translateX(0);
    }
    .fasilitas-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }
    .fasilitas-card-top {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        position: relative;
        overflow: hidden;
    }
    .fasilitas-card-body { padding: 1.5rem; padding-bottom: 3rem; }
    .fasilitas-card-body h3 {
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--dark);
        margin-bottom: .4rem;
    }
    .fasilitas-card-body p {
        color: var(--text-muted);
        font-size: .88rem;
        line-height: 1.6;
    }
    .fasilitas-card-arrow {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .82rem;
        font-weight: 700;
        margin-top: .75rem;
        transition: gap .3s ease;
    }
    .fasilitas-card:hover .fasilitas-card-arrow { gap: .75rem; }

    /* ── KONTAK ── */
    .kontak-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-top: 3rem;
    }
    .kontak-card {
        background: #fff;
        border-radius: 1.25rem;
        padding: 1.5rem;
        text-align: left;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        position: relative;
        overflow: hidden;
        transition: all .35s ease;
    }
    .kontak-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(26,86,219,.06), rgba(59,130,246,.06));
        opacity: 0;
        transition: opacity .35s ease;
    }
    .kontak-card-blue::before   { background: linear-gradient(135deg, rgba(26,86,219,.04), rgba(59,130,246,.04)); }
    .kontak-card-green::before  { background: linear-gradient(135deg, rgba(16,185,129,.04), rgba(52,211,153,.04)); }
    .kontak-card-purple::before { background: linear-gradient(135deg, rgba(124,58,237,.04), rgba(167,139,250,.04)); }
    .kontak-card:hover::before  { opacity: 1; }
    .kontak-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
        border-color: transparent;
    }
    .kontak-icon {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin: 0 0 1rem;
        border: 1px solid rgba(15, 23, 42, 0.08);
    }
    .kontak-card h3 { font-weight: 800; font-size: 1.05rem; color: var(--dark); margin-bottom: .4rem; }
    .kontak-card p  { color: var(--text-muted); font-size: .9rem; line-height: 1.7; }
    .kontak-meta {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: .5rem;
    }
    .kontak-body {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: .9rem;
        padding: 1rem;
    }
    .kontak-extra {
        margin-top: 2.5rem;
        display: grid;
        grid-template-columns: 1.3fr 0.7fr;
        gap: 1.5rem;
        align-items: stretch;
    }
    .kontak-map {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        min-height: 320px;
    }
    .kontak-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }
    .kontak-form {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .kontak-form h3 {
        font-weight: 800;
        font-size: 1.2rem;
        color: var(--dark);
    }
    .kontak-form p {
        color: var(--text-muted);
        font-size: .92rem;
        line-height: 1.6;
    }
    .kontak-field {
        display: flex;
        flex-direction: column;
        gap: .4rem;
    }
    .kontak-field label {
        font-weight: 700;
        font-size: .85rem;
        color: var(--dark);
    }
    .kontak-field input,
    .kontak-field textarea {
        border: 1px solid var(--border);
        border-radius: .9rem;
        padding: .75rem .9rem;
        font-size: .9rem;
        color: var(--text);
        background: #f8fafc;
        transition: border .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .kontak-field input:focus,
    .kontak-field textarea:focus {
        outline: none;
        border-color: rgba(26,86,219,.5);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26,86,219,.12);
    }
    .kontak-field textarea {
        min-height: 140px;
        resize: vertical;
    }
    .kontak-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .6rem;
        padding: .75rem 1rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: #fff;
        font-weight: 700;
        font-size: .9rem;
        border: none;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 10px 25px rgba(26,86,219,.25);
    }
    .kontak-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(26,86,219,.3);
    }

    /* ── RESPONSIVE FIXES ── */
    @media (max-width: 640px) {
        .hero-title  { font-size: 2.5rem; }
        .section     { padding: 4rem 1.25rem; }
        .info-grid   { padding: 0 1.25rem; }
        .program-grid, .fasilitas-grid, .kontak-grid, .kontak-extra { grid-template-columns: 1fr; }
        .program-grid.program-grid-extras { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }

    /* ── CUSTOM SCROLLBAR ── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 999px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section id="home" class="hero">
    <div class="hero-mesh"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="hero-grid"></div>

    <div class="hero-content">
        <div class="hero-badge reveal">
            <span>⭐</span> Selamat Datang di SD N 2 Dermolo
        </div>
        <h1 class="hero-title reveal reveal-delay-1">
            Sekolah yang<br>
            <span>Membentuk</span><br>
            Generasi Unggul
        </h1>
        <p class="hero-sub reveal reveal-delay-2">
            Membangun siswa yang cerdas, berkarakter, dan berprestasi melalui
            kurikulum merdeka dan lingkungan belajar yang inspiratif.
        </p>
        <div class="hero-buttons reveal reveal-delay-3">
            <a href="#tentang" class="btn-primary">
                📖 Tentang Kami
            </a>
            <a href="#kontak" class="btn-ghost">
                📞 Hubungi Kami
            </a>
        </div>
    </div>

</section>

{{-- ===== INFO CARDS ===== --}}
<div class="info-grid" style="padding-top: 2rem; margin-top: 0; padding-bottom: 2rem;">
    <div class="info-card reveal">
        <div class="info-icon info-icon-blue">📚</div>
        <h3>Kurikulum Merdeka</h3>
        <p>Menerapkan kurikulum terkini yang mengembangkan potensi siswa secara optimal dan holistik.</p>
    </div>
    <div class="info-card reveal reveal-delay-1">
        <div class="info-icon info-icon-green">👨‍🏫</div>
        <h3>Guru Berkualitas</h3>
        <p>Tenaga pendidik profesional dan berpengalaman yang berdedikasi membimbing setiap siswa.</p>
    </div>
    <div class="info-card reveal reveal-delay-2">
        <div class="info-icon info-icon-yellow">🏆</div>
        <h3>Prestasi Gemilang</h3>
        <p>Berbagai prestasi akademik dan non-akademik tingkat kabupaten hingga nasional.</p>
    </div>
</div>

{{-- ===== TENTANG KAMI ===== --}}
<section id="tentang" class="section" style="background: #fff;">
    <div class="section-inner">
        <div class="tentang-grid">
            {{-- Visual Kiri --}}
            <div class="tentang-visual reveal">
                <div class="tentang-visual-main">
                    @if (!empty($sambutanFoto))
                        <img src="{{ asset('storage/' . $sambutanFoto) }}" alt="Foto Kepala Sekolah">
                    @else
                        <svg width="180" height="180" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width=".8" xmlns="http://www.w3.org/2000/svg" style="position:relative;z-index:1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    @endif
                </div>
                <div class="tentang-visual-badge">
                    <div class="tentang-visual-badge-icon">🏫</div>
                    <div>
                        <div class="tentang-visual-badge-text">2009</div>
                        <div class="tentang-visual-badge-sub">Tahun Berdiri</div>
                    </div>
                </div>
            </div>

            {{-- Konten Kanan --}}
            <div class="reveal reveal-delay-1">
                <div class="section-label">🏫 Tentang Kami</div>
                <h2 class="section-title" style="margin-bottom: 1.25rem;">
                    Mendidik dengan<br>Hati & Dedikasi
                </h2>
                @php
                    $paragraphs = collect(preg_split('/\r\n|\r|\n/', $sambutanText ?? ''))
                        ->map(fn ($line) => trim($line))
                        ->filter()
                        ->values();
                @endphp
                @foreach ($paragraphs as $index => $paragraph)
                    <p class="section-desc" @if ($index === 0) style="margin-bottom: 1rem;" @endif>
                        {{ $paragraph }}
                    </p>
                @endforeach

            </div>
        </div>
        <div class="visi-misi reveal" style="margin-top: 2.5rem;">
            <div class="visi-misi-item">
                <div class="visi-misi-icon">V</div>
                <div>
                    <div style="font-weight:700; color:var(--dark); margin-bottom:.25rem;">Visi</div>
                    <div style="color:var(--text-muted); font-size:.92rem;">Mewujudkan siswa yang cerdas, berakhlak mulia, dan berprestasi tinggi.</div>
                </div>
            </div>
            <div class="visi-misi-item">
                <div class="visi-misi-icon">M</div>
                <div>
                    <div style="font-weight:700; color:var(--dark); margin-bottom:.25rem;">Misi</div>
                    <div style="color:var(--text-muted); font-size:.92rem;">Memberikan pendidikan berkualitas dengan pendekatan inovatif dan berbasis karakter.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== PROGRAM SEKOLAH ===== --}}
<section id="program" class="section" style="background: var(--surface);">
    <div class="section-inner">
        <div class="text-center reveal" style="margin-bottom: 1rem;">
            <div class="section-label" style="justify-content:center;">PROGRAM KAMI</div>
            <h2 class="section-title">Program Sekolah</h2>
            <p class="section-desc" style="margin: 1rem auto 0;">
                Tiga program unggulan yang aktif mendukung pengembangan bakat siswa.
            </p>
        </div>
        @php
        $programData = [
            'blue'   => ['gradient' => 'linear-gradient(135deg,#1a56db,#3b82f6)'],
            'green'  => ['gradient' => 'linear-gradient(135deg,#059669,#34d399)'],
            'yellow' => ['gradient' => 'linear-gradient(135deg,#d97706,#fbbf24)'],
        ];
        @endphp

        <div class="program-grid program-grid-extras">
            @foreach($program as $i => $item)
            @php $pd = $programData[$item['color']]; @endphp
            <a href="{{ route($item['route']) }}" class="program-card program-card-extras reveal" style="transition-delay: {{ $i * 0.08 }}s;">
                @php
                    $programBg = !empty($item['card_bg_image'])
                        ? "background-image: url('" . asset('storage/' . $item['card_bg_image']) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                        : (!empty($item['foto'])
                            ? "background-image: url('" . asset('storage/' . $item['foto']) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                            : '');
                @endphp
                <div class="program-card-header" style="background: {{ $pd['gradient'] }}; {{ $programBg }}">
                </div>
                <div class="program-card-body">
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['desc'] }}</p>
                    <div style="margin-top:.85rem; color:#1a56db; font-size:.82rem; font-weight:700;">
                        Lihat Dokumentasi <span>-></span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</section>

{{-- ===== BERITA ===== --}}
<section id="berita" class="section" style="background: #fff;">
    <div class="section-inner">
        <div class="text-center reveal">
            <div class="section-label" style="justify-content:center;">BERITA</div>
            <h2 class="section-title">Berita Terbaru</h2>
            <p class="section-desc" style="margin: 1rem auto 0;">
                Informasi kegiatan dan cerita terbaru dari SD N 2 Dermolo.
            </p>
        </div>
        <div class="news-home-grid">
            @forelse($berita as $i => $item)
                <a href="{{ route('news.show', $item) }}" class="news-home-card reveal" style="transition-delay: {{ $i * 0.08 }}s;">
                    <div class="news-home-thumb">
                        @if ($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span class="news-home-chip">{{ $item->category?->name ?? 'Umum' }}</span>
                            <span>{{ optional($item->published_at)->format('d M Y') }}</span>
                        </div>
                        <h3 class="mt-3 font-semibold text-slate-900">{{ $item->title }}</h3>
                        <p class="text-sm text-slate-500 mt-2">{{ $item->summary ?? Str::limit(strip_tags($item->content), 110) }}</p>
                    </div>
            </div>
            @empty
                <div class="news-home-card reveal">
                    <div class="news-home-thumb flex items-center justify-center text-slate-500 text-sm">
                        Belum ada berita terbaru.
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-slate-900">Belum Ada Berita</h3>
                        <p class="text-sm text-slate-500 mt-2">Tambah berita di panel admin agar tampil di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="text-center reveal" style="margin-top: 2rem;">
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                Lihat Semua Berita <span>-></span>
            </a>
        </div>
    </div>
</section>

{{-- ===== PRESTASI ===== --}}
<section id="prestasi" class="section" style="background: #fff;">
    <div class="section-inner">
        <div class="text-center reveal">
            <div class="section-label" style="justify-content:center;">PRESTASI</div>
            <h2 class="section-title">Prestasi Sekolah</h2>
            <p class="section-desc" style="margin: 1rem auto 0;">
                Dokumentasi capaian akademik dan non-akademik sekolah.
            </p>
        </div>
        <div class="program-grid" style="margin-top:2rem;">
            @forelse($prestasi as $i => $item)
                <div class="program-card prestasi-card reveal" style="transition-delay: {{ $i * 0.08 }}s;">
                    <div class="program-card-header" style="background: linear-gradient(135deg,#7c3aed,#a78bfa);">
                        @if (!empty($item['foto']))
                            <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['judul'] }}">
                        @else
                            <span style="position:relative;z-index:2;filter:drop-shadow(0 4px 8px rgba(0,0,0,.2));">
                                {{ strtoupper(substr($item['judul'] ?? 'P', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <div class="program-card-body">
                        <h3>{{ $item['judul'] }}</h3>
                        @if (!empty($item['deskripsi']))
                            <p>{{ $item['deskripsi'] }}</p>
                        @else
                            <p>Dokumentasi prestasi siswa dan sekolah.</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="program-card prestasi-card reveal">
                    <div class="program-card-header" style="background: linear-gradient(135deg,#7c3aed,#a78bfa);">
                        <span style="position:relative;z-index:2;filter:drop-shadow(0 4px 8px rgba(0,0,0,.2));">A</span>
                    </div>
                    <div class="program-card-body">
                        <h3>Belum Ada Prestasi</h3>
                        <p>Tambahkan data prestasi di panel admin agar tampil di sini.</p>
                    </div>
                </div>
            @endforelse

            
        </div>
        <div class="text-center reveal" style="margin-top: 2rem;">
            <a href="{{ route('prestasi.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
                Lihat Selengkapnya <span>-></span>
            </a>
        </div>
    </div>
</section>

{{-- ===== GURU & TENAGA PENDIDIK ===== --}}
<section id="guru" class="section guru-section">
    <div class="section-inner">
        <div class="text-center reveal">
            <div class="section-label" style="justify-content:center; background:rgba(245,158,11,.15); color:#fbbf24;">
                👨‍🏫 Tim Pendidik
            </div>
            <h2 class="section-title" style="color:#fff;">Guru & Tenaga Pendidik</h2>
            <p class="section-desc" style="color:rgba(255,255,255,.5); margin: 1rem auto 0;">
                Profesional berdedikasi yang siap membimbing putra-putri Anda
            </p>
        </div>
        {{-- Kepala Sekolah --}}
        @if ($kepsek)
        <div class="kepsek-card reveal">
            <div class="kepsek-avatar">
                @if ($kepsek->photo)
                    <img src="{{ asset('storage/' . $kepsek->photo) }}" alt="{{ $kepsek->nama }}"
                         class="w-full h-full rounded-full object-cover object-center">
                @else
                    👤
                @endif
            </div>
            <div>
                <div class="kepsek-name">{{ $kepsek->nama }}</div>
                <div class="kepsek-role">⭐ {{ $kepsek->jabatan }}</div>
                <div class="kepsek-nip">NIP: {{ $kepsek->nip }}</div>
                <div class="kepsek-badges">
                    @if ($kepsek->ijazah)
                        <span class="kepsek-badge">{{ $kepsek->ijazah }}</span>
                    @endif
                    @if ($kepsek->gol)
                        <span class="kepsek-badge">{{ $kepsek->gol }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Guru Kelas --}}
        <h3 style="color:rgba(255,255,255,.6); font-size:.8rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; text-align:center; margin-bottom: 1.5rem;" class="reveal">
            Guru Kelas
        </h3>

        @php
        $guruColors = [
            ['avatar' => 'linear-gradient(135deg,#1a56db,#3b82f6)', 'jabatan' => '#60a5fa', 'badge_bg' => 'rgba(59,130,246,.15)', 'badge_color' => '#93c5fd'],
            ['avatar' => 'linear-gradient(135deg,#059669,#34d399)', 'jabatan' => '#34d399', 'badge_bg' => 'rgba(16,185,129,.15)', 'badge_color' => '#6ee7b7'],
            ['avatar' => 'linear-gradient(135deg,#d97706,#fbbf24)', 'jabatan' => '#fbbf24', 'badge_bg' => 'rgba(245,158,11,.15)', 'badge_color' => '#fcd34d'],
            ['avatar' => 'linear-gradient(135deg,#7c3aed,#a78bfa)', 'jabatan' => '#a78bfa', 'badge_bg' => 'rgba(124,58,237,.15)', 'badge_color' => '#c4b5fd'],
            ['avatar' => 'linear-gradient(135deg,#dc2626,#f87171)', 'jabatan' => '#f87171', 'badge_bg' => 'rgba(220,38,38,.15)', 'badge_color' => '#fca5a5'],
        ];
        @endphp

        <div class="guru-grid">
            @foreach($guruLain->take(6) as $i => $g)
            @php $gc = $guruColors[$i % count($guruColors)]; @endphp
            <div class="guru-card reveal" style="transition-delay: {{ $i * 0.07 }}s;">
                <div class="guru-avatar" style="background: {{ $gc['avatar'] }};">
                    @if ($g->photo)
                        <img src="{{ asset('storage/' . $g->photo) }}" alt="{{ $g->nama }}"
                             class="w-full h-full rounded-full object-cover object-center">
                    @else
                        👤
                    @endif
                </div>
                <div class="guru-name">{{ $g->nama }}</div>
                <div class="guru-jabatan" style="color: {{ $gc['jabatan'] }};">{{ $g->jabatan }}</div>
                <div class="guru-nip">NIP: {{ $g->nip }}</div>
                <div class="guru-badges">
                    @if ($g->ijazah)
                        <span class="guru-badge" style="background: {{ $gc['badge_bg'] }}; color: {{ $gc['badge_color'] }};">
                            {{ $g->ijazah }}
                        </span>
                    @endif
                    @if ($g->gol)
                        <span class="guru-badge" style="background: {{ $gc['badge_bg'] }}; color: {{ $gc['badge_color'] }};">
                            {{ $g->gol }}
                        </span>
                    @endif
                    @if ($g->gr_kls_mp)
                        <span class="guru-badge" style="background: {{ $gc['badge_bg'] }}; color: {{ $gc['badge_color'] }};">
                            {{ $g->gr_kls_mp }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center reveal" style="margin-top: 2rem;">
            <a href="{{ route('guru.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-amber-500 text-slate-900 text-sm font-semibold hover:bg-amber-400 transition">
                Lihat Selengkapnya <span>-></span>
            </a>
        </div>
    </div>
</section>

{{-- ===== FASILITAS ===== --}}
<section id="fasilitas" class="section" style="background: #fff;">
    <div class="section-inner">
        <div class="text-center reveal">
            <div class="section-label" style="justify-content:center;">🏫 Infrastruktur</div>
            <h2 class="section-title">Fasilitas Sekolah</h2>
            <p class="section-desc" style="margin: 1rem auto 0;">
                Fasilitas modern untuk mendukung proses belajar yang optimal.
            </p>
        </div>
        @php
        $warnaDesign = [
            'blue'   => ['gradient' => 'linear-gradient(135deg,#eff6ff,#dbeafe)', 'arrow' => '#1a56db'],
            'green'  => ['gradient' => 'linear-gradient(135deg,#f0fdf4,#dcfce7)', 'arrow' => '#059669'],
            'yellow' => ['gradient' => 'linear-gradient(135deg,#fffbeb,#fef3c7)', 'arrow' => '#d97706'],
            'pink'   => ['gradient' => 'linear-gradient(135deg,#fdf2f8,#fce7f3)', 'arrow' => '#db2777'],
            'purple' => ['gradient' => 'linear-gradient(135deg,#faf5ff,#ede9fe)', 'arrow' => '#9333ea'],
            'orange' => ['gradient' => 'linear-gradient(135deg,#fff7ed,#ffedd5)', 'arrow' => '#ea580c'],
        ];
        @endphp

        <div class="fasilitas-grid">
            @foreach(collect($fasilitas)->take(4) as $i => $item)
            @php
                // Support object (dari DB) maupun array (lama)
                $isObj  = is_object($item);
                $warna  = $isObj ? ($item->warna ?? 'blue') : ($item['color'] ?? 'blue');
                $nama   = $isObj ? $item->nama      : $item['title'];
                $desk   = $isObj ? $item->deskripsi : $item['description'];
                $cardBg = $isObj ? ($item->card_bg_image ?? null) : ($item['card_bg_image'] ?? null);
                $fd     = $warnaDesign[$warna] ?? $warnaDesign['blue'];
                $bgStyle = $cardBg ? "background-image: url('" . asset('storage/' . $cardBg) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;" : '';
            @endphp
            <div class="fasilitas-card reveal"
                 style="transition-delay: {{ $i * 0.1 }}s;">
                <div class="fasilitas-card-top" style="background: {{ $fd['gradient'] }}; {{ $bgStyle }}">
                </div>
                <div class="fasilitas-card-body">
                    <h3>{{ $nama }}</h3>
                    <p>{{ $desk }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center reveal" style="margin-top: 2rem;">
            <a href="{{ route('fasilitas.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                Lihat Selengkapnya <span>-></span>
            </a>
        </div>
    </div>
</section>

{{-- ===== KONTAK ===== --}}
<section id="kontak" class="section" style="background: var(--surface);">
    <div class="section-inner">
        <div class="text-center reveal">
            <div class="section-label" style="justify-content:center;">📞 Hubungi Kami</div>
            <h2 class="section-title">Kami Siap Membantu</h2>
            <p class="section-desc" style="margin: 1rem auto 0;">
                Jangan ragu untuk menghubungi kami kapan saja
            </p>
        </div>

        @php
            $alamatLines = collect(explode("\n", $kontak['address'] ?? ''))
                ->map(fn ($line) => trim($line))
                ->filter()
                ->values();
            $phoneRaw = $kontak['phone'] ?? '';
            $phoneLink = preg_replace('/[^0-9+]/', '', $phoneRaw);
            $emailRaw = $kontak['email'] ?? '';
            $mapsUrl = $kontak['maps_url'] ?? '';
            $mapsEmbed = $mapsUrl;
            if ($mapsUrl && !Str::contains($mapsUrl, 'embed')) {
                $mapsEmbed = 'https://www.google.com/maps?q=' . urlencode($mapsUrl) . '&output=embed';
            }
        @endphp

        <div class="kontak-grid">
            <div class="kontak-card kontak-card-blue reveal">
                <div class="kontak-icon" style="background: rgba(26,86,219,.1);">📍</div>
                <div class="kontak-meta">Alamat Sekolah</div>
                <div class="kontak-body">
                    <h3>Alamat</h3>
                    @if ($mapsUrl)
                        <p>
                            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="text-slate-700 hover:text-blue-600 transition">
                                {!! $alamatLines->implode('<br>') !!}
                            </a>
                        </p>
                    @else
                        <p>{!! $alamatLines->implode('<br>') !!}</p>
                    @endif
                </div>
            </div>
            <div class="kontak-card kontak-card-green reveal reveal-delay-1">
                <div class="kontak-icon" style="background: rgba(16,185,129,.1);">📞</div>
                <div class="kontak-meta">Kontak Cepat</div>
                <div class="kontak-body">
                    <h3>Telepon</h3>
                    @if ($phoneLink)
                        <p>
                            <a href="tel:{{ $phoneLink }}" class="text-slate-700 hover:text-emerald-600 transition">
                                {{ $phoneRaw }}
                            </a>
                        </p>
                    @else
                        <p>-</p>
                    @endif
                </div>
            </div>
            <div class="kontak-card kontak-card-purple reveal reveal-delay-2">
                <div class="kontak-icon" style="background: rgba(124,58,237,.1);">✉️</div>
                <div class="kontak-meta">Informasi</div>
                <div class="kontak-body">
                    <h3>Email</h3>
                    @if ($emailRaw)
                        <p>
                            <a href="mailto:{{ $emailRaw }}" class="text-slate-700 hover:text-purple-600 transition">
                                {{ $emailRaw }}
                            </a>
                        </p>
                    @else
                        <p>-</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Map & Additional Info --}}
        <div class="kontak-extra reveal">
            <div class="kontak-map">
                @if ($mapsUrl)
                    <iframe
                        src="{{ $mapsEmbed }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi SD N 2 Dermolo">
                    </iframe>
                @else
                    <div class="h-full w-full flex items-center justify-center text-sm text-slate-500">
                        Tautan Google Maps belum tersedia.
                    </div>
                @endif
            </div>
            <form class="kontak-form" method="POST" action="{{ url('/kirim-pesan') }}">
                @csrf
                <h3>Kirim Pesan</h3>
                <p>Isi formulir di bawah ini dan kami akan segera menghubungi Anda.</p>
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="kontak-field">
                    <label for="contact-name">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input id="contact-name" name="name" type="text" placeholder="Masukkan nama lengkap Anda" required>
                </div>
                <div class="kontak-field">
                    <label for="contact-email">Email <span class="text-rose-500">*</span></label>
                    <input id="contact-email" name="email" type="email" placeholder="email@contoh.com" required>
                </div>
                <div class="kontak-field">
                    <label for="contact-subject">Subjek <span class="text-rose-500">*</span></label>
                    <input id="contact-subject" name="subject" type="text" placeholder="Subjek pesan" required>
                </div>
                <div class="kontak-field">
                    <label for="contact-message">Pesan <span class="text-rose-500">*</span></label>
                    <textarea id="contact-message" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
                <button type="submit" class="kontak-submit">
                    Kirim Pesan <span>→</span>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── SCROLL REVEAL ──
const revealEls = document.querySelectorAll('.reveal');
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
revealEls.forEach(el => revealObserver.observe(el));

// ── COUNT UP ANIMATION ──
const countEls = document.querySelectorAll('[data-count]');
const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el     = entry.target;
        const target = parseInt(el.dataset.count);
        const suffix = el.dataset.suffix || '';
        let current  = 0;
        const step   = Math.ceil(target / 60);
        const timer  = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = current.toLocaleString() + suffix;
        }, 25);
        countObserver.unobserve(el);
    });
}, { threshold: 0.5 });
countEls.forEach(el => countObserver.observe(el));

// ── SMOOTH ANCHOR SCROLL ──
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

// ── HERO PARALLAX ──
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero-content');
    const mesh = document.querySelector('.hero-mesh');
    if (hero) hero.style.transform = `translateY(${scrolled * 0.25}px)`;
    if (mesh) mesh.style.transform = `translateY(${scrolled * 0.15}px)`;
}, { passive: true });
</script>
@endpush






