<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use Stevebauman\Location\Facades\Location;
use App\Models\ContentInfo;
class HomeController extends Controller
{
    public function index(){
        SEOTools::setTitle('Home - MUSLIMI');
        SEOTools::setDescription(config('constants.home_content'));
        SEOTools::opengraph()->setUrl(route("home.index"));
        SEOTools::setCanonical(route("home.index"));
        SEOTools::opengraph()->addProperty('type', 'home');
        SEOTools::jsonLd()->addImage([asset('assets/img/home.png'), asset('assets/video/What_are_the_Rules_of_War_thumbnail.jpg')]);
        $contentInfo = ContentInfo::orderBy('created_at', 'desc')->first();
        return view('home', ['contentInfo' => $contentInfo]);
    }

    public function donate(Request $request){
        SEOTools::setTitle('Donate - MUSLIMI');
        SEOTools::setDescription(config('constants.home_content'));
        SEOTools::opengraph()->setUrl(route("home.donate"));
        SEOTools::setCanonical(route("home.donate"));
        SEOTools::opengraph()->addProperty('type', 'donate');
        SEOTools::jsonLd()->addImage(asset('assets/img/home.png'));
        $donates = DonateHistory::orderBy('created_at', 'desc')->limit(5)->get();
        if(env('APP_ENV') !== 'production'){
            $ip = "154.21.209.10"; // $request->ip();
        }else{
            $ip = $request->ip();
        }
        $currentUserInfo = Location::get($ip);
        $contentInfo = ContentInfo::orderBy('created_at', 'desc')->first();
        return view('donate', [
            'donates' => $donates,
            'currentUserInfo' => $currentUserInfo,
            'contentInfo' => $contentInfo
        ]);
    }

    public function thanks($donate_history_id){
        SEOTools::setTitle('Thanks - MUSLIMI');
        $donate = DonateHistory::with('detail')->find($donate_history_id);
        return view('thanks', ['donate' => $donate]);
    }
}
