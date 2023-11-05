@extends('layouts.layouts')
@section('content')
<section class="home-top">
    <div class="container position-relative">
        <div class="row gy-5">
            <div class="col-md-6 pe-4">
                <img src="assets/img/home.png" class="w-p100" alt="">
                <div class="py-30 text-center">
                    <a href="{{ route('home.donate') }}" class="btn btn-custom btn-large">Donate Now</a>
                </div>
            </div>
            <div class="col-md-6 ps-4">
                <p class="text-dark">
                    🤝 Our charity partners are delivering aid to our brothers and sisters in Gaza.<br>
                    ⚠ The overall death toll in Palestine is 8,000+ (40% are children), and over 21,000+ are injured. 2.3 million people are at risk.<br>
                    💡 Muslimi is working with our charity partners to ensure your aid is delivered in Gaza. Your donation is an Amana, which will reach our partners on the ground. Our charity partners have emergency aid stockpiles and are getting resources from within Gaza; though these resources are being reduced daily, they are being replenished as the Egypt-Rafah border crossing is slowly letting aid in inshaAllah.<br>
                    The Rafah border crossing between Egypt and Gaza has opened to let needed aid flow to Palestinians running short of food, medicine, and water in Gaza. Meanwhile, aid deliveries have come as the Israeli military continued bombing Gaza and Rafah.<br>
                    Your donation right now can be the lifeline for many in Gaza. Let's unite in this hour of dire need and show that the Ummah stands united with the innocent civilians in Gaza.<br>
                    🆘 Supply a family with a month's supply of Hot Meals - $56.00<br>
                    🆘 Supply 2 families with a month's supply of Hot Meals - $112.00<br>
                    🆘 Supply 5 families with a month's supply of Hot Meals - $280.00<br>
                    🆘 Supply 10 families with a month's supply of Hot Meals - $560.00<br>
                    🆘 Supply 20 families with a month's supply of Hot Meals - $1,120.00<br>
                    🆘 Emergency Medical Supplies to Hospitals - $200<br>
                    🆘 Emergency Shelter - $500<br>
                    🆘 Emergency Aid Combo (Meals, Water, Aid, Shelter) - $1,000
                </p>
            </div>
        </div>
    </div>
</section>

<section class="bg-slide">
    <div id="carouselExampleRide" class="carousel carousel-dark slide" data-bs-ride="true">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-12 align-self-center">
                        <h2 class="slide-title">
                            <a class="primary" href="https://madinah.com/feed-a-life-campaign/">Feed A Life Campaign</a>
                        </h2>
                        <p class="slide-intro">We’re on the ground delivering LIFESAVING aid to over 6 million refugees living through war. They’re crying out for your help </p>
                        <div class="slide-timeline">
                            <ul>
                                <li>
                                    <span class="">
                                        <bdi>
                                            <span class="">$</span>
                                            26,092.76
                                        </bdi>
                                    </span>
                                    <span class="price">Raised
                                    </span>
                                </li>
                                <li>
                                    <span class="">
                                        <bdi>
                                            <span class="">$</span>
                                            50,000.00
                                        </bdi>
                                    </span>
                                    <span class="price">Goal</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span class="info-text">Days to go</span>
                                </li>
                            </ul>
                        </div>
                        <div class="slide-progress-bar">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary six-sec-ease-in-out" role="progressbar" data-valuetransitiongoal="52.19" style="width:52.19%;">
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-custom btn-normal">
                            Donate Now
                        </a>
                    </div>
                    <div class="col-md-6">
                        <img src="https://madinah.com/wp-content/uploads/2022/05/project-70791-body-1-1.jpg" class="img-fluid">
                    </div>
                </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-12 align-self-center">
                        <h2 class="slide-title">
                            <a href="https://madinah.com/feed-a-life-campaign/">Feed A Life Campaign</a>
                        </h2>
                        <p class="slide-intro">We’re on the ground delivering LIFESAVING aid to over 6 million refugees living through war. They’re crying out for your help </p>
                        <div class="slide-timeline">
                            <ul>
                                <li>
                                    <span class="">
                                        <bdi>
                                            <span class="">$</span>
                                            26,092.76
                                        </bdi>
                                    </span>
                                    <span class="price">Raised
                                    </span>
                                </li>
                                <li>
                                    <span class="">
                                        <bdi>
                                            <span class="">$</span>
                                            50,000.00
                                        </bdi>
                                    </span>
                                    <span class="price">Goal</span>
                                </li>
                                <li>
                                    <span>0</span>
                                    <span class="info-text">Days to go</span>
                                </li>
                            </ul>
                        </div>
                        <div class="slide-progress-bar">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary six-sec-ease-in-out" role="progressbar" data-valuetransitiongoal="52.19" style="width:52.19%;">
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-custom btn-normal">
                            Donate Now
                        </a>
                    </div>
                    <div class="col-md-6">
                        <img src="https://madinah.com/wp-content/uploads/2022/05/project-70791-body-1-1.jpg" class="img-fluid">
                    </div>
                </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
</section>

<section class="latest-campaigns">
    <div class="container">
        <div class="latest-campaigns-title">
            <h2 class="w-p100 bordered text-center">
                <span>Lastest Campaigns</span>
            </h2>
        </div>
        <div class="row">
            @php
                $lastCampaigns = [
                    [
                        'imageUrl' => "https://madinah.com/wp-content/uploads/2023/07/project_158479_emergency_appeal_to_support_jenin_hospitals_palestine__357791070_654979093330550_6894920517917625158_n-700x525-1-600x500.jpg",
                        'url' => 'https://madinah.com/all-campaign/page/4/',
                        'title' => 'Emergency Appeal to Support Jenin Hospitals (Palestine )',
                        'auther' => 'AL-NOMAN FOUNDATION INC.',
                        'post' => 'Supporting Jenin hospitals',
                        'tag' => 'emergency-appeal',
                        'founded' => '1,650.00',
                        'goal' => "20,000.00",
                        'percent' => '8.25',
                        'days' => 0,
                        'donateUrl' => "https://madinah.com/emergency-appeal-to-support-jenin-hospitals-palestine/",
                    ],
                    [
                        'imageUrl' => "https://madinah.com/wp-content/uploads/2023/09/3uLqtbijYFE8NzGDxXjS_RiNbLU97gBNCrFA8FmmtQQ_plaintext_638306271644758926-600x500.jpg",
                        'url' => 'https://madinah.com/all-campaign/page/2/',
                        'title' => 'Save the lives of starving Yemeni children',
                        'auther' => 'AL-NOMAN FOUNDATION INC.',
                        'post' => 'Addressing the worst humanitarian crisis in human history, Yemen sees…',
                        'tag' => 'food-and-water-relief',
                        'founded' => '532.00',
                        'goal' => "10,000.00",
                        'percent' => '5.32',
                        'days' => "146",
                        'donateUrl' => "https://madinah.com/save-the-lives-of-starving-yemeni-children/",
                    ],
                    [
                        'imageUrl' => '',
                        'url' => 'https://madinah.com/all-campaign/page/4/',
                        'title' => 'Help Feed 1 MILLION Syrian, Yemeni, and Palestinian Refugees in Lebanon',
                        'auther' => 'alamal international charity',
                        'post' => '80% of Palestinian, Yemeni and Syrian Families Will Go To…',
                        'tag' => 'emergency-appeal',
                        'founded' => '355.00',
                        'goal' => "10,000.00",
                        'percent' => '3.55',
                        'days' => "0",
                        'donateUrl' => "https://madinah.com/help-feed-1-million-syrian-yemeni-and-palestinian-refugees-in-lebanon/",
                    ],
                ]
            @endphp
            @foreach ($lastCampaigns as $lastCampaign)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="campaign-post">
                        @if($lastCampaign['imageUrl'])
                        <a href="{{ $lastCampaign['url'] }}">
                            <img src="{{ $lastCampaign['imageUrl'] }}" class="img-fluid">
                        </a>
                        @endif
                        <div class="campaign-post-content clearfix">
                            <h3>
                                <a class="primary" href="{{ $lastCampaign['url'] }}">{{ $lastCampaign['title'] }}</a>
                            </h3>
                            <span class="entry-author">by {{ $lastCampaign['auther'] }}</span>
                            <span class="entry-category">in
                                <a href="https://madinah.com/{{ $lastCampaign['tag'] }}/" class="primary" rel="tag">
                                    {{ ucwords(str_replace('-', ' ', $lastCampaign['tag'])) }}
                                </a>
                            </span>
                            <p>{{ $lastCampaign['post'] }}</p>
                        </div>
                        <div class="campaign-progressbar-content">
                            <div class="progress-bar">
                                <div class="lead">
                                    <span class="pull-left">
                                        <span>
                                            <bdi><span>$</span>{{ $lastCampaign['founded'] }}</bdi>
                                        </span>
                                        Raised
                                    </span>
                                    <span class="percentag pull-right">{{ $lastCampaign['percent'] }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary six-sec-ease-in-out" role="progressbar" data-valuetransitiongoal="{{ $lastCampaign['percent'] }}" style="width: {{ $lastCampaign['percent'] }}%;">
                                    </div>
                                </div>
                                <div class="funding-goal">
                                    <div class="meta-desc pull-left">
                                        <span>
                                            <span>
                                                <bdi><span>$</span>{{ $lastCampaign['goal'] }}</bdi>
                                            </span>
                                        </span>Goal
                                    </div>
                                    <div class="meta-name pull-right">
                                        {{ $lastCampaign['days'] }} Days to Go
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="campaign-action">
                            <a href="{{ $lastCampaign['donateUrl'] }}" class="btn btn-custom btn-normal">Donate Now</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

<section class="campaign-categories">
    <div class="container">
        <div class="campaign-categories-title">
            <h2 class="w-p100 bordered text-center">
                <span>Campaign Categories</span>
            </h2>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/quran-majid-img.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/dawah-and-education/">Dawah and Education</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/WhatsApp-Image-2023-02-06-at-11.21.36-PM.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/emergency-appeal/">Emergency Appeal</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/fw-1-scaled.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/food-and-water-relief/">Food and Water Relief</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/masjid-img.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/masjid-development-and-support/">Masjid Development and Support</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/01/IMG-20220515-WA0032-1.jpeg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/orphan-relief/">Orphan Relief</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/r-scaled.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/refugee-support/">Refugee Support</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="others">
    <div class="container">
        <div class="d-flex">
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/brand-2.webp" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/brand-4.webp" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/IIS_logo-2.webp" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/img3.webp" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/img-4.png" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/logo4.webp" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/logo-heart-only-v6-green-1.webp" alt="brand-2">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/brand-1.webp" alt="brand-2">
            </div>
        </div>
    </div>
</section>
@endsection
