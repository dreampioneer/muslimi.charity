<footer id="footer" class="footer">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-12 footer-info">
            <div class="logo">
                <img src="{{ asset('assets/img/madinah-poweredby.png') }}" alt="logo">
            </div>
        </div>

        <div class="col-lg-4 col-6 footer-links">
          <ul>
            <li><a href="https://madinah.com/about-us/">About Us</a></li>
            <li><a href="https://madinah.com/marketing/">Marketing</a></li>
            <li><a href="https://madinah.com/careers/">Careers</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-6 footer-links">
          <p>Email: <a rel="noreferrer noopener" class="custom" href="mailto:info@muslimi.charity" target="_blank">info@muslimi.charity</a></p>
          <p>، المعصرة، مركز الفتح،,
            El Fateh, Assiut Governorate,
            Egypt.</p>
        </div>
      </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            @php
                $currentYear = date("Y");
            @endphp
            <div class="col-md-12 text-center">
                Copyright {{ $currentYear }} © | All Rights Reserved | Muslimi | <a href="https://madinah.com/privacy-policy-2/" target="_blank">Privacy Policy</a> </div>
            </div>
        </div>
    </div>
</footer>
