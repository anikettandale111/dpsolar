<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\Reviews;
use Illuminate\View\View;
use App\Helpers\DeviceHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'productlist']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('products.index', [
            'product' => Product::join('categories', 'categories.id', '=', 'products.cat_id')
                ->join('subcategories', 'subcategories.sid', '=', 'products.sub_cat_id')
                ->select('categories.category_name', 'subcategories.sub_cat_name', 'products.*')
                ->orderBy('pid')
                ->paginate(1000)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create', [
            'category' => Category::where(['is_delete' => 0, 'is_active' => 1])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $input = $request->all();
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = str_replace(' ', '_', time() . '-' . $file->getClientOriginalName());
                $filesName[] = $file->storeAs('uploads', $filename, 'public');
            }
        }
        $input['images'] = json_encode($filesName);

        $product = Product::create($input);

        return redirect()->route('products.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($product): View
    {
        $hide_main_css = 1;
        list($id, $hash) = explode(config('app.id_seperator'), $product);
        if (DeviceHelper::verifyHash($id, $hash)) {
            $product = Product::findOrFail($id);
            $reviews = Reviews::where(['product_id' => $id, 'is_delete' => 0, 'is_active' => 1])->get();
            return view('products.show', [
                'product' => $product,
                'hide_main_css' => $hide_main_css,
                'reviews' => $reviews
            ]);
        } else {
            return abort(404); // or handle the error as needed
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        // Check Only Super Admin can update his own Profile
        if ($product->hasRole('Super Admin')) {
            if ($product->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        return view('products.edit', [
            'product' => Product::where('pid', $product->pid)->first(),
            'category' => Category::where(['is_delete' => 0, 'is_active' => 1])->get(),
            'subcategory' => Subcategory::where(['is_delete' => 0, 'is_active' => 1])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $input = $request->all();
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = str_replace(' ', '_', time() . '-' . $file->getClientOriginalName());
                $filesName[] = $file->storeAs('uploads', $filename, 'public');
            }
        }
        if (isset($filesName) && count($filesName)) {
            $filesName = array_merge($filesName, $input['old_images']);
        } else {
            $filesName = $input['old_images'];
        }
        $input['images'] = json_encode($filesName);

        $product->update($input);

        return redirect()->route('products.index')->withSuccess('Product is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if (auth()->user()->id > 2) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
        Product::where('pid', $product->pid)->update(['is_delete' => 1]);
        return redirect()->route('products.index')->withSuccess('Product deleted successfully.');
    }

    public function productlist()
    {
    //     $post = [
    //         'api_id' => 'APISDzNobqM134172',
    //         'api_password' => 'bmqM5cvz',
    //         'sms_type'   => 'Promotional',
    //         'sms_encoding' => 'Text',
    //         'sender' => 'HDTSMS',
    //         'number' => '8149136961',
    //         'message' => 'THIS IS TEST MESSAGE TO START BULK SMS SERVICE WITH '.rand(111111,999999).' HENCE DIGITAL',
    //         'template_id' => '166698',
    //     ];
    //     $data_string = json_encode($post);
    //     $ch = curl_init('http://bulksmsplans.com/api/verify');
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch,CURLOPT_HTTPHEADER,
    //         array(
    //             'Content-Type: application/json',
    //             'Content-Length: ' . strlen($data_string)
    //         )
    //     );
    // $result = curl_exec($ch);
    // echo $result;
    // dd();
        return view('frontend.productlist', [
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
