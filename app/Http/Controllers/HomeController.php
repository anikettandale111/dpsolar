<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DeviceHelper;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('frontend','contact');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function frontend()
    {
        $category = Category::where(['is_delete' => 0, 'is_active' => 1])
            ->orderBy('id')
            ->get();

        $subcategory = Subcategory::join('categories', 'categories.id', '=', 'subcategories.cat_id')
            ->select('categories.category_name', 'subcategories.*')
            ->where(['subcategories.is_delete' => 0, 'subcategories.is_active' => 1])
            ->orderBy('sid')
            ->get();

        $product = Product::join('categories', 'categories.id', '=', 'products.cat_id')
            ->join('subcategories', 'subcategories.sid', '=', 'products.sub_cat_id')
            ->select('categories.category_name', 'subcategories.sub_cat_name', 'products.*')
            ->where(['products.is_delete' => 0, 'products.is_active' => 1])
            ->orderBy('pid')
            ->get();
        return view('welcome',compact('category','subcategory','product'));
    }
    public function profile()
    {
        return view('users.profile');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
