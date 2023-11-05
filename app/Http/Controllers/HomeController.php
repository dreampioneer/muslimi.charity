<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function donate(){
        $donates = DonateHistory::orderBy('created_at', 'desc')->limit(5)->get();
        return view('donate', ['donates' => $donates]);
    }
}
