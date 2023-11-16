<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
class FAQController extends Controller
{
    public function index(){
        SEOTools::setTitle('FAQs - MUSLIMI');
        SEOTools::setDescription("Changing or Canceling Subscription:
        Visit the link in your email receipts to change or cancel your monthly donation anytime.
        Changing Payment Method:
        Email us at info@muslimi.charity, and our Customer Support will assist you.
        $0.80 Donation for Children:
        WFP provides food assistance based on needs, including cash transfers, vouchers, high-energy biscuits, and school meals. Check the app for specific details.
        Monthly Giving:
        Swipe right on the donation screen, select \"Give monthly,\" and choose the number of children to help. Receive monthly payment notifications via email.
        Tax Deductibility:
        Donations are tax-deductible in countries like the US, Germany, Canada, Netherlands, France, South Korea, and certain Australian regions. Check your donation receipt for details.
        Financial Information Security:
        We prioritize your security. The app follows modern standards, encrypts data (SHA-256 with RSA), and uses Braintree/Paypal for secure payment processing. Contact info@muslimi.charity for payment-related questions.
        Credit Card Decline:
        Contact your credit card company or bank for help if your card is declined. We do not receive details for security reasons.
        Second Confirmation Step:
        Some donations may require additional steps for identity verification, like fingerprints or text messages. The MUSLIMI app guides you through these steps.");
        SEOTools::opengraph()->setUrl(route("faq.index"));
        SEOTools::setCanonical(route("faq.index"));
        SEOTools::opengraph()->addProperty('type', 'faq');
        return view('faq.index');
    }
}
