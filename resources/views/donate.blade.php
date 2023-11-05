@extends('layouts.layouts')
@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-4">YOUR  DONATEION IS ZAKAT-ELIGIBLE</h4>
                <h4 class="mb-2">Recent donations</h4>
                @foreach ([1,2,3,4,5] as $item)
                    <div class="border border-secondary-subtle border-2 px-4 py-3 recent-donation mb-3">
                        <div class="d-flex justify-content-between">
                            <div class="donation-info">
                                <p><b>Imran M.</b> made a one-time donation</p>
                                <div class="d-flex">
                                    <p class="m-0">Lahore, Pakistan</p><span class="dot m-auto"></span><p class="m-0">11 minutes age</p>
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
                <div>
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
<script type="text/javascript">
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
        total = total.toLocaleString({
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
            amount = parseFloat(amount);
            count = parseInt(count);
            let total = amount * count;
            $.cookie.json = true;
            $.cookie('cart', {productName, amount, count, total}, { expires: 1, secure: true });
            window.location.href = '/checkout';
        }else{
            alert("Please select the product!");
        }
    })
</script>
@endsection
