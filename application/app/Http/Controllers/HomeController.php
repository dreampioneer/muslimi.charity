<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Do_;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function donate(){
        $donates = DonateHistory::orderBy('created_at', 'desc')->limit(5)->get();
        return view('donate', ['donates' => $donates]);
    }

    public function thanks($donate_history_id){
        $donate = DonateHistory::with('detail')->find($donate_history_id);
        return view('thanks', ['donate' => $donate]);
    }
}
