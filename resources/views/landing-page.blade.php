@extends('layouts.app')

@section('content')
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      {{-- <h1 class="logo me-auto"><a href="index.html">{{config('app.name')}}</a></h1> --}}
      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="/" class="logo me-auto"><img src="{{ asset('assets') }}/img/favicon.webp" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#peta-sebaran">Sebaran</a></li>
          <li><a class="nav-link scrollto" href="#newspaper-edition">Edisi Koran</a></li>
          <li><a class="nav-link scrollto" href="https://radarbogor.id" target="_blank">Web Radar Bogor</a></li>
          <li><a class="getstarted scrollto" href="{{route('login')}}">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>Radar Bogor Customer Location Tracker</h1>
          <h2>Slogan yang Radar Bogor ingin wujudkan <br> "Besar karena Tersebar"</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="#peta-sebaran" class="btn-get-started scrollto">Lihat Sebaran</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{asset('assets/img')}}/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= About Us Section ======= -->
    <section id="peta-sebaran" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Peta Sebaran Pelangan</h2>
        </div>

        <div class="row content">
        <!-- id for set map customer area -->
        <div id="map" style="height: 800px; border-radius:50px; "></div>

        @include('library.leaflet-ploating')
        <!-- End Line Chart -->
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="newspaper-edition" class="why-us section-bg">
      <div class="container-fluid" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

            <div class="content">
              <h3>Radar Bogor menerbitkan edisi-edisi koran yang memiliki <strong>Inovasi, Kreatifitas, dan Keunikan</strong></h3>
              <p>
                Berikut 3 edisi koran favorite yang telah diterbitkan Radar Bogor selama beberapa tahun terakhir.
              </p>
            </div>

            <div class="accordion-list">
              <ul>
                <li>
                  <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span> Koran Edisi Harian <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                    <p>
                      Koran yang diterbitkan disetiap harinya yang berisi berita terkini, dan Edisi ini yang konsisten dan paling banyak berlangganan.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed"><span>02</span> Koran Edisi Sekolah <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                    <p>
                      Koran yang diterbitkan dalam beberapa waktu yang berisikan karya-karya anak sekolah dan yang berlangganan biasanya sekolah.
                    </p>
                  </div>
                </li>

                <li>
                  <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed"><span>03</span> Koran Edisi Desa <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                    <p>
                      Koran yang berisi update suatu desa untuk membantu mempromosikan daerah tersebut dan hanya terbit beberapa waktu.
                    </p>
                  </div>
                </li>

              </ul>
            </div>

          </div>

          <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("{{asset('assets/img')}}/why-us.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div>
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Berikut beberapa kontak yang dapat dihubungi untuk membahas langganan dan kerjasama.</p>
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>Jl. KH. R. Abdullah Bin Muhammad Nuh No. 30, Taman Yasmin, Kota Bogor.</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>redaksi [at] radar-bogor.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>0251-7544005</p>
              </div>
              <iframe src="https://www.google.com/maps/embed/v1/place?q=Radar+Bogor,+Graha+Pena+Bogor,+Jl+KHR+Abdullah+Bin+Nuh+Jalan+Ring+Road+Taman+Yasmin,+RT.05/RW.04,+Cibadak,+Kota+Bogor,+Jawa+Barat,+Indonesia&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Your Name</label>
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group">
                <label for="name">Message</label>
                <textarea class="form-control" name="message" rows="10" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row justify-content-center">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Radar Bogor</h3>
            <p>
                Jl. KH. R. Abdullah Bin Muhammad Nuh No. 30,<br> Taman Yasmin,<br> Kota Bogor.
              <strong>Phone:</strong> 0251-7544005<br>
              <strong>Email:</strong> redaksi [at] radar-bogor.com<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <p>Cek Sosial Media Lainnya Dengan Klik Button Dibawah Ini</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>{{ config('app.name', 'Radar Bogor Location Tracker') }}</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  {{-- <div id="preloader"></div> --}}
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


@endsection
