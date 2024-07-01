<?php


namespace App\Http\Controllers;

use App\Models\SlideshowImage;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $slideshowImages = SlideshowImage::where('is_active', true)->get();
        return view('welcome', compact('slideshowImages'));
    }
}
