
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seblak Nashwa | Pedasnya Bikin Nagih!</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cream: #fff8ef;
            --cream-dark: #f4e6d5;
            --brown: #48271d;
            --red: #8e2917;
            --red-light: #a94329;
            --text: #39251d;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--cream);
            color: var(--text);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        .container {
            width: min(1100px, 90%);
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(255, 248, 239, 0.97);
            border-bottom: 1px solid #f0dfcf;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            min-height: 76px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--red);
            font-size: 23px;
            font-weight: 900;
            line-height: 1.1;
        }

        .logo-icon {
            font-size: 36px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            color: var(--text);
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:hover {
            color: var(--red);
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 9px;
            background: var(--red);
            color: white;
            padding: 13px 23px;
            border-radius: 40px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            background: var(--red-light);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: var(--cream);
            color: var(--red);
            border: 1px solid #ead2bd;
        }

        .btn-outline:hover {
            color: white;
        }

        /* HERO */
        .hero {
            background:
                radial-gradient(ellipse at 90% 20%, #f4d4b5 0, transparent 35%),
                linear-gradient(110deg, #fff6e9, #f5dfc8);
            overflow: hidden;
        }

        .hero-inner {
            min-height: 440px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 25px;
        }

        .hero-copy {
            padding: 55px 0;
        }

        .eyebrow {
            display: inline-block;
            background: #f0d1b1;
            color: var(--red);
            padding: 7px 15px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 17px;
        }

        .hero h1 {
            color: var(--red);
            font-size: clamp(38px, 5vw, 60px);
            line-height: 1.08;
            letter-spacing: -2px;
            margin-bottom: 12px;
        }

        .hero h2 {
            font-size: 23px;
            line-height: 1.35;
            margin-bottom: 15px;
        }

        .hero p {
            color: #6e5c50;
            font-size: 15px;
            max-width: 460px;
            margin-bottom: 23px;
        }

        .hero-photo {
            height: 390px;
            width: 100%;
            background: #e8c8a7;
            border-radius: 48% 0 0 48%;
            overflow: hidden;
            box-shadow: -15px 15px 0 rgba(142, 41, 23, 0.08);
        }

        .hero-photo img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        /* KEUNGGULAN */
        .features {
            padding: 30px 0;
            background: #fffaf4;
            border-bottom: 1px solid #f0e4d8;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .feature {
            padding: 5px;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--red-light);
            color: white;
            border-radius: 50%;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .feature h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .feature p {
            font-size: 13px;
            color: #76645a;
        }

        /* MENU */
        .menu-section {
            padding: 60px 0 35px;
        }

        .section-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-heading .small-title {
            color: var(--red);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .section-heading h2 {
            color: var(--brown);
            font-size: clamp(28px, 4vw, 38px);
            margin: 5px 0;
        }

        .section-heading p {
            color: #76645a;
            font-size: 14px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: white;
            border: 1px solid #f0e0d2;
            border-radius: 13px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(67, 36, 23, 0.07);
            transition: 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 22px rgba(67, 36, 23, 0.12);
        }

        .menu-card img {
            display: block;
            width: 100%;
            height: 165px;
            object-fit: cover;
        }

        .menu-info {
            padding: 13px;
        }

        .menu-info h3 {
            font-size: 16px;
            margin-bottom: 4px;
        }

        .menu-info p {
            color: var(--red);
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .menu-info .btn {
            width: 100%;
            padding: 10px 8px;
            font-size: 12px;
        }

        /* PROMO */
        .promo {
            margin: 5px auto 25px;
            min-height: 175px;
            border-radius: 15px;
            background:
                linear-gradient(90deg, rgba(100, 32, 17, .97), rgba(133, 46, 26, .82)),
                url('https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1400&q=85')
                center/cover;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 30px 40px;
            overflow: hidden;
        }

        .promo h2 {
            font-size: 28px;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .promo p {
            max-width: 460px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        /* FOOTER */
        footer {
            background: #48271d;
            color: #fff4e9;
            padding: 28px 0 18px;
        }

        .footer-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 22px;
        }

        footer .logo {
            color: #fff4e9;
        }

        .footer-links {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        .footer-links a,
        .social a {
            color: #fff4e9;
            font-size: 13px;
        }

        .footer-links a:hover,
        .social a:hover {
            color: #f1bd8c;
        }

        .social {
            display: flex;
            gap: 17px;
        }

        .copyright {
            text-align: center;
            border-top: 1px solid #674438;
            padding-top: 15px;
            font-size: 12px;
            color: #ddc7b8;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .nav-links {
                gap: 14px;
            }

            .nav-links a {
                font-size: 12px;
            }

            .hero-inner {
                grid-template-columns: 1fr 1fr;
            }

            .hero-photo {
                height: 330px;
            }

            .menu-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .menu-card img {
                height: 200px;
            }
        }

        @media (max-width: 600px) {
            .nav-inner {
                padding: 14px 0;
                flex-wrap: wrap;
            }

            .logo {
                font-size: 19px;
            }

            .nav-links {
                order: 3;
                width: 100%;
                justify-content: space-between;
                gap: 8px;
            }

            .nav-links a {
                font-size: 12px;
            }

            .nav-order {
                padding: 9px 12px;
                font-size: 12px;
            }

            .hero-inner {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .hero-copy {
                padding: 38px 0 25px;
            }

            .hero h1 {
                font-size: 43px;
            }

            .hero h2 {
                font-size: 20px;
            }

            .hero-photo {
                height: 260px;
                margin-bottom: 30px;
                border-radius: 20px;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px 15px;
            }

            .menu-section {
                padding-top: 42px;
            }

            .menu-grid {
                gap: 12px;
            }

            .menu-card img {
                height: 125px;
            }

            .menu-info {
                padding: 10px;
            }

            .menu-info h3 {
                font-size: 14px;
            }

            .menu-info p {
                font-size: 13px;
            }

            .menu-info .btn {
                font-size: 11px;
                padding: 9px 5px;
            }

            .promo {
                padding: 25px 22px;
                margin-top: 20px;
            }

            .promo h2 {
                font-size: 25px;
            }

            .footer-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-links {
                gap: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container nav-inner">
            <a href="#beranda" class="logo">
                <span class="logo-icon">🍲</span>
                <span>Seblak<br>Nashwa</span>
            </a>

            <nav class="nav-links">
                <a href="#beranda">Beranda</a>
                <a href="#menu">Menu</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <a class="btn nav-order"
               href="https://wa.me/6281234567890?text=Halo%20Seblak%20Nashwa%2C%20saya%20ingin%20memesan">
                ☎ Pesan Sekarang
            </a>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero" id="beranda">
        <div class="container hero-inner">
            <div class="hero-copy">
                <span class="eyebrow">🌶️ Pedasnya Bikin Nagih!</span>

                <h1>Seblak Nashwa</h1>
                <h2>Rasa Autentik, Pedasnya Juara!</h2>

                <p>
                    Nikmati kelezatan seblak dengan berbagai pilihan
                    menu dan topping sesuai selera. Dibuat dari bahan
                    pilihan dengan cita rasa khas yang bikin ketagihan.
                </p>

                <a class="btn"
                   href="https://wa.me/6281234567890?text=Halo%20Seblak%20Nashwa%2C%20saya%20ingin%20memesan">
                    ☎ Pesan Sekarang &nbsp; ›
                </a>
            </div>

            <div class="hero-photo">
                <img
                    src="https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1000&q=90"
                    alt="Hidangan makanan pedas Seblak Nashwa"
                >
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN -->
    <section class="features" id="tentang">
        <div class="container feature-grid">
            <div class="feature">
                <div class="feature-icon">🍃</div>
                <h3>Bahan Pilihan</h3>
                <p>Menggunakan bahan berkualitas dan segar setiap hari.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">🌶️</div>
                <h3>Rasa Autentik</h3>
                <p>Racikan bumbu khas yang menggugah selera.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">🛵</div>
                <h3>Pelayanan Cepat</h3>
                <p>Pesanan diproses dengan cepat dan penuh perhatian.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">♥</div>
                <h3>Harga Terjangkau</h3>
                <p>Nikmati seblak lezat dengan harga bersahabat.</p>
            </div>
        </div>
    </section>

    <!-- MENU FAVORIT -->
    <section class="menu-section" id="menu">
        <div class="container">
            <div class="section-heading">
                <div class="small-title">Menu Unggulan</div>
                <h2>Menu Favorit Kami</h2>
                <p>
                    Coba berbagai varian seblak dengan rasa khas
                    dan menggugah selera.
                </p>
            </div>

            <div class="menu-grid">
                <article class="menu-card">
                    <img
                        src="https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=600&q=85"
                        alt="Seblak Original"
                        loading="lazy"
                    >
                    <div class="menu-info">
                        <h3>Seblak Original</h3>
                        <p>Rp 12.000</p>
                        <a class="btn"
                           href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20memesan%20Seblak%20Original">
                            ☎ Pesan Sekarang
                        </a>
                    </div>
                </article>

                <article class="menu-card">
                    <img
                        src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=600&q=85"
                        alt="Seblak Ceker"
                        loading="lazy"
                    >
                    <div class="menu-info">
                        <h3>Seblak Ceker</h3>
                        <p>Rp 15.000</p>
                        <a class="btn"
                           href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20memesan%20Seblak%20Ceker">
                            ☎ Pesan Sekarang
                        </a>
                    </div>
                </article>

                <article class="menu-card">
                    <img
                        src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=600&q=85"
                        alt="Seblak Sosis"
                        loading="lazy"
                    >
                    <div class="menu-info">
                        <h3>Seblak Sosis</h3>
                        <p>Rp 13.000</p>
                        <a class="btn"
                           href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20memesan%20Seblak%20Sosis">
                            ☎ Pesan Sekarang
                        </a>
                    </div>
                </article>

                <article class="menu-card">
                    <img
                        src="https://images.unsplash.com/photo-1515003197210-e0cd7184f8b5?auto=format&fit=crop&w=600&q=85"
                        alt="Seblak Komplit"
                        loading="lazy"
                    >
                    <div class="menu-info">
                        <h3>Seblak Komplit</h3>
                        <p>Rp 18.000</p>
                        <a class="btn"
                           href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20memesan%20Seblak%20Komplit">
                            ☎ Pesan Sekarang
                        </a>
                    </div>
                </article>
            </div>

            <!-- PROMO -->
            <div class="promo">
                <div>
                    <h2>Jangan Lupa<br>Pesan Sekarang!</h2>
                    <p>
                        Rasakan sensasi pedas dan gurihnya Seblak Nashwa
                        dengan harga terbaik!
                    </p>
                    <a class="btn btn-outline"
                       href="https://wa.me/6281234567890?text=Halo%20Seblak%20Nashwa%2C%20saya%20ingin%20memesan">
                        ☎ Pesan Sekarang
                    </a>
                </div>
                <div aria-hidden="true" style="font-size:65px">🍜🌶️</div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="kontak">
        <div class="container">
            <div class="footer-top">
                <a href="#beranda" class="logo">
                    <span class="logo-icon">🍲</span>
                    <span>Seblak<br>Nashwa</span>
                </a>

                <nav class="footer-links">
                    <a href="#beranda">Beranda</a>
                    <a href="#menu">Menu</a>
                    <a href="#tentang">Tentang Kami</a>
                    <a href="#kontak">Kontak</a>
                </nav>

                <div class="social">
                    <a href="https://instagram.com/" target="_blank"
                       rel="noopener noreferrer">Instagram</a>
                    <a href="https://wa.me/6281234567890">WhatsApp</a>
                </div>
            </div>

            <div class="copyright">
                © 2026 Seblak Nashwa. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
