<!DOCTYPE html>
<head></head>
<body></body>
<script type="text/javascript">
    const type = new URLSearchParams(window.location.search).get(
        "type"
    );
    let clientSecret = '';
    if(type == 'setupIntent'){
        clientSecret = new URLSearchParams(window.location.search).get(
            "setup_intent_client_secret"
        );
    }
    if(type == 'paymentIntent'){
        clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );
    }
    const status = '3DS-authentication-complete';
    // const msg = JSON.stringify({status, clientSecret});
    window.top.postMessage({status, clientSecret, type});
</script>
