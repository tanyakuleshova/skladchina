<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaticPage;


class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
    
    /**
     * Метод, 
     * @param int $id_blog
     * @return view
     */
    public function index(Request $request, $slug) {
        $page = StaticPage::where('slug',$slug)->firstOrFail();
        return view('front.pages.show',  compact('page'));
    }
  
    /**
     * Метод отображения страницы, 
     * @param int $id_blog
     * @return view
     */
    public function show(Request $request, $slug) {
        $page = StaticPage::where('slug',$slug)->firstOrFail();
        return view('front.pages.show',  compact('page'));
    }
    
}
