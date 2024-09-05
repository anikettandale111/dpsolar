<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\View\View;
use App\Helpers\DeviceHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;

class SubCategoryController extends Controller
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
        return view('subcategory.index', [
            'subcategory' => Subcategory::join('categories', 'categories.id', '=', 'subcategories.cat_id')
            ->select('categories.category_name', 'subcategories.*')
            ->orderBy('sid')
            ->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('subcategory.create', [
            'category' => Category::where(['is_delete'=>0,'is_active'=>1])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $input = $request->all();
        if ($request->hasfile('sub_cat_image')) {
            $filename = str_replace(' ', '_', time() . '-' . $request->file('sub_cat_image')->getClientOriginalName());
            $filesName = $request->file('sub_cat_image')->storeAs('uploads', $filename, 'public');
            $input['sub_cat_image'] = $filesName;       
        }
        $subcat = Subcategory::create($input);
        return redirect()->route('subcategory.index')
                ->withSuccess('Sub Category is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcat): View
    {
        return view('subcategory.show', [
            'user' => $subcat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory): View
    {
        // Check Only Super Admin can update his own Profile
        // if ($user->hasRole('Super Admin')){
        //     if($user->id != auth()->user()->id){
        //         abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        //     }
        // }
        $subcategory = Subcategory::join('categories', 'categories.id', '=', 'subcategories.cat_id')
        ->select('categories.id as catid', 'subcategories.*')
        ->where('subcategories.sid',$subcategory->sid)
        ->first();
        return view('subcategory.edit', [
            'subcategory' => $subcategory,
            'category' => Category::where(['is_delete'=>0,'is_active'=>1])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $input = $request->all();
        if ($request->hasfile('sub_cat_image')) {
            $filename = str_replace(' ', '_', time() . '-' . $request->file('sub_cat_image')->getClientOriginalName());
            $filesName = $request->file('sub_cat_image')->storeAs('uploads', $filename, 'public');
            $input['sub_cat_image'] = $filesName;       
        }else{
            $input['sub_cat_image'] = $input['old_image'];
        }
        $subcategory->update($input);

        return redirect()->route('subcategory.index')
        ->withSuccess('Sub-category is updated successfully.');
        if(empty($request->from)){
        }else{
            return redirect()->route('profile')
                ->withSuccess('Profile is updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if (auth()->user()->id > 2) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        Subcategory::where('sid',$subcategory->sid)->update(['is_delete' => 1]);
        return redirect()->route('subcategory.index')->withSuccess('Sub-category is deleted successfully.');
    }
    /**
     * Get SubCategories By Category ID
     */ 
    public function getSubcategories($catid){
        return response()->json(Subcategory::select('sid', 'sub_cat_name')->where(['cat_id'=>$catid,'is_delete'=>0,'is_active'=>1])->get());
    }
}
