<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $reviews = Review::with('user')->where('show_on_home', true)->latest()->get();
        return view('components.Home.index', compact('reviews'));
    }
   
}
