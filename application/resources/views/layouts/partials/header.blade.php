<header id="header" class="header d-flex align-items-center border-bottom">

    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="{{ route('home.index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/muslimi.png') }}" alt="muslimi logo">
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}" class="primary @if($request->is('home*') || $request->is('donate*') ) active @endif">Home</a>
                </li>
                <li>
                    <a href="{{ route('faq.index') }}" class="primary @if($request->is('faq*')) active @endif">FAQ</a>
                </li>
            </ul>
        </nav><!-- .navbar -->

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
</header>
