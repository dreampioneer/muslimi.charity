@extends('layouts.layouts')
@section('style')
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<section class="faq">
    <div class="container position-relative">
        <h2 class="text-center fw-bold fs-1 mb-4">FAQs</h2>
        <h5 class="text-center mb-4 fs-4 text-secondary">Have questions? We’ve got answers</h5>
        @php
            $faqs = [
                [
                    "title" => "If you created your monthly subscription on our website 👇",
                    "class" => "subscription",
                    "content" => [
                        [
                            "subtitle" => "How can I change or cancel my subscription?",
                            "subcontent" => "Email us at info@muslimi.charity and someone from our Customer Support team will get back to you.",
                        ],
                        [
                            "subtitle" => "How can I change my payment method?",
                            "subcontent" => "Email us at info@muslimi.charity and someone from our Customer Support team will get back to you.",
                        ]
                    ]
                ],
                [
                    "title" => "Donations",
                    "class" => "donation",
                    "content" => [
                        // [
                        //     "subtitle" => "What do children receive for $0.80?",
                        //     "subcontent" => "Food assistance provided by the World Food Programme varies depending on the situation and the specific needs of the community being helped. Where there is plenty of food in the marketplace but people can't afford to buy it, cash transfers, vouchers or cash are given to families to help them purchase food. In emergencies, WFP often provides high-energy biscuits, hot meals and food packages. WFP is also the largest provider of school meals to children around the world. Visit goals in the app to see the specific type of assistance being given."
                        // ],
                        [
                            "subtitle" => "Can I give monthly?",
                            "subcontent" => "Yes, you can give monthly to help people in need. Please choose your desired donation amount and, if applicable, select the checkbox labeled \"Give this amount monthly\" situated above the \"Dedicate this donation\" input field."
                        ],
                        // [
                        //     "subtitle" => "Are my donations tax-deductible?",
                        //     "subcontent" => "Donations are tax-deductible in several countries including the United States, Germany, Canada, the Netherlands, France and South Korea, as well as some regions of Australia. You will find more details on the respective donation receipt or yearly donation summary, e.g.: In the United States, we are working together with WFP USA, who is is a 501c (3) tax-exempt organization to ensure the tax deductability of your donations. The Federal Identification (EIN) Number is 13-3843435. In Germany, we are working together with the Maecenata Foundation (tax id 143/235/55436), who are forwarding the donations to WFP. Where tax-deductibility of donations is not currently possible, the donation is considered a personal gift."
                        // ],
                    ]
                ],
                [
                    "title" => "Security and payment",
                    "class" => "security-payment",
                    "content" => [
                        [
                            "subtitle" => "How do I know my financial information is protected?",
                            "subcontent" => "Your security is of utmost importance to us. Our app is based on modern security standards and we take your security and privacy very seriously, going above and beyond to ensure that your payment information is safe. All payment data is processed by our partner Braintree/Paypal. Our infrastructure is served via HTTPS, so that your smartphone only communicates with our server over a secure channel. Your financial information is managed securely on our behalf by Braintree, a PayPal company and globally trusted (Level 1 DSS PCI compliant) payments company. The app does not retrieve any additional data. All communication is end-to-end encoded (SHA-256 with RSA-encryption). Unintentional donations will be returned immediately. Should you have a question about your online payment, please contact us at info@muslimi.charity."
                        ],
                        [
                            "subtitle" => "Why was my credit card declined?",
                            "subcontent" => "Credit card companies and banks decline cards for many reasons. To ensure your financial information remains secure, MUSLIMI does not receive details about why your card was declined. Unfortunately, this means we cannot resolve the problem for you. If your card is declined, please contact your credit card company or bank for help completing your payment."
                        ],
                        [
                            "subtitle" => "Why is a second confirmation step necessary for some donations?",
                            "subcontent" => "Some card issuers may request additional steps to verify your identity. These steps depend on your bank and may include fingerprint, text message or an additional password. The MUSLIMI app will help you navigate through these steps."
                        ],
                    ]
                ]
            ];
        @endphp
        <div class="rol-12">
            <div class="accordion accordion-flush" id="faqlist">
                @foreach ($faqs as $faq)
                    <div class="mt-5 position-relative">
                        <h3 class="pt-5 pb-4 position-relative fw-semibold">{{ $faq["title"] }}</h3>
                        @foreach ($faq["content"] as $index => $item)
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq["class"] }}-{{ $index }}">
                                        {{ $item["subtitle"] }}
                                    </button>
                                </h3>
                                <div id="faq-{{ $faq["class"] }}-{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        {{ $item["subcontent"] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
