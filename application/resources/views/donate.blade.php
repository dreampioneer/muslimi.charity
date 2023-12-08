@extends('layouts.layouts')
@section('content')
    <section class="py-30">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-2 fw-bold">YOUR DONATEION IS ZAKAT-ELIGIBLE</h5>
                    <h6 class="mb-2 fw-semibold">Recent donations</h6>
                    @foreach ($donates as $donate)
                        <div class="border border-secondary-subtle border-1 px-4 py-3 recent-donation mb-3">
                            <div class="d-flex justify-content-between">
                                <div class="donation-info">
                                    <p class="mb-0"><b>{{ $donate->first_name }} {{ $donate->last_name }}</b></p>
                                    <div class="d-flex text-right">
                                        {{-- <p class="m-0">Lahore, Pakistan</p><span class="dot m-auto"></span> --}}
                                        @php
                                            $pastTime = \Carbon\Carbon::parse($donate->created_at);
                                            $currentTime = now();
                                            $diff = $pastTime->diff($currentTime);
                                            $days = $diff->days;
                                            $hours = $diff->h;
                                            $minutes = $diff->i;
                                            $seconds = $diff->s;
                                        @endphp
                                        <p class="m-0">
                                            @if ($days)
                                                {{ $days }} days
                                            @elseif($hours)
                                                {{ $hours }} hours
                                            @elseif($minutes)
                                                {{ $minutes }} minutes
                                            @else
                                                {{ $seconds }} seconds
                                            @endif ago
                                        </p>
                                    </div>
                                </div>
                                <div class="donation-amount">
                                    <p class="fs-4 m-0 text-primary"><b>{{ number_format($donate->price, 2, '.', ',') }} €
                                            (Euro)</b></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @php
                    $donateFoods = [
                        [
                            'priceId' => 'price_1OAvfgCJAyesaXH9OhRu0Dej',
                            'donate_name' => "Supply a family with a month's supply of Hot Meals",
                            'amount' => 56,
                        ],
                        [
                            'priceId' => 'price_1OAvfwCJAyesaXH9eytfjz4b',
                            'donate_name' => "Supply 2 families with a month's supply of Hot Meals",
                            'amount' => 112,
                        ],
                        [
                            'priceId' => 'price_1OAvgDCJAyesaXH92YF54Gi2',
                            'donate_name' => "Supply 5 families with a month's supply of Hot Meals",
                            'amount' => 280,
                        ],
                        [
                            'priceId' => 'price_1OAoEWCJAyesaXH9JerRyR1b',
                            'donate_name' => "Supply 10 families with a month's supply of Hot Meals",
                            'amount' => 560,
                        ],
                        [
                            'priceId' => 'price_1OAvgoCJAyesaXH91fXJGDYz',
                            'donate_name' => "Supply 20 families with a month's supply of Hot Meals",
                            'amount' => 1120,
                        ],
                    ];
                    $donateMedicalSupplies = [
                        [
                            'priceId' => 'price_1OAvh3CJAyesaXH9ZFnDI3J1',
                            'donate_name' => 'Emergency Medical Supplies to Hospitals',
                            'amount' => 200,
                        ],
                    ];
                    $donateShelter = [
                        [
                            'priceId' => 'price_1OAvhgCJAyesaXH9OO9kkC8a',
                            'donate_name' => 'Emergency Shelter',
                            'amount' => 500,
                        ],
                    ];
                    $donateAidCombo = [
                        [
                            'priceId' => 'price_1OAvhuCJAyesaXH93yooc4hs',
                            'donate_name' => 'Emergency Aid Combo (Meals, Water, Aid, Shelter)',
                            'amount' => 1000,
                        ],
                    ];
                    $donates = [
                        [
                            'title' => 'Donate for Food',
                            'class' => 'food',
                            'donateItems' => $donateFoods,
                        ],
                        [
                            'title' => 'Donate For Emergency Medical Supplies',
                            'class' => 'medical_supply',
                            'donateItems' => $donateMedicalSupplies,
                        ],
                        [
                            'title' => 'Donate for Emergency Shelter',
                            'class' => 'shelter',
                            'donateItems' => $donateShelter,
                        ],
                        [
                            'title' => 'Donate for Emergency Aid Combo',
                            'class' => 'aid_combo',
                            'donateItems' => $donateAidCombo,
                        ],
                    ];
                @endphp
                <div class="col-md-8">
                    <div class="donate-div">
                        <div class="donate-item-div">
                            <h5 class="mb-25 fw-bold">How much do you want to donate? Please select exact donation amount
                                below.</h5>
                            @foreach ($donates as $donate)
                                <div class="border border-secondary-subtle border-1 px-3 mb-25">
                                    <div class="d-flex donate-title ps-2">
                                        <input class="form-check-input fs-5 my-auto" type="checkbox"
                                            name="{{ $donate['class'] }}_checkbox">
                                        <h5 class="my-auto fw-semibold">&nbsp;&nbsp;{{ $donate['title'] }}</h5>
                                    </div>
                                    @foreach ($donate['donateItems'] as $index => $donateItem)
                                        @if (!$index)
                                            <div class="row p-2">
                                                <div class="col-md-4">
                                                    <p class="fs-5 mb-0 fw-semibold">Donation amount</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="fs-5 mb-0 fw-semibold">Donation description</p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="donate-item-div p-2">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="fs-6 mb-0">
                                                        <input class="form-check-input" type="radio"
                                                            name="{{ $donate['class'] }}_radio"
                                                            data-price-id="{{ $donateItem['priceId'] }}"
                                                            data-name="{{ $donateItem['donate_name'] }}"
                                                            data-amount="{{ $donateItem['amount'] }}">&nbsp;&nbsp;{{ number_format($donateItem['amount'], 2, '.', ',') }}
                                                        € (Euro)
                                                    </p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="mb-0">
                                                        {{ $donateItem['donate_name'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="bill-detial">
                            <h5 class="pb-3 fw-bold border-bottom border-1">Your Details</h5>
                            <div class="row my-4">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="" class="form-label">First Name&nbsp;<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first-name" name="first_name"
                                            placeholder="First Name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="" class="form-label">Last Name&nbsp;<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last-name" name="last_name"
                                            placeholder="Last Name" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="">
                                    <label for="" class="form-label">Email Address&nbsp;<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Email Address" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="">
                                    <label for="" class="form-label">Card Number&nbsp;<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="card-number" name="card_number"
                                        placeholder="Card Number" value="{{ old('card_number') }}">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="" class="form-label">Expiry Date&nbsp;<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="expirey-date" name="expirey_date" placeholder="mm/yy">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="" class="form-label">CVV&nbsp;<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cvc" name="cvc"
                                            placeholder="CVV">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Country&nbsp;<span
                                                class="text-danger">*</span></label>
                                        @php
                                            $countries = config("constants.countries");
                                        @endphp
                                        <select class="form-control" id="country" name="country">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country['value'] }}">{{ $country['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 code-div">
                                    <div>
                                        <label for="" class="form-label">&nbsp;<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control text-uppercase" id="code" name="code"
                                            placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="donate-detail-div">
                            <h5 class="mb-3 fw-bold">Your Donations</h5>
                            <div class="donate-detail">

                            </div>
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <input type="checkbox" class="form-check-input" id="is_monthly">
                                    <label class="form-check-label" for="is_monthly">&nbsp;&nbsp;Give this amount monthly
                                        (Optional)</label>
                                </div>
                                <div class="col-md-12 pb-4">
                                    <label for="" class="form-label">Dedicate this donation (Optional)</label>
                                    <input type="text" class="form-control" id="dedicate-this-donation"
                                        name="dedicate_this_donation" placeholder="Name of someone special"
                                        value="">
                                </div>
                                <div class="col-md-12 pb-4">
                                    <input type="checkbox" class="form-check-input" id="is_zakat">
                                    <label class="form-check-label" for="is_zakat">&nbsp;&nbsp;This donation is Zakat
                                        (Optional)</label>
                                </div>
                            </div>

                        </div>
                        <div class="w-p100">
                            <button class="btn btn-custom btn-normal w-p100 btn-donate">
                                Donate Now
                            </button>
                            <button type="button" class="btn btn-light btn-normal w-p100 mt-3 btn-cancel">
                                Cancel
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row gy-5">
                <div class="col-md-6 pe-4">
                    <img src="assets/img/home.png" class="w-p100" alt="gaza article">
                </div>
                <div class="col-md-6 ps-4">
                    <p class="text-dark m-2">
                        {!! config('constants.home_content') !!}
                    </p>
                </div>
            </div>
            <div class="mt-5 mb-2 text-center">
                <div class="mb-5">
                    <div class="line-div pt-5 mb-5">
                        <h2 class="w-p100 bordered text-center fw-bold fs-2">
                            <span>What are the Rules of War? | The Laws of War</span>
                        </h2>
                    </div>
                    <video class="w-p90" controls
                        poster="{{ asset('assets/video/What_are_the_Rules_of_War_thumbnail.jpg') }}">
                        <source src="{{ asset('assets/video/What_are_the_Rules_of_War.mp4') }}" type="video/mp4">
                    </video>
                </div>
                <a href="{{ route('home.index') }}" class="btn btn-custom btn-normal fs-3">
                    <b>Visit all of our website contents</b>
                </a>
            </div>
        </div>
    </section>

    <div class="modal fade" id="3ds_modal" tabindex="-1" data-backdrop="static" role="dialog"
        aria-labelledby="3ds_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="width: auto">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.inputmask.min.js') }}"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        const userInfo = {{ Js::from($currentUserInfo) }};
        Stripe.setPublishableKey('{{ env('STRIPE_KEY') }}');
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var flag = true;
        $(document).ready(function() {
            $('#3ds_modal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $(".donate-detail-div").hide();
            $(".bill-detial").hide();
            $(".btn-cancel").hide();
            $('#card-number').mask('0000 0000 0000 0000');
            $('#expirey-date').inputmask({
                mask: ['99/99'],
                placeholder: 'mm/yy',
                inputFormat: 'mm/yy',
                regex: '^((0[1-9])|(1[0-2]))/\\d{2}$'
            });
            $('#cvc').mask('0000');
            country = "AF";
            if(userInfo !== false){
                country = userInfo.countryCode;
            }
            $('#country').val(country);
            $('#country').trigger('change');
        })
        // Donate
        var donates = [];
        $('.donate-item-div input[type=checkbox]').change(function() {
            let checked = $(this).prop('checked');
            let name = $(this).attr('name');
            radioName = name.replace('checkbox', 'radio');
            if (checked) {
                $('input[name=' + radioName + ']').eq(0).prop('checked', true);
                donates.push({
                    'donate_price_id': $('input[name=' + radioName + ']').eq(0).attr('data-price-id'),
                    'donate_name': $('input[name=' + radioName + ']').eq(0).attr('data-name'),
                    'donate_amount': parseFloat($('input[name=' + radioName + ']').eq(0).attr(
                        'data-amount')),
                    'donate_count': 1
                });
            } else {
                let checkedDonateName = $('input[name=' + radioName + ']:checked').attr('data-name');
                $('input[name=' + radioName + ']').prop('checked', false);
                console.log(checkedDonateName);
                donates = donates.filter(item => item.donate_name !== checkedDonateName);
                console.log(donates);
            }
            calculateTotal();
        });

        $('.donate-item-div input[type=radio]').change(function() {
            let checked = $(this).prop('checked');
            let name = $(this).attr('name');
            let donateName = $(this).attr('data-name');
            checkboxName = name.replace('radio', 'checkbox');
            if (checked) {
                $('input[name=' + checkboxName + ']').prop('checked', true);
            }
            donates.push({
                'donate_name': donateName,
                'donate_amount': parseFloat($(this).attr('data-amount')),
                'donate_count': 1
            });
            let radioBoxes = $('input[name=' + name + ']');
            let filters = [];
            for (i = 0; i < radioBoxes.length; i++) {
                console.log(radioBoxes.eq(i).attr('data-name'));
                if (radioBoxes.eq(i).attr('data-name') !== donateName) {
                    filters.push(radioBoxes.eq(i).attr('data-name'))
                }
            }
            donates = donates.filter(item => !filters.includes(item.donate_name));
            calculateTotal();
        })

        function calculateTotal() {
            $(".donate-detail-div").show();
            if (!donates.length) {
                $(".donate-detail").html('');
                return 0;
            }
            let html = '';
            let totalAmount = 0;
            for (let i = 0; i < donates.length; i++) {
                totalAmount = totalAmount + parseFloat(donates[i]['donate_amount']) * parseInt(donates[i]['donate_count'])
                html = html + '<div class="row py-3 border-top border-1">' +
                    '<div class="col-md-6 d-flex">' +
                    '<p class="my-auto">' + donates[i]['donate_name'] + '</p>' +
                    '</div>' +
                    '<div class="col-md-1 d-flex p-0">' +
                    '<p class="my-auto">' + parseFloat(donates[i]['donate_amount']).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' € (Euro)</p>' +
                    '</div>' +
                    '<div class="col-md-3 d-flex ps-36">' +
                    '<div class="input-group my-auto">' +
                    '<button class="btn btn-outline-secondary btn-sub w-35" type="button" data-id="' + i +
                    '" data-amount="' + parseInt(donates[i]['donate_amount']) + '">-</button>' +
                    '<input type="number" class="form-control text-center qty-' + i + '" min="1" value="' + parseInt(
                        donates[i]['donate_count']) + '" data-id="' + i + '" data-amount="' + parseInt(donates[i][
                        'donate_amount'
                    ]) + '">' +
                    '<button class="btn btn-outline-secondary btn-add w-35" type="button" data-id="' + i +
                    '" data-amount="' + parseInt(donates[i]['donate_amount']) + '">+</button>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 d-flex">' +
                    '<p class="my-auto w-p100 fw-semibold text-right total-' + i + '">' + (parseFloat(donates[i][
                        'donate_amount'
                    ]) * parseInt(donates[i]['donate_count'])).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' € (Euro)</p>' +
                    '</div>' +
                    '</div>';
            }
            html = html + '<div class="row py-3 border-top border-1">' +
                '<div class="col-md-8">' +
                '<h5 class="fw-semibold">Total</h5>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<h5 class="total text-right fw-semibold">' + totalAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + ' € (Euro)</h5>' +
                '</div>' +
                '</div>';
            $(".donate-detail").html(html);
            $(".donate-detail input[type=number]").inputmask('Regex', {
                regex: "^[1-9][0-9]?$|^100000000000$"
            });
        }

        $(".donate-detail").on('keydown', 'input[type=number]', function(event) {
            if ($.inArray(event.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                // Allow Ctrl+A
                (event.keyCode == 65 && event.ctrlKey === true) ||
                // Allow Ctrl+C
                (event.keyCode == 67 && event.ctrlKey === true) ||
                // Allow Ctrl+V
                (event.keyCode == 86 && event.ctrlKey === true) ||
                // Allow Ctrl+X
                (event.keyCode == 88 && event.ctrlKey === true) ||
                // Allow home, end, left, right keys
                (event.keyCode >= 35 && event.keyCode <= 39)) {
                // Let it happen, don't do anything
                return;
            }

            // Ensure that it is a number and greater than zero, prevent the keypress if it's not
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) || parseInt($(this).val() + event
                .key) <= 0) {
                event.preventDefault();
            }
        })

        $(".donate-detail").on('change', 'input[type=number]', function(e) {
            if (e.target.value == '' || e.target.value == 0) {
                e.target.value = 1;
            }
            let index = $(this).attr('data-id');
            let amount = $(this).attr('data-amount');
            let value = e.target.value;
            amount = parseInt(amount);
            let subTotal = amount * value;
            subTotal = subTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('.total-' + index).text(subTotal + " € (Euro)");
            donates[index]['donate_count'] = value;
            let totalAmount = donates.reduce((total, item) => total + parseInt(item['donate_count']) * parseFloat(
                item['donate_amount']), 0);
            totalAmount = totalAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('.total').text(totalAmount + " € (Euro)");
        });

        $(".donate-div").on('click', '.btn-add', function() {
            let index = $(this).attr('data-id');
            let amount = $(this).attr('data-amount');
            let value = $(".qty-" + index).val();
            value = parseInt(value);
            value = value + 1;
            $(".qty-" + index).val(value);
            amount = parseInt(amount);
            let subTotal = amount * value;
            subTotal = subTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('.total-' + index).text(subTotal + " € (Euro)");
            donates[index]['donate_count'] = value;
            let totalAmount = donates.reduce((total, item) => total + parseInt(item['donate_count']) * parseFloat(
                item['donate_amount']), 0);
            totalAmount = totalAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            $('.total').text(totalAmount + " € (Euro)");
        })

        $(".donate-div").on('click', '.btn-sub', function() {
            let index = $(this).attr('data-id');
            let amount = $(this).attr('data-amount');
            let value = $(".qty-" + index).val();
            amount = parseInt(amount);
            value = parseInt(value);
            value = value - 1;
            if (value >= 1) {
                $(".qty-" + index).val(value);
                let subTotal = amount * value;
                subTotal = subTotal.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $('.total-' + index).text(subTotal + " € (Euro)");
                donates[index]['donate_count'] = value;
                let totalAmount = donates.reduce((total, item) => total + parseInt(item['donate_count']) *
                    parseFloat(item['donate_amount']), 0);
                totalAmount = totalAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $('.total').text(totalAmount + " € (Euro)");
            }
        })

        $(".btn-donate").click(function() {
            if (!donates.length) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: "Please select donation amount!",
                });
                return;
            }
            if (flag) {
                $(".donate-item-div").hide();
                $(".bill-detial").show();
                $(".btn-cancel").show();
            } else {
                $(".btn-donate").attr('disabled', 'disabled');
                html = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
                    "&nbsp;&nbsp;Donate Now";
                $(".btn-donate").html(html);
                $('#first-name').trigger('change');
                $('#last-name').trigger('change');
                $('#email').trigger('change');
                $('#card-number').trigger('change');
                $('#expirey-date').trigger('change');
                $('#cvc').trigger('change');
                $('#code').trigger('change');
                let invalidCount = $('.bill-detial').find('.is-invalid').length;
                if (!invalidCount) {
                    let ccNum = $('#card-number').val();
                    let cvcNum = $('#cvc').val();
                    let expDate = $('#expirey-date').val();
                    expDate = expDate.split('/');
                    let expMonth = expDate[0];
                    let expYear = expDate[1];
                    let country = $(this).find("option:selected").val();
                    let code = '';
                    if(country == 'GB' || country == 'US' || country == 'CA'){
                        code = $("#code").val();
                    }
                    Stripe.card.createToken({
                        number: ccNum,
                        cvc: cvcNum,
                        exp_month: expMonth,
                        exp_year: expYear,
                        address_country: country,
                        address_zip: code
                    }, stripeResponseHandler);
                    return;
                } else {
                    $(".btn-donate").attr('disabled', false);
                    $(".btn-donate").html('Donate Now');
                    return;
                }
            }
            $("html, body").animate({
                scrollTop: 0
            }, "fast");
            flag = !flag;
        })

        $('.btn-cancel').click(function() {
            if (flag) {
                $(".donate-item-div").hide();
                $(".bill-detial").show();
                $(".btn-cancel").show();
            } else {
                $(".donate-item-div").show();
                $(".bill-detial").hide();
                $(".btn-cancel").hide();
            }
            $("html, body").animate({
                scrollTop: 0
            }, "fast");
            flag = !flag;
        })

        //Payment
        $('#first-name').change(function() {
            let fistName = $(this).val();
            validateRequired('first-name', fistName);
        });

        $('#last-name').change(function() {
            let lastName = $(this).val();
            validateRequired('last-name', lastName);
        });

        $('#email').change(function() {
            let email = $(this).val();
            validateEmail(email);
        });

        $('#card-number').change(function() {
            let ccNum = $(this).val();
            validateCardNumber(ccNum);
        });

        $('#expirey-date').change(function() {
            let expDate = $(this).val();
            validateExpiredDate(expDate)
        });

        $('#cvc').change(function() {
            let cvcNum = $(this).val();
            validateCVC(cvcNum);
            return true;
        });

        $('#code').change(function() {
            let code = $(this).val();
            validateCode(code);
            return true;
        });

        $('#country').change(function(){
            let country = $(this).find("option:selected").val();
            console.log(country);
            if(country == 'GB' || country == 'US' || country == 'CA'){
                $('.code-div').show();
                if(country == 'US'){
                    $('.code-div label').text('Zip');
                    $('.code-div input').attr('placeholder', '12345');
                    $("#code").val('');
                    $("#code").mask('00000');
                }else{
                    $('.code-div label').text('Postal Code');
                    $('.code-div input').attr('placeholder', 'WS11 1DB');
                    $("#code").val('');
                    $("#code").unmask();
                }
            }else{
                $('.code-div').hide();
            }
        })

        function validateRequired(selector, value) {
            if (!value.length) {
                reportError(selector, 'The ' + selector.replace('-', ' ') + ' appears to be invalid.');
            } else {
                reportSuccess(selector);
            }
        }

        function validateEmail(value) {
            let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!value.length || !emailPattern.test(value)) {
                reportError('email', 'The email appears to be invalid.');
            } else {
                reportSuccess('email');
            }
        }

        function validateCardNumber(ccNum) {
            if (!Stripe.card.validateCardNumber(ccNum)) {
                reportError('card-number', 'The credit card number appears to be invalid.');
            } else {
                reportSuccess('card-number');
            }
        }

        function validateExpiredDate(expDate) {
            let expData = expDate.split('/');
            let expMonth = expData[0];
            let expYear = expData[1];
            if (!Stripe.card.validateExpiry(expMonth, expYear)) {
                reportError('expirey-date', 'The expiration date appears to be invalid.');
            } else {
                reportSuccess('expirey-date');
            }
        }

        function validateCVC(cvcNum) {
            if (!Stripe.card.validateCVC(cvcNum)) {
                reportError('cvc', 'The CVV number appears to be invalid.');
            } else {
                reportSuccess('cvc');
            }
        }

        function validateCode(code){
            let country = $(this).find("option:selected").val();
            if(country == 'US'){
                if(!code.length  || code.length !== 5){
                    reportError('code', 'The zip appears to be invalid.');
                }else{
                    reportSuccess('code');
                }
            }else{
                if(!code.length){
                    reportError('code', 'The postal code appears to be invalid.');
                }else{
                    reportSuccess('code');
                }
            }
        }

        function reportError(selector, msg) {
            if (!$('#' + selector).hasClass('is-invalid')) {
                $('#' + selector).addClass('is-invalid');
                let html = '<div class="invalid-feedback">' + msg + '</div>';
                $('#' + selector).parent().append(html);
            }
        }

        function reportSuccess(selector) {
            $('#' + selector).removeClass('is-invalid');
            $('#' + selector).parent().find('.invalid-feedback').remove();
        }

        function stripeResponseHandler(status, response) {
            if (response.error) {
                showToast("error", response.error.message);
            } else {
                var stripeToken = response['id'];
                let card_number = $('#card-number').val();
                let cvc = $('#cvc').val();
                let expirey_date = $('#expirey-date').val();
                let first_name = $('#first-name').val();
                let last_name = $('#last-name').val();
                let email = $('#email').val();
                let dedicate_this_donation = $('#dedicate-this-donation').val();
                let is_zakat = $('#is_zakat').prop('checked');
                let is_monthly = $('#is_monthly').prop('checked');
                $.ajax({
                    url: "{{ route('stripe.createPaymentIntent') }}",
                    method: 'POST',
                    data: {
                        stripeToken,
                        card_number,
                        cvc,
                        expirey_date,
                        first_name,
                        last_name,
                        email,
                        dedicate_this_donation,
                        is_zakat,
                        donates,
                        is_monthly
                    },
                    success: function(res) {
                        let data = JSON.parse(res);
                        if (data.status === 'requires_action') {
                            var iframe = document.createElement('iframe');
                            iframe.src = data.next_action.redirect_to_url.url;;
                            iframe.width = 500;
                            iframe.height = 600;
                            $('.modal-body').html(iframe);
                            $("#3ds_modal").modal("show");
                            return;
                        } else if (data.status === 'succeeded') {
                            createDonateHistory(data.id);
                        } else if (data.status === 'processing') {
                            showToast("success", "Your payment is processing.");
                        } else if (data.status === 'requires_payment_method') {
                            showToast("error", "Your payment was not successful, please try again.");
                        } else {
                            showToast("error", "Something went wrong.");
                        }
                    },
                    error: function(error) {
                        showToast("error", error.responseJSON.message);
                    }
                })
            }
        }

        async function on3DSComplete(type, client_secret) {
            let intent = '';
            if(type == 'paymentIntent'){
                const { paymentIntent } = await stripe.retrievePaymentIntent(client_secret);
                intent = paymentIntent;
            }
            if(type == 'setupIntent'){
                const { setupIntent } = await stripe.retrieveSetupIntent(client_secret);
                intent = setupIntent;
            }
            let first_name = $('#first-name').val();
            let last_name = $('#last-name').val();
            let email = $('#email').val();
            let dedicate_this_donation = $('#dedicate-this-donation').val();
            let is_zakat = $('#is_zakat').prop('checked');
            let is_monthly = $('#is_monthly').prop('checked');
            switch (intent.status) {
                case "succeeded":
                    if(type == 'paymentIntent'){
                        let data = {
                            first_name,
                            last_name,
                            email,
                            dedicate_this_donation,
                            is_zakat,
                            donates,
                            is_monthly,
                            payment_intent_id: intent.id
                        };
                        createDonateHistory(data);
                    }
                    if(type == 'setupIntent'){
                        let data = {
                            first_name,
                            last_name,
                            email,
                            dedicate_this_donation,
                            is_zakat,
                            donates,
                            is_monthly,
                            setup_intent_id: intent.id
                        };
                        createSubscription(data);
                    }
                    break;
                case "processing":
                    showToast("success", "Your payment is processing.");
                    break;
                case "requires_payment_method":
                    showToast("error", "Your payment was not successful, please try again.");
                    break;
                case "requires_confirmation":
                    if(type == 'paymentIntent'){
                        const response = await fetch("{{ route('stripe.confirmPaymentIntent') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                paymentIntentId: intent.id
                            }),
                        });
                        const data = await response.json();
                        if (data.status === "succeeded") {
                            createDonateHistory(paymentIntent.id);
                        } else {
                            showToast("error", "Something went wrong.");
                        }
                    }
                    break;
                default:
                    showToast("error", "Something went wrong.");
                    break;
            }
        }

        function showToast(status, msg) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: status,
                title: msg,
            });
            $(".btn-donate").attr('disabled', false);
            $(".btn-donate").html('Donate Now');
        }

        function createDonateHistory(data) {
            $.ajax({
                url: "{{ route('stripe.createDonateHistory') }}",
                method: 'POST',
                data: data,
                success: function(res) {
                    window.location.href = res.return_url;
                },
                error: function() {
                    showToast("error", "Something went wrong.");
                }
            })
        }

        function createSubscription(data){
            $.ajax({
                url: "{{ route('stripe.createSubscription') }}",
                method: 'POST',
                data: data,
                success: function(res) {
                    // window.location.href = res.return_url;
                },
                error: function() {
                    showToast("error", "Something went wrong.");
                }
            })
        }

        window.addEventListener('message', function(ev) {
            if (typeof ev.data.status !== 'undefined' && ev.data.status === '3DS-authentication-complete') {
                $("#3ds_modal").modal("hide");
                $('.modal-body').html('');
                if (ev.data.clientSecret) {
                    console.log(ev.data.type);
                    console.log(ev.data.clientSecret);
                    on3DSComplete(ev.data.type, ev.data.clientSecret);
                }
            }
        }, false);
    </script>
@endsection
