@extends('layouts.layouts')
@section('content')
<section>
    <div class="container">
        <div class="bill-details">
            <h3 class="mb-4">Billing Details</h3>
            <div class="row">
                <div class="col-md-6">
                    <form class="p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="" class="form-label">Email Address</label>
                                <input type="text" class="form-control" id="" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="" class="form-label">Phone (optional)</label>
                                <input type="text" class="form-control" id="" placeholder="Phone Number">
                            </div>
                        </div>
                    </form>
                    <h3 class="my-4">Your Donation</h3>
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
                            <p class="fs-5 mb-0 product-name"></p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-5 mb-0">$<span class="product-amount"></span></p>
                        </div>
                    </div>
                    <div class="row p-3 border-top">
                        <div class="col-md-9">
                            <p class="fs-5 mb-0">Count</p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-5 mb-0 count"></p>
                        </div>
                    </div>
                    <div class="row p-3 border-top">
                        <div class="col-md-9">
                            <p class="fs-4 mb-0"><b>Total</b></p>
                        </div>
                        <div class="col-md-3">
                            <p class="fs-4 mb-0"><b>$<span class="total-amount"></span></b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-form">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        let cookies = $.cookie('cart');
        if(typeof cookies !== 'undefined'){
            cookies = JSON.parse(cookies);
            $(".product-name").text(cookies.productName);
            $(".product-amount").text(cookies.amount);
            $(".count").text(cookies.count);
            $(".total-amount").text(cookies.total);
        }else{
            $(".bill-details").remove();
        }
    })
</script>
@endsection()
