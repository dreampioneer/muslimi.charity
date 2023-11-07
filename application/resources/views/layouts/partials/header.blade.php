<header id="header" class="header d-flex align-items-center border-bottom">

    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="{{ route('home.index') }}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/img/muslimi.png') }}" alt="">
        {{-- <h1>MUSLIMI</h1> --}}
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="{{ route('home.index') }}" class="primary">Home</a></li>
        </ul>
      </nav><!-- .navbar -->
{{--
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i> --}}

    </div>
</header>
