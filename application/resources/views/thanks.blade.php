@extends('layouts.layouts')
@section('content')
<section>
    <div class="container">
        <div class="thanks mx-auto">
            <div class="text-center thank-header py-5">
                <div class="overlay"></div>
                <img class="mt-5 mb-3" src="{{ asset('assets/img/donate.png') }}" style="width: 100px" alt="thank background">
                <h2 class="text-center fs-1 text-light">
                    Thanks for your donation, {{ $donate->first_name }} {{ $donate->last_name }}!
                </h2>
            </div>

            <div class="thank-body px-5 pt-5 pb-4">
                <h3 class="mb-2 fs-3 text-left">YOUR DONATION</h3>
                @php
                    $total = 0;
                @endphp
                @foreach ($donate->detail as $item)
                    <div class="row py-3 border-bottom border-2">
                        <div class="col-md-7">
                            <h5 class="mb-0">{{ $item->donate_name }}</h5>
                        </div>
                        <div class="col-md-2 my-auto">
                            <h5 class="mb-0">${{ number_format(floatval($item->donate_amount), 2, ',', ',') }}</h5>
                        </div>
                        <div class="col-md-1 my-auto">
                            <h5 class="mb-0">{{ number_format(intval($item->donate_count), 0, '', ',') }}</h5>
                        </div>
                        <div class="col-md-2 text-right my-auto">
                            <h5 class="mb-0">$ {{ number_format(floatval($item->donate_amount) * intval($item->donate_count), 2, ',', ',') }}</h5>
                        </div>
                        @php
                            $total = $total + floatval($item->donate_amount) * intval($item->donate_count);
                        @endphp
                    </div>
                @endforeach
                <div class="row py-4">
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-0">Total</h4>
                    </div>
                    <div class="col-md-4 text-right">
                        <h4 class="fw-bold mb-0">$ {{ number_format($total, 2, '.', ',') }}</h4>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('home.index') }}" class="btn btn-custom btn-normal">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
