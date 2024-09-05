<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;
use App\Helpers\DeviceHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['categorylist']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('category.index', [
            'category' => Category::orderBy('id')->paginate(150)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $input = $request->all(); 
        if ($request->hasfile('cat_image')) {
            $filename = str_replace(' ', '_', time() . '-' . $request->file('cat_image')->getClientOriginalName());
            $filesName = $request->file('cat_image')->storeAs('uploads', $filename, 'public');
            $input['cat_image'] = $filesName;       
        }
        $category = Category::create($input);
        return redirect()->route('category.index')->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        return view('category.show', [
            'user' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $input = $request->all();
        if ($request->hasfile('cat_image')) {
            $filename = str_replace(' ', '_', time() . '-' . $request->file('cat_image')->getClientOriginalName());
            $filesName = $request->file('cat_image')->storeAs('uploads', $filename, 'public');
            $input['cat_image'] = $filesName;       
        }else{
            $input['cat_image'] = $input['old_image'];
        }
        $category->update($input);

        return redirect()->route('category.index')
        ->withSuccess('Category is updated successfully.');
        if (empty($request->from)) {
        } else {
            return redirect()->route('profile')
                ->withSuccess('Category is updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if (auth()->user()->id > 2) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
        Category::where('id',$category->id)->update(['is_delete' => 1]);
        return redirect()->route('category.index')->withSuccess('Category is deleted successfully.');
    }
    public function categorylist(){
        return view('frontend.categorylist', [
            'product' => Product::join('categories', 'categories.id', '=', 'products.cat_id')
                ->join('subcategories', 'subcategories.sid', '=', 'products.sub_cat_id')
                ->select('categories.category_name', 'subcategories.sub_cat_name', 'products.*')
                ->orderBy('pid')
                ->get(),
            'category' => Category::where(['is_delete' => 0, 'is_active' => 1])
                ->orderBy('id')
                ->get()
        ]);        
    }
}
