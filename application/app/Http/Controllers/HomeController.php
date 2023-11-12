<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{
    public function index(){
        SEOTools::setTitle('Home');
        SEOTools::setDescription("Our charity partners are delivering aid to our brothers and sisters in Gaza.
        The overall death toll in Palestine is 8,000+ (40% are children), and over 21,000+ are injured. 2.3 million people are at risk.
        Muslimi is working with our charity partners to ensure your aid is delivered in Gaza. Your donation is an Amana, which will reach our partners on the ground. Our charity partners have emergency aid stockpiles and are getting resources from within Gaza; though these resources are being reduced daily, they are being replenished as the Egypt-Rafah border crossing is slowly letting aid in inshaAllah.
        The Rafah border crossing between Egypt and Gaza has opened to let needed aid flow to Palestinians running short of food, medicine, and water in Gaza. Meanwhile, aid deliveries have come as the Israeli military continued bombing Gaza and Rafah.
        Your donation right now can be the lifeline for many in Gaza. Let's unite in this hour of dire need and show that the Ummah stands united with the innocent civilians in Gaza.
        Supply a family with a month's supply of Hot Meals - $56.00
        Supply 2 families with a month's supply of Hot Meals - $112.00
        Supply 5 families with a month's supply of Hot Meals - $280.00
        Supply 10 families with a month's supply of Hot Meals - $560.00
        Supply 20 families with a month's supply of Hot Meals - $1,120.00
        Emergency Medical Supplies to Hospitals - $200
        Emergency Shelter - $500
        Emergency Aid Combo (Meals, Water, Aid, Shelter) - $1,000");
        SEOTools::opengraph()->setUrl(route("home.index"));
        SEOTools::setCanonical(route("home.index"));
        SEOTools::opengraph()->addProperty('type', 'home');
        SEOTools::jsonLd()->addImage([asset('assets/img/home.png'), asset('assets/video/What_are_the_Rules_of_War_thumbnail.jpg')]);
        return view('home');
    }

    public function donate(){
        SEOTools::setTitle('Donate');
        SEOTools::setDescription("Our charity partners are delivering aid to our brothers and sisters in Gaza.
        The overall death toll in Palestine is 8,000+ (40% are children), and over 21,000+ are injured. 2.3 million people are at risk.
        Muslimi is working with our charity partners to ensure your aid is delivered in Gaza. Your donation is an Amana, which will reach our partners on the ground. Our charity partners have emergency aid stockpiles and are getting resources from within Gaza; though these resources are being reduced daily, they are being replenished as the Egypt-Rafah border crossing is slowly letting aid in inshaAllah.
        The Rafah border crossing between Egypt and Gaza has opened to let needed aid flow to Palestinians running short of food, medicine, and water in Gaza. Meanwhile, aid deliveries have come as the Israeli military continued bombing Gaza and Rafah.
        Your donation right now can be the lifeline for many in Gaza. Let's unite in this hour of dire need and show that the Ummah stands united with the innocent civilians in Gaza.
        Supply a family with a month's supply of Hot Meals - $56.00
        Supply 2 families with a month's supply of Hot Meals - $112.00
        Supply 5 families with a month's supply of Hot Meals - $280.00
        Supply 10 families with a month's supply of Hot Meals - $560.00
        Supply 20 families with a month's supply of Hot Meals - $1,120.00
        Emergency Medical Supplies to Hospitals - $200
        Emergency Shelter - $500
        Emergency Aid Combo (Meals, Water, Aid, Shelter) - $1,000
        What are the Rules of War? | The Laws of War");
        SEOTools::opengraph()->setUrl(route("home.donate"));
        SEOTools::setCanonical(route("home.donate"));
        SEOTools::opengraph()->addProperty('type', 'donate');
        SEOTools::jsonLd()->addImage(asset('assets/img/home.png'));
        $donates = DonateHistory::orderBy('created_at', 'desc')->limit(5)->get();
        return view('donate', ['donates' => $donates]);
    }

    public function thanks($donate_history_id){
        $donate = DonateHistory::with('detail')->find($donate_history_id);
        return view('thanks', ['donate' => $donate]);
    }
}
