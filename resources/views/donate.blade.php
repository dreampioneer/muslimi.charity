@extends('layouts.layouts')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-4">YOUR  DONATEION IS ZAKAT-ELIGIBLE</h4>
                <h4 class="mb-2">Recent donations</h4>
                @foreach ($donates as $donate)
                    <div class="border border-secondary-subtle border-2 px-4 py-3 recent-donation mb-3">
                        <div class="d-flex justify-content-between">
                            <div class="donation-info">
                                <p><b>{{ $donate->first_name }} {{ $donate->last_name }}</b> made a one-time donation</p>
                                <div class="d-flex text-right">
                                    {{-- <p class="m-0">Lahore, Pakistan</p><span class="dot m-auto"></span> --}}
                                    @php
                                        $pastTime = \Carbon\Carbon::parse($donate->created_at);
                                        $currentTime = now();
                                        $diffInMinutes = $pastTime->diffInMinutes($currentTime);
                                    @endphp
                                    <p class="m-0">{{ $diffInMinutes }} minutes age</p>
                                </div>
                            </div>
                            <div class="donation-amount">
                                <p class="fs-4 m-0 text-primary"><b>Rs 55,750.00</b></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @php
                $products = [
                    [
                        'project_name' => "Supply a family with a month's supply of Hot Meal",
                        'amount' => 56,
                    ],
                    [
                        'project_name' => "Supply 2 families with a month's supply of Hot Meals",
                        'amount' => 112,
                    ],
                    [
                        'project_name' => "Supply 5 families with a month's supply of Hot Meals",
                        'amount' => 280,
                    ],
                    [
                        'project_name' => "Supply 10 families with a month's supply of Hot Meals",
                        'amount' => 560,
                    ],
                    [
                        'project_name' => "Supply 20 families with a month's supply of Hot Meals",
                        'amount' => 1120,
                    ],
                    [
                        'project_name' => "Emergency Medical Supplies to Hospitals",
                        'amount' => 200,
                    ],
                    [
                        'project_name' => "Emergency Shelter",
                        'amount' => 500,
                    ],
                    [
                        'project_name' => "Emergency Aid Combo (Meals, Water, Aid, Shelter)",
                        'amount' => 1000,
                    ],
                ]
            @endphp
            <div class="col-md-6">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading mb-0">{{ session('success') }}</h4>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading mb-0">{{ session('error') }}</h4>
                    </div>
                @endif
                <div class="donate-div">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-7">
                                <p class="fs-5 mb-0">Products</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <p class="fs-5 mb-0">Qty</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <p class="fs-5 mb-0">Price</p>
                            </div>
                        </div>
                    </div>
                    @foreach ($products as $index => $product)
                        <div class="border border-secondary-subtle border-2 p-3 mb-2">
                            <div class="row">
                                <div class="col-md-7">
                                    <p class="mb-0">
                                        <input class="form-check-input product-select" type="radio" name="product" id="product" data-id="{{ $index }}" data-product-name="{{ $product['project_name'] }}" data-product-amount="{{ $product['amount'] }}">&nbsp;&nbsp;{{ $product["project_name"]}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary btn-sub w-35" type="button" data-id="{{ $index }}">-</button>
                                        <input type="number" class="form-control text-right qty-{{ $index }}" max="0" value="1" readonly>
                                        <button class="btn btn-outline-secondary btn-add w-35" type="button" data-id="{{ $index }}">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-right">
                                    <p class="fs-6 mb-0">
                                        ${{  number_format($product["amount"], 2, '.', ',')}}
                                    </p>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    <div class="detail-info">
                    </div>
                    <div class="p-3 mb-2">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">Total</p>
                            <p class="mb-0 fs-4">$<span class="total-amount">0</span></p>
                        </div>
                    </div>
                    <div class="w-p100">
                        <button class="btn btn-custom btn-normal w-p100 btn-donate">
                            Donate Now
                        </button>
                    </div>
                </div>
                <div class="payment-div">
                    <h4 class="mb-4">Billing Details</h4>
                    <h3 class="my-4 fs-5">Your Donation</h3>
                    <div class="row p-3">
                        <div class="col-md-9">
                            <p class="fs-5 mb-0">Designation</p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-5 mb-0">Subtotal</p>
                        </div>
                    </div>
                    <div class="row p-3 border-top">
                        <div class="col-md-9">
                            <p class="fs-5 mb-0 product-name">{{ old('product_name') }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-5 mb-0">$<span class="product-amount">{{ old('sub_amount') ? number_format(old('sub_amount'), 2, '.', ',') : '' }}</span></p>
                        </div>
                    </div>
                    <div class="row p-3 border-top">
                        <div class="col-md-9">
                            <p class="fs-5 mb-0">Count</p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-5 mb-0 count">{{ old('count') }}</p>
                        </div>
                    </div>
                    <div class="row p-3 border-top">
                        <div class="col-md-9">
                            <p class="fs-4 mb-0"><b>Total</b></p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-4 mb-0"><b>$<span class="total-amount">{{ old('sub_amount') && old('count') ? number_format(old('sub_amount') * old('count'), 2, '.', ',') : '' }}</span></b></p>
                        </div>
                    </div>
                    <form class="py-3" method="POST" action="{{ route('stripe.store') }}">
                        @csrf
                        <div class="row my-4">
                            <div class="col-md-6">
                                <div class="">
                                    <label for="" class="form-label">First Name&nbsp;<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="" class="form-label">Last Name&nbsp;<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="">
                                <label for="" class="form-label">Email Address&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="">
                                <label for="" class="form-label">Phone (optional)</label>
                                <input type="text" class="form-control" id="phone-number" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="">
                                <label for="" class="form-label">Card Number&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="card-number" name="card_number" placeholder="Card Number"  value="{{ old('card_number') }}">
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-md-6">
                                <div class="">
                                    <label for="" class="form-label">Expirey Date&nbsp;<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="expirey-date" name="expirey_date" placeholder="Expirey Date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="" class="form-label">CVC&nbsp;<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cvc" name="cvc" placeholder="CVC">
                                </div>
                            </div>
                        </div>
                        <div class="w-p100">
                            <button type="submit" class="btn btn-custom btn-normal w-p100">
                                {{ old('sub_amount') && old('count') ? 'Pay $' . number_format(old('sub_amount') * old('count'), 2, '.', ',') : '' }}
                            </button>
                            <button type="button" class="btn btn-light btn-normal w-p100 mt-3 btn-cancel">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row gy-5">
            <div class="col-md-6 pe-4">
                <img src="assets/img/home.png" class="w-p100" alt="">
            </div>
            <div class="col-md-6 ps-4">
                <p class="text-dark m-2">
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
        <div class="mt-5 mb-2 text-center">
            <a href="/" class="primary fs-2"><b>Visit all of our website contents</b></a>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/jquery.mask.min.js') }}"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
    Stripe.setPublishableKey('{{ env("STRIPE_KEY") }}');
    var gProductName = '';
    var gCount = 0;
    var gSubAmount = 0;
    $(document).ready(function(){
        @if(session('error'))
            $(".donate-div").hide();
            $(".payment-div").show();
        @else
            $(".donate-div").show();
            $(".payment-div").hide();
        @endif

        $('#card-number').mask('0000 0000 0000 0000');
        $('#expirey-date').mask('00/00');
        $('#cvc').mask('0000');
        $('#phone-number').mask('(999)-999-9999');
    })
    // Donate
    $(".btn-add").click(function(){
        let index = $(this).attr('data-id');
        let value = $(".qty-" + index).val();
        value  = parseInt(value);
        value = value + 1;
        $(".qty-" + index).val(value);
        if ($(".product-select").eq(index).is(":checked")) {
            $(".product-select").eq(index).trigger("change");
        }
    })

    $(".btn-sub").click(function(){
        let index = $(this).attr('data-id');
        let value = $(".qty-" + index).val();
        value  = parseInt(value);
        value = value - 1;
        if(value >= 1){
            $(".qty-" + index).val(value);
        }
        if ($(".product-select").eq(index).is(":checked")) {
            $(".product-select").eq(index).trigger("change");
        }
    })

    $(".product-select").change(function(){
        let index = $(this).attr('data-id');
        let productName = $(this).attr("data-product-name");
        let amount = $(this).attr("data-product-amount");
        let count = $(".qty-" + index).val();
        amount = parseFloat(amount);
        count = parseInt(count);
        let total = amount * count;
        total = total.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        html = '<div class="border-bottom border-secondary-subtle border-2 p-3">' +
                    '<div class="d-flex justify-content-between">' +
                        '<p class="mb-0 fs-5">' + productName + " x " + count + '</p>' +
                        '<p class="mb-0 fs-5">$' + total + '</p>' +
                    '</div>' +
                '</div>';
        $(".detail-info").html(html);
        $(".total-amount").text(total);
    });

    $(".btn-donate").click(function(){
        let index = $(".product-select:checked").attr('data-id');
        if(typeof index !== 'undefined'){
            let productName = $(".product-select:checked").attr("data-product-name");
            let amount = $(".product-select:checked").attr("data-product-amount");
            let count = $(".qty-" + index).val();
            gSubAmount = amount = parseFloat(amount);
            count = parseInt(count);
            let total = amount * count;
            amount = amount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            total = total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $(".donate-div").hide();
            $(".payment-div").show();
            $(".product-name").text(productName);
            $(".product-amount").text(amount);
            $(".count").text(count);
            $(".total-amount").text(total);
            gCount = count;
            gProductName = productName;
            $('button[type=submit]').text('Pay ' + "$" + total);
        }else{
            alert("Please select the product!");
        }
    })

    //Payment
    $('#first-name').change(function(){
        let fistName = $(this).val();
        validateRequired('first-name', fistName);
    });

    $('#last-name').change(function(){
        let lastName = $(this).val();
        validateRequired('last-name', lastName);
    });

    $('#email').change(function(){
        let email = $(this).val();
        validateEmail(email);
    });

    $('#card-number').change(function(){
        let ccNum = $(this).val();
        validateCardNumber(ccNum);
    });

    $('#expirey-date').change(function(){
        let expDate = $(this).val();
        validateExpiredDate(expDate)
    });

    $('#cvc').change(function(){
        let cvcNum = $(this).val();
        let flag = validateCVC(cvcNum);
        return true;
    });

    function validateRequired(selector, value){
        if (!value.length) {
            reportError(selector, 'The ' + selector.replace('-', '') + ' appears to be invalid.');
        }else{
            reportSuccess(selector);
        }
    }

    function validateEmail(value){
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if(!value.length || !emailPattern.test(value)){
            reportError('email', 'The email appears to be invalid.');
        }else{
            reportSuccess('email');
        }
    }

    function validateCardNumber(ccNum){
        if (!Stripe.card.validateCardNumber(ccNum)) {
            reportError('card-number', 'The credit card number appears to be invalid.');
        }else{
            reportSuccess('card-number');
        }
    }

    function validateExpiredDate(expDate){
        let expData = expDate.split('/');
        let expMonth = expData[0];
        let expYear = expData[1];
        if (!Stripe.card.validateExpiry(expMonth, expYear)) {
            reportError('expirey-date', 'The expiration date appears to be invalid.');
        }else{
            reportSuccess('expirey-date');
        }
    }

    function validateCVC(cvcNum){
        if (!Stripe.card.validateCVC(cvcNum)) {
            reportError('cvc', 'The CVC number appears to be invalid.');
        }else{
            reportSuccess('cvc');
        }
    }

    function reportError(selector, msg){
        if (!$('#' + selector).hasClass('is-invalid')) {
            $('#' + selector).addClass('is-invalid');
            let html = '<div class="invalid-feedback">' + msg + '</div>';
            $('#' + selector).parent().append(html);
        }
    }

    function reportSuccess(selector){
        $('#' + selector).removeClass('is-invalid');
        $('#' + selector).parent().find('.invalid-feedback').remove();
    }

    $("button[type=submit]").click(function(e){
        event.preventDefault();
        $('#first-name').trigger('change');
        $('#last-name').trigger('change');
        $('#email').trigger('change');
        $('#card-number').trigger('change');
        $('#expirey-date').trigger('change');
        $('#cvc').trigger('change');
        let invalidCount = $('form').find('.is-invalid').length;
        if(!invalidCount){
            let ccNum = $('#card-number').val();
            let cvcNum = $('#cvc').val();
            let expDate = $('#expirey-date').val();
            expDate = expDate.split('/');
            let expMonth = expDate[0];
            let expYear = expDate[1];
            Stripe.card.createToken({
                number: ccNum,
                cvc: cvcNum,
                exp_month: expMonth,
                exp_year: expYear
            }, stripeResponseHandler);
            return;
        }
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            console.log(response.error.message);
        } else {
            var form = $("form");
            var token = response['id'];
            console.log('token', token);
            console.log('gSubAmount', gSubAmount);
            form.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            form.append("<input type='hidden' name='product_name' value='" + gProductName + "' />");
            form.append("<input type='hidden' name='count' value='" + gCount + "' />");
            form.append("<input type='hidden' name='sub_amount' value='" + gSubAmount + "' />");
            form.get(0).submit();
        }
    }

    $('.btn-cancel').click(function(){
        $(".donate-div").show();
        $(".payment-div").hide();
    })
</script>
@endsection
