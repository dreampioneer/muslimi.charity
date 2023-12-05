<!DOCTYPE html>
<head></head>
<body></body>
<script type="text/javascript">
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );
    const status = '3DS-authentication-complete';
    // const msg = JSON.stringify({status, clientSecret});
    window.top.postMessage({status, clientSecret});
</script>
