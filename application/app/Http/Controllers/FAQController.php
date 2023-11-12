<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
class FAQController extends Controller
{
    public function index(){
        SEOTools::setTitle('FAQ');
        SEOTools::setDescription("If you created your monthly subscription on our website
        How can I change or cancel my subscription?
        Change or cancel your monthly donation at any time by clicking the link in the footer of your email receipts.
        How can I change my payment method?
        Email us at info@muslimi.charity and someone from our Customer Support team will get back to you.
        What do children receive for $0.80?
        Food assistance provided by the World Food Programme varies depending on the situation and the specific needs of the community being helped. Where there is plenty of food in the marketplace but people can't afford to buy it, cash transfers, vouchers or cash are given to families to help them purchase food. In emergencies, WFP often provides high-energy biscuits, hot meals and food packages. WFP is also the largest provider of school meals to children around the world. Visit goals in the app to see the specific type of assistance being given.
        Can I give monthly?
        Yes, you can give monthly to help feed a child in need. Swipe to the right on the donation screen until you reach \"Give monthly\", then select how many children you want to help monthly. You will be notified via email each month when your payment is collected.
        Are my donations tax-deductible?
        Donations are tax-deductible in several countries including the United States, Germany, Canada, the Netherlands, France and South Korea, as well as some regions of Australia. You will find more details on the respective donation receipt or yearly donation summary, e.g.: In the United States, we are working together with WFP USA, who is is a 501c (3) tax-exempt organization to ensure the tax deductability of your donations. The Federal Identification (EIN) Number is 13-3843435. In Germany, we are working together with the Maecenata Foundation (tax id 143/235/55436), who are forwarding the donations to WFP. Where tax-deductibility of donations is not currently possible, the donation is considered a personal gift.
        How do I know my financial information is protected?
        Your security is of utmost importance to us. Our app is based on modern security standards and we take your security and privacy very seriously, going above and beyond to ensure that your payment information is safe. All payment data is processed by our partner Braintree/Paypal. Our infrastructure is served via HTTPS, so that your smartphone only communicates with our server over a secure channel. Your financial information is managed securely on our behalf by Braintree, a PayPal company and globally trusted (Level 1 DSS PCI compliant) payments company. The app does not retrieve any additional data. All communication is end-to-end encoded (SHA-256 with RSA-encryption). Unintentional donations will be returned immediately. Should you have a question about your online payment, please contact us at info@muslimi.charity.
        Why was my credit card declined?
        Credit card companies and banks decline cards for many reasons. To ensure your financial information remains secure, MUSLIMI does not receive details about why your card was declined. Unfortunately, this means we cannot resolve the problem for you. If your card is declined, please contact your credit card company or bank for help completing your payment.
        Why is a second confirmation step necessary for some donations?
        Some card issuers may request additional steps to verify your identity. These steps depend on your bank and may include fingerprint, text message or an additional password. The MUSLIMI app will help you navigate through these steps.");
        SEOTools::opengraph()->setUrl(route("faq.index"));
        SEOTools::setCanonical(route("faq.index"));
        SEOTools::opengraph()->addProperty('type', 'faq');
        return view('faq.index');
    }
}
