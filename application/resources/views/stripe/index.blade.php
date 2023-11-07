@extends('layouts.layouts')

@section('content')
    <section>
        <div class="container">
            <form class="p-3" method="POST" action="{{ route('stripe.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">First Name&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first-name" name="first-name" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Last Name&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="" class="form-label">Email Address&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="" class="form-label">Phone (optional)</label>
                        <input type="text" class="form-control" id="phone-number" name="phone-number" placeholder="Phone Number">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="" class="form-label">Card Number&nbsp;<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="card-number" name="card-number" placeholder="Card Number">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Expirey Date&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="expirey-date" name="expirey-date" placeholder="Expirey Date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">CVC&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cvc" name="cvc" placeholder="CVC">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/jquery.mask.min.js') }}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey('{{ env("STRIPE_KEY") }}');
        $(document).ready(function() {
            $('#card-number').mask('0000 0000 0000 0000');
            $('#expirey-date').mask('00/00');
            $('#cvc').mask('0000');
            $('#phone-number').mask('(999)-999-9999');
        });

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
                form.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                form.get(0).submit();
            }
        }
    </script>
@endsection
