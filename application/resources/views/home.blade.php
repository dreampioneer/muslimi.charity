@extends('layouts.layouts')
@section('content')
<section class="home-top">
    <div class="container position-relative">
        <div class="row gy-5">
            <div class="col-md-6 pe-4">
                <img src="assets/img/home.png" class="w-p100" alt="gaza article">
                <div class="py-30 text-center">
                    <a href="{{ route('home.donate') }}" class="btn btn-custom btn-large" title="Donate Now">Donate Now</a>
                </div>
            </div>
            <div class="col-md-6 ps-4">
                <p class="text-dark">
                    {!! str_replace([":dead:", ":missing:", ":wound:"], [number_format($contentInfo->killed, 0, null, ', '), number_format($contentInfo->missing, 0, null, ', '), number_format($contentInfo->wounded, 0, null, ', ')], config('constants.home_content')) !!}
                </p>
            </div>
        </div>
    </div>
</section>

<section class="bg-slide">
    <div id="carouselExampleRide" class="carousel carousel-dark slide" data-bs-ride="true">
        <div class="carousel-inner">
            @php
                $carousels = [
                    [
                        'title' => 'Feed A Life Campaign',
                        'body' => 'We’re on the ground delivering LIFESAVING aid to over 6 million refugees living through war. They’re crying out for your help',
                        'raised' => '26,519.76',
                        'goal' => '50,000.00',
                        'days' => '0',
                        'percent' => '53.04',
                        'href' => 'https://madinah.com/feed-a-life-campaign/',
                        'imgUrl' => 'https://madinah.com/wp-content/uploads/2022/05/project-70791-body-1-1.jpg',
                    ],
                    [
                        'title' => 'Help Them Survive the Cold!',
                        'body' => 'Winter is here. Millions of refugees across the world aren’t sure whether they’ll make it to see the next year.',
                        'raised' => '8,889.67',
                        'goal' => '10,000.00',
                        'days' => '0',
                        'percent' => '88.90',
                        'href' => 'https://madinah.com/help-them-survive-the-cold/',
                        'imgUrl' => 'https://madinah.com/wp-content/uploads/2022/02/HCI-Winter-600x500-1.jpg',
                    ]
                ];
            @endphp
            @foreach ($carousels as $index => $carousel)
                <div class="carousel-item @if(!$index) active @endif">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-sm-12 align-self-center">
                                <h2 class="slide-title">
                                    <a class="primary" href="{{ $carousel['href'] }}" title="{{ $carousel['title'] }}">{{ $carousel['title'] }}</a>
                                </h2>
                                <p class="slide-intro">{{ $carousel['body'] }}</p>
                                <div class="slide-timeline">
                                    <ul>
                                        <li>
                                            <span class="">
                                                <bdi>
                                                    <span class="">$</span>
                                                    {{ $carousel['raised'] }}
                                                </bdi>
                                            </span>
                                            <span class="price">Raised
                                            </span>
                                        </li>
                                        <li>
                                            <span class="">
                                                <bdi>
                                                    <span class="">$</span>
                                                    {{ $carousel['goal'] }}
                                                </bdi>
                                            </span>
                                            <span class="price">Goal</span>
                                        </li>
                                        <li>
                                            <span>{{ $carousel['days'] }}</span>
                                            <span class="info-text">Days to go</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="slide-progress-bar">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary six-sec-ease-in-out" role="progressbar" data-valuetransitiongoal="{{ $carousel['percent'] }}" style="width:{{ $carousel['percent'] }}%;">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ $carousel['href'] }}" class="btn btn-custom btn-normal" title="Donate Now">
                                    Donate Now
                                </a>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ $carousel['imgUrl'] }}" class="img-fluid" alt="slider images">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

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
                        <a href="{{ $lastCampaign['url'] }}" title="{{ $lastCampaign['title'] }}">
                            <img src="{{ $lastCampaign['imageUrl'] }}" class="img-fluid" alt="{{ $lastCampaign['title'] }}">
                        </a>
                        @endif
                        <div class="campaign-post-content clearfix">
                            <h3>
                                <a class="primary" href="{{ $lastCampaign['url'] }}" title="{{ $lastCampaign['title'] }}">{{ $lastCampaign['title'] }}</a>
                            </h3>
                            <span class="entry-author">by {{ $lastCampaign['auther'] }}</span>
                            <span class="entry-category">in
                                <a href="https://madinah.com/{{ $lastCampaign['tag'] }}/" class="primary" rel="tag" title="{{ ucwords(str_replace('-', ' ', $lastCampaign['tag'])) }}">
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
                            <a href="{{ $lastCampaign['donateUrl'] }}" class="btn btn-custom btn-normal" title="Donate Now">Donate Now</a>
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
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/dawah-and-education/" title="Dawah and Education">Dawah and Education</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/WhatsApp-Image-2023-02-06-at-11.21.36-PM.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/emergency-appeal/" title="Emergency Appeal">Emergency Appeal</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/fw-1-scaled.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/food-and-water-relief/" title="Food and Water Relief">Food and Water Relief</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/masjid-img.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/masjid-development-and-support/" title="Masjid Development and Support">Masjid Development and Support</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/01/IMG-20220515-WA0032-1.jpeg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/orphan-relief/" title="Orphan Relief">Orphan Relief</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="campaign-categories-img" style="background-image:url(https://madinah.com/wp-content/uploads/2023/02/r-scaled.jpg)">
                    <div class="title">
                        <h3>
                            <a class="campaign-categories-img-title text-center" href="https://madinah.com/refugee-support/" title="Refugee Support">Refugee Support</a>
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
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/brand-4.webp" alt="brand-4">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/IIS_logo-2.webp" alt="IIS_logo">
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
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/logo-heart-only-v6-green-1.webp" alt="logo-heart-only-v6-green">
            </div>
            <div class="other-img">
                <img decoding="async" class="img-fluid" src="https://madinah.com/wp-content/uploads/2022/05/brand-1.webp" alt="brand-2">
            </div>
        </div>
    </div>
</section>
@endsection
