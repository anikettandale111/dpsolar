<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Product;
use Illuminate\View\View;
use App\Helpers\DeviceHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreReviewsRequest;
use App\Http\Requests\UpdateReviewsRequest;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('reviews.index', [
            'reviews' => Reviews::join('products','reviews.product_id','=','products.pid')
            ->select('products.product_name', 'reviews.*')
            ->where(['reviews.is_delete' => 0,'reviews.is_active'=>1])
            ->orderBy('id')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $product = Product::where(['is_delete' => 0, 'is_active' => 1])->get();
        return view('reviews.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewsRequest $request): RedirectResponse
    {
        $input = $request->all();
        $reviews = Reviews::create($input);
        return redirect()->route('reviews.index')->withSuccess('Reviews is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reviews $reviews): View
    {
        return view('reviews.show', [
            'reviews' => $reviews
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,Reviews $reviews): View
    {   
        $product = Product::where(['is_delete' => 0, 'is_active' => 1])->get();
        return view('reviews.edit', [
            'reviews' => Reviews::where('id', $id)->first(),
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewsRequest $request, Reviews $reviews,$id): RedirectResponse
    {   
        $reviews = Reviews::findOrFail($id);
        $res = $reviews->update($request->all());
        
        return redirect()->route('reviews.index')
        ->withSuccess('Reviews is updated successfully.');
        if (empty($request->from)) {
        } else {
            return redirect()->route('profile')
                ->withSuccess('Reviews is updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviews $reviews,$id): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if (auth()->user()->id > 2) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
        Reviews::where('id',$id)->update(['is_delete' => 1]);
        return redirect()->route('reviews.index')->withSuccess('Reviews is deleted successfully.');
    }
}
