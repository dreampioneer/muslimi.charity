<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{
    public function index(){
        SEOTools::setDescription("Support Muslimi's humanitarian efforts to aid our brothers and sisters in Gaza. Your donation serves as an Amana, ensuring vital aid reaches those in need. With an alarming death toll and countless injuries, your contribution can be a lifeline for families facing shortages of food, medicine, and water. Our charity partners are actively delivering emergency aid, and your support will help supply hot meals, medical supplies, shelter, and comprehensive aid packages to those affected. Stand united with the Ummah in this critical hour and make a difference for the innocent civilians in Gaza.");
        SEOTools::opengraph()->setUrl(route("home.index"));
        SEOTools::setCanonical(route("home.index"));
        SEOTools::opengraph()->addProperty('type', 'home');
        SEOTools::jsonLd()->addImage([asset('assets/img/home.png'), asset('assets/video/What_are_the_Rules_of_War_thumbnail.jpg')]);
        return view('home');
    }

    public function donate(){
        SEOTools::setDescription("Support Muslimi's humanitarian efforts to aid our brothers and sisters in Gaza. Your donation serves as an Amana, ensuring vital aid reaches those in need. With an alarming death toll and countless injuries, your contribution can be a lifeline for families facing shortages of food, medicine, and water. Our charity partners are actively delivering emergency aid, and your support will help supply hot meals, medical supplies, shelter, and comprehensive aid packages to those affected. Stand united with the Ummah in this critical hour and make a difference for the innocent civilians in Gaza.");
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
