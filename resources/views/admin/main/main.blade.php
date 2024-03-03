<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('layout/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('layout/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="{{asset('layout/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('layout/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('layout/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('layout/assets/vendor/aos/aos.css')}}" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="{{asset('layout/assets/css/variables.css')}}" rel="stylesheet">
  <link href="{{asset('layout/assets/css/main.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: ZenBlog - v1.3.0
  * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
  * Author: BootstrapMade.com
  * License: https:///bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>Alex Media</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
            <li><a href="{{route('admin#categoryList')}}">Catogory</a></li>
            <li><a href="{{route('admin#postList')}}">Post</a></li>
            <li><a href="{{route('admin#playlist')}}">My Playlist</a></li>
            <li><a href="{{route('admin#userList')}}">User</a></li>
            <li><a href="{{route('admin#list')}}">Admin</a></li>
            <li><a href="{{route('admin#messageList','receive')}}">Message</a></li>

        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <div class="btn-group">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{Auth::user()->name}}
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('admin#profile')}}">Profile</a></li>
              <li><a class="dropdown-item" href="{{route('admin#changePasswordPage')}}">Change Password</a></li>
              <li>
                <form action="{{route('logout')}}" method="post" class=" d-flex justify-content-center m-2">
                    @csrf
                    <button class="w-100 btn btn-danger" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</button>
                </form>
              </li>
            </ul>
        </div>

        <i class="bi bi-list mobile-nav-toggle"></i>

        {{-- <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
        <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
          <form action="search-result.html" class="search-form">
            <span class="icon bi-search"></span>
            <input type="text" placeholder="Search" class="form-control">
            <button class="btn js-search-close"><span class="bi-x"></span></button>
          </form>
        </div><!-- End Search Form --> --}}

      </div>

    </div>

  </header><!-- End Header -->

  <main id="main">

    @yield('contect')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="footer-legal">
      <div class="container">

        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>ZenBlog</span></strong>. All Rights Reserved
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>

          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>

      </div>
    </div>

  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{asset('layout/ckeditor/ckeditor.js')}}"></script>
  <!-- Vendor JS Files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="{{asset('layout/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('layout/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('layout/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('layout/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('layout/assets/js/main.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://kit.fontawesome.com/10de2103ef.js" crossorigin="anonymous"></script>

  @yield('script')
</body>

</html>
